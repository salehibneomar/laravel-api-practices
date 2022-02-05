<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{

    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAllResponse($transactions);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return $this->showSingleResponse($transaction);
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
