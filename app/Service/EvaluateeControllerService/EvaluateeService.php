<?php
namespace App\Service\EvaluateeControllerService;

use App\Models\Evaluatee;
use App\Http\Resources\EvaluateeResource;
use App\Models\Entity;
use App\Models\KlassDetails;

class EvaluateeService{

    public function fetchEvaluateInfo($id){
        $evaluatee = Evaluatee::with([
            'entity',
            'KlassDetails' => function($q){
                $q->with([
                    'subject',
                    'sectionYearDepartment'=>function($q){
                        $q->with(['sectionYear','department']);
                    },
                ]);
            }
            ])
            ->findOrFail($id);
            // return $evaluatee;
            return  EvaluateeResource::make($evaluatee);
    }

    public function fetchAllEvaluatees()
    {

        $evaluatees = Evaluatee::with([
                                'entity',
                                'SectionYearDepartments' =>function($q){
                                    $q->with([
                                        'department',
                                    ]);
                                }
                                ])
                                ->latest()->get();
        return  EvaluateeResource::collection($evaluatees);
    }

    public function saveEvaluatees($request)
    {
        $evaluate = Evaluatee::create([
            'name' => $request->name,
            'job_type'=>$request->job_type,
            'entity_id'=>$request->entity_id
        ]);

        return EvaluateeResource::make($evaluate);

    }

    public function updateEvaluatee($evaluatee, $request)
    {
        $evaluatee->name = $request->name;
        $evaluatee->job_type = $request->job_type;
        $evaluatee->entity_id = $request->entity_id;
        $evaluatee->save();
        return $evaluatee;

    }




}