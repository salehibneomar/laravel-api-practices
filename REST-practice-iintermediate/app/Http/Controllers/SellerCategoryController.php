<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerCategoryController extends ApiController
{

    public function index(Seller $seller)
    {
        $categories = $seller
                     ->products()
                     ->with('category')
                     ->get()
                     ->pluck('category')
                     ->unique('id')
                     ->sortBy('id')
                     ->values();

        return $this->showAllResponse($categories);
    }

}
