<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends ApiController
{

    public function index(Transaction $transaction)
    {
        $category = $transaction->product->category;
        return $this->showSingleResponse($category);
    }

}
