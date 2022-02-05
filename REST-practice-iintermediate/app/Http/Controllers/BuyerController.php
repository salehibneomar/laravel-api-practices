<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\User;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{

    public function index()
    {
        $buyers = Buyer::all();
        return $this->showAllResponse($buyers);
    }

    public function show($id)
    {
        $buyer = Buyer::findOrFail($id);
        return $this->showSingleResponse($buyer);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

}
