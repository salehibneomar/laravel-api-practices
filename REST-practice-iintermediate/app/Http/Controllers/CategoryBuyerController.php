<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryBuyerController extends ApiController
{
    public function index(Category $category)
    {
        $buyers = $category->products()
                  ->whereHas('transactions')
                  ->with('transactions')
                  ->get()
                  ->pluck('transactions')
                  ->collapse()
                  ->sortBy('id')
                  ->values();

        return $this->showAllResponse($buyers);          
    }

}
