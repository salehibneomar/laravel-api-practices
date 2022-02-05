<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategorySellerController extends ApiController
{

    public function index(Category $category)
    {
        $sellers = $category
                   ->products()
                   ->with('seller')
                   ->get()
                   ->pluck('seller')
                   ->unique('id')
                   ->sortBy('id')
                   ->values();
                    
        return $this->showAllResponse($sellers);
    }


}
