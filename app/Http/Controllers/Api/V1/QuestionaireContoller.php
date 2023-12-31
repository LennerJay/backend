<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use PDOException;
use App\Models\Questionaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionaireRequest;
use App\Http\Resources\QuestionaireResource;
use App\Models\Criteria;
use App\Service\Controller\QuestionaireService;
use App\Service\Controller\QuestionService;

class QuestionaireContoller extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Questionaire::class,'questionaire',['except'=>['withCriterias']]);
    }


    public function index()
    {
        return $this->return_success(QuestionaireResource::collection(Questionaire::with('entity')->latest('updated_at')->get()));
    }

    public function store(QuestionaireRequest $request)
    {

        try{
            $result = (new QuestionaireService)->saveQuestionaire($request);
            return $this->return_success(QuestionaireResource::make( $result));
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function update(Questionaire $questionaire,QuestionaireRequest $request)
    {
        try{

            $result = (new QuestionaireService)->updateQuestionaire($questionaire,$request);
            return $this->return_success($result);

        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function destroy(Questionaire $questionaire)
    {
        try{
            $questionaire->delete();
            return $this->return_success('Successfully deleted');
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }


    }


    public function questionaireForm()
    {
        $questionaires = Questionaire::with([
                                            'criterias' => function($query){
                                                $query->with(['questions']);
                                            }
                                       ])
                                       ->get();
        return QuestionaireResource::collection($questionaires);
    }

    public function updateStatus(Request $request,Questionaire $questionaire)
    {
        $this->authorize('update', $questionaire);
        try {
            // if($request->update_time){
            //     $questionaire->updated_at =  $request->update_time;

            // }else{
            //     $questionaire->status =  !$questionaire->status;
            // }
            $res = $questionaire->criterias->isNotEmpty();
            if($res){
                    $questionaire->status =  !$questionaire->status;
                    $questionaire->save();
                    return $this->return_success(QuestionaireResource::make($questionaire->load(['entity'])));
                }
            return $this->return_success( $res );
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function forEvaluatee(Request $request)
    {
        try{
            $result = (new QuestionaireService)->fetchForEvaluatee($request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function latestQuestionaire()
    {
        try{

            $result = (new QuestionaireService)->fetchLatestQuestionaire();
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function withCriterias(Questionaire $questionaire)
    {

        try{
            return $this->return_success($questionaire->load(['criterias','criterias.questions']));
            // return $this->return_success($questionaire);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function getMaxRespondents()
    {
        try{
            $result = (new QuestionaireService)->fetchMaxRespondentsEachEntity();
            return $this->return_success( $result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function removeCriteria(Questionaire $questionaire,Request $request)
    {
        try{
            $criteria = Criteria::find($request->criteria_id);
            $criteria->status = 0;
            $criteria->save();
            $questionaire->criterias()->detach($criteria->id);
            return $this->return_success("Removed successfully");
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function attachCriterias (Questionaire $questionaire,Request $request){
        try{

            $questionaire->criterias()->syncWithoutDetaching($request->criteria_ids);
            return $this->return_success($questionaire->load(['criterias']));
            // return $this->return_success($request->criteria_ids);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }

    }

}
