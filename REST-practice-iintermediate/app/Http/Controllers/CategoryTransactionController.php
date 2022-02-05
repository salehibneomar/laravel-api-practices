<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryTransactionController extends ApiController
{

    public function index(Category $category)
    {
        $transactions = $category->products()
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
