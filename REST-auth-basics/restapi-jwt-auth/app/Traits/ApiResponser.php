<?php

namespace App\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser{

    protected function successResponse($data, $code=200){
        return response()->json(['message'=>$data], $code);
    }

    public function listResponse(Collection $data){
        return response()->json(['data'=>$data], 200); 
    }

    public function singleResponse(Model $data, $code=200){
        return response()->json(['data'=>$data], $code);
    }

    protected function errorResponse($error, $code){
        return response()->json(['error'=>$error, 'code'=>$code], $code);
    }

}