<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function return_success($data)
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function return_error($data)
    {
        return response()->json(['message'=>$data]);
    }

}
