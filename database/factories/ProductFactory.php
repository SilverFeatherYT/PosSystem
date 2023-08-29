<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'D_ProductID' => $this->faker->randomNumber(5),
            'D_ProductName' => $this->faker->word,
            'D_ProductQty' => $this->faker->numberBetween(1, 100),
            'D_ProductPrice' => $this->faker->randomFloat(2, 0, 100),
            'D_ProductBrand' => $this->faker->word,
            'D_ProductImage' => null,
            'D_MinProductQty' => null,
            'D_Barcode' => null,
        ];
    }
}
