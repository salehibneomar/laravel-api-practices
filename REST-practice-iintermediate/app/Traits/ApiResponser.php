<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser{

    protected function successResponse($data, $code){
        return response()->json(['data'=>$data], $code);
    }

    protected function showAllResponse(Collection $collection, $code=200){
        return $this->successResponse(['data'=>$collection], $code);
    }

    protected function showSingleResponse(Model $model, $code=200){
        return $this->successResponse(['data'=>$model], $code);
    }

    protected function errorResponse($error, $code){
        return response()->json(['error'=>$error, 'code'=>$code], $code);
    }

}