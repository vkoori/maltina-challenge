<?php

namespace Database\Factories;

use App\Models\TypeGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type_group_id' => TypeGroup::factory(),
            'name' => $this->faker->name(),
        ];
    }
}
