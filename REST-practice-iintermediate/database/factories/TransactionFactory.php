<?php

namespace Database\Factories;

use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::where('status', Product::AVAILABLE)
                          ->where('quantity', '>', 0)
                          ->with('seller')
                          ->get()
                          ->where('seller.verified', 1)
                          ->values()
                          ->random();

        $buyer  = Buyer::where('verified', 1)->get()->random();

        return [
            'quantity' => $quantity = mt_rand(1, $product->quantity),
            'total_price' => $quantity * $product->price,
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
        ];
    }
}
