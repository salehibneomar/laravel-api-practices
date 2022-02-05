<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{

    public function store(Request $request, Product $product, Buyer $buyer)
    {
        $request->validate([
            'quantity' => 'required|integer',
        ]);

        if(!$buyer->isVerified()){
            return $this->errorResponse('You need to verify your account first to do any kind of transaction', 409);
        }

        if(!$product->seller->isVerified()){
            return $this->errorResponse('This seller is not verified, Only products from verified sellers are allowed', 409);
        }

        if(!$product->isAvailable()){
            return $this->errorResponse('This product is currently unavailable', 409);
        }

        if($request->quantity>$product->quantity){
            return $this->errorResponse('Requested quantity exceeded product\'s available quantity', 409);
        }

        $created     = false;
        $transaction = new Transaction();

        $created = DB::transaction(function() use ($product, $request, $buyer, $transaction){
            $product->decrement('quantity', $request->quantity);
            if($product->wasChanged()){
                $transaction->quantity    = $request->quantity;
                $transaction->total_price = $request->quantity * $product->price;
                $transaction->product_id  = $product->id;
                $transaction->buyer_id    = $buyer->id;
                if($transaction->save()){
                    return true;
                }
            }
        });
        
        if(!$created){
           return $this->errorResponse('Sorry couldn\'t perform transaction, try again later', 409);
        }

        return $this->showSingleResponse($transaction);
    }

}
