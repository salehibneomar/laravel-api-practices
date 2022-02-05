<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{
    public function index(Buyer $buyer)
    {
        $sellers = $buyer->transactions()
                    ->with('product.seller')
                    ->get()
                    ->pluck('product.seller')
                    ->unique('id')
                    ->sortBy('id')
                    ->values();

        return $this->showAllResponse($sellers);            
    }

}
