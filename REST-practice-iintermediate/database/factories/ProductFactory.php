<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->text(150),
            'quantity' => mt_rand(10, 100),
            'price' => $this->faker->randomFloat(2, 100, 99999),
            'status' => $this->faker->randomElement([Product::AVAILABLE, Product::UNAVAILABLE]),
            'seller_id' => Seller::all()->random()->id,
            'category_id' => Category::all()->random()->id,
        ];
    }
}
