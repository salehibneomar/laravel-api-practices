<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
{

    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()
                      ->with('product.category')
                      ->get()
                      ->pluck('product.category')
                      ->unique('id')
                      ->sortBy('id')
                      ->values();

        return $this->showAllResponse($categories);              
    }

}
