<?php

namespace Tests\Feature\Orders;

use App\Models\User as ModelsUser;
use App\Enums\StatusOrder;
use App\Models\Order as ModelsOrder;
use Database\Seeders\OrderSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function test_get_list_of_my_orders(): void
    {
        $this->seed(OrderSeeder::class);

        $customer = ModelsUser::factory()->create();
        $order = ModelsOrder::factory()->create(attributes: [
            'user_id' => $customer->id,
            'status' => StatusOrder::WAITING->value,
        ]);
        $this->setUser(userId: $customer->id);

        $response = $this->get(
            uri: route(name: 'api.v1.user.orders.index'),
            headers: $this->headerRequest
        );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            structure: [
                "error",
                "status",
                "message",
                "data" => [
                    "paginate" => [
                        "currentPage",
                        "lastPage",
                        "total",
                    ],
                    "data",
                ]
            ],
            responseData: [
                "error" => false,
                "status" => 200,
                "message" => __('general.success'),
                "data" => [
                    "paginate" => [
                        "currentPage" => 1,
                        "lastPage" => 1,
                        "total" => 1,
                    ],
                    "data" => [
                        [
                            // "product_id" => 1,
                            // "product_name" => $product->name,
                            // "groups" => [
                            //     "group_id" => $typeGroup->id,
                            //     "group_name" => $typeGroup->name,
                            //     "types" => [
                            //         [
                            //             "type_id" => $type->id,
                            //             "type_name" => $type->name
                            //         ]
                            //     ]
                            // ],
                            // "prices" => [
                            //     [
                            //         "type_id" => null,
                            //         "price" => $price->price
                            //     ]
                            // ]
                        ]
                    ],
                ]
            ],
        );
    }
}
