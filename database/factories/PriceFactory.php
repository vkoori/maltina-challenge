<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'type_id' => $this->faker->boolean ? null : Type::factory(),
            'price' => $this->faker->numberBetween(0, 100000)
        ];
    }
}
