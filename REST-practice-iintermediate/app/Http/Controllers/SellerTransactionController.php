<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerTransactionController extends ApiController
{

    public function index(Seller $seller)
    {
        $transactions = $seller->products()
                        ->whereHas('transactions')
                        ->with('transactions')
                        ->get()
                        ->pluck('transactions')
                        ->collapse()
                        ->sortBy('id')
                        ->values();

        return $this->showAllResponse($transactions);                
    }

}
