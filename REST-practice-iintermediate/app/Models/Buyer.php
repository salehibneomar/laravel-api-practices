<?php

namespace App\Models;

use App\Scopes\BuyerScope;

class Buyer extends User
{
    protected $table = 'users';

    protected static function booted()
    {
        static::addGlobalScope(new BuyerScope());
    }

    public function transactions(){
        return $this->hasMany(Transaction::class, 'buyer_id', 'id');
    }
}
