<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerBuyerController extends ApiController
{

    public function index(Seller $seller)
    {
        $buyers = $seller->products()
                  ->whereHas('transactions')
                  ->with('transactions.buyer')
                  ->get()
                  ->pluck('transactions')
                  ->collapse()
                  ->pluck('buyer')
                  ->unique('id')
                  ->sortBy('id')
                  ->values();
                  
        return $this->showAllResponse($buyers);             
    }

}
