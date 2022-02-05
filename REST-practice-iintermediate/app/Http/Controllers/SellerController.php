<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends ApiController
{

    public function index()
    {
        $sellers = Seller::all();
        return $this->showAllResponse($sellers);
    }

    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        return $this->showSingleResponse($seller);
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
