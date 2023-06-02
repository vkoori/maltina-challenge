<?php

namespace Database\Factories;

use App\Enums\Location;
use App\Enums\StatusOrder;
use App\Models\Product;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'           => User::factory(),
            'invoice_id'        => $this->faker->uuid(),
            'product_id'        => Product::factory(),
            'type_id'           => $this->faker->boolean ? null : Type::factory(),
            'count'             => $this->faker->randomDigit(),
            'price'             => $this->faker->numberBetween(0, 10000),
            'consume_location'  => $this->faker->randomElement(Location::values()),
            'status'            => $this->faker->randomElement(StatusOrder::values())
        ];
    }
}
