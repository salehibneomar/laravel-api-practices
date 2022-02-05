<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{

    public function index()
    {
        $products = Product::with('category:id,name')->get();
        return $this->showAllResponse($products);
    }

    public function show($id)
    {
        $product = Product::with('category:id,name')->findOrFail($id);
        return $this->showSingleResponse($product);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
