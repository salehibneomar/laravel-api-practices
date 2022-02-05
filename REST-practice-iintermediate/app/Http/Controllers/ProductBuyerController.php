<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{

    public function index(Product $product)
    {
        $buyers = $product->transactions()
                  ->with('buyer')
                  ->get()
                  ->pluck('buyer')
                  ->unique('id')
                  ->sortBy('id')
                  ->values();

        return $this->showAllResponse($buyers);
    }

}
