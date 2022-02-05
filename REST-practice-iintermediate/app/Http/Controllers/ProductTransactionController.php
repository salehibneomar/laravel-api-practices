<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductTransactionController extends ApiController
{

    public function index(Product $product)
    {
        $transactions = $product->transactions;
        return $this->showAllResponse($transactions);
    }

}
