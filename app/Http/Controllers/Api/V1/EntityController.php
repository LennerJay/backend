<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use App\Models\Entity;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntityRequest;

class EntityController extends Controller
{
    public function __construct()
    {
        return $this->authorizeResource(Entity::class, 'entity');
    }

    public function index()
    {
        try{
            return $this->return_success(Entity::latest()->get());
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function store(EntityRequest $request)
    {
        try{

            $exist = Entity::where('entity_name',$request->entity_name)->exists();
            if( $exist ){
                return $this->return_success(false);
            }
            $entity = Entity::create([
                'entity_name' => $request->entity_name,
            ]);
            return $this->return_success($entity);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function update(Entity $entity,EntityRequest $request )
    {
        try{
            $exist = Entity::where('entity_name',$request->entity_name)->exists();
            if( $exist ){
                return $this->return_success(false);
            }
            $entity->entity_name = $request->entity_name;
            $entity->save();
             return $this->return_success( $entity);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function destroy(Entity $entity)
    {
        $this->authorize('delete', $entity);
        try{
            $entity->delete();
            return $this->return_success('Deleted successfully');
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }

    }
}
