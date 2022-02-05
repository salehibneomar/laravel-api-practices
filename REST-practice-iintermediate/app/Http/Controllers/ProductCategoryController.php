<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{

    public function index(Product $product)
    {
        $category = $product->category;
        return $this->showSingleResponse($category);
    }

}
