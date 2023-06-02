<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ProductSeeder::class);
        $product = Product::inRandomOrder()->with('types')->first();

        Order::factory()->create(attributes: [
            'product_id' => $product->id,
            'type_id' => $product->types->count()
                ? $product->types->first()->id
                : null
        ]);

        $this->command->info('Order seed completed.');
    }
}
