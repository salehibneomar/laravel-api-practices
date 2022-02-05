<?php

namespace App\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SellerScope implements Scope{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('type', User::SELLER);
    }
}