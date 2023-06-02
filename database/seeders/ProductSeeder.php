<?php

namespace Database\Seeders;

use App\Facade\TypeRepositoryFacade;
use App\Models\Price;
use App\Models\Product;
use App\Models\Type;
use App\Models\TypeGroup;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory(count: rand(1, 5))
            ->has(
                factory: TypeGroup::factory(count: rand(0, 1))
                    ->has(Type::factory(count: rand(2, 4)))
            )
            ->afterCreating(function (Product $product) {
                $types = TypeRepositoryFacade::getAllTypesOfProduct(productId: $product->id);

                $types->each(callback: function (Type $type) use ($product) {
                    Price::factory()->create(attributes: [
                        'product_id' => $product->id,
                        'type_id' => $type->id,
                    ]);
                });

                if ($types->count() == 0) {
                    Price::factory()->create(attributes: [
                        'product_id' => $product->id,
                        'type_id' => null,
                    ]);
                }
            })->create();

        $this->command->info('Product seed completed.');
    }
}
