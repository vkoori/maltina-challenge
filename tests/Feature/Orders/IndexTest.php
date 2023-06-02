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
        ModelsOrder::factory()->create(attributes: [
            'user_id' => $customer->id,
            'status' => StatusOrder::WAITING->value,
        ]);
        $this->setUser(userId: $customer->id);

        $response = $this->get(
            uri: route(name: 'api.v1.user.orders.index'),
            headers: $this->headerRequest
        );

        $response->assertStatus(200);

        $response->assertJsonStructure(structure: [
            "error",
            "status",
            "message",
            "data" => [
                "paginate" => [
                    "currentPage",
                    "lastPage",
                    "total",
                ],
                "data" => [
                    [
                        "order_id",
                        "product" => [
                            "product_id",
                            "product_name",
                            "groups",
                            "prices"
                        ],
                        "type",
                        "count",
                        "price",
                        "location",
                        "status",
                        "created_at"
                    ]
                ],
            ],
            "meta" => [
                "location" => [
                    "IN_SHOP",
                    "OUT_SHOP",
                ],
                "status" => [
                    "WAITING",
                    "PREPARATION",
                    "READY",
                    "DELIVERED"
                ]
            ]
        ]);

        $this->assertEquals(expected: $response->json()['data']['paginate']['total'], actual: 1);
        $this->assertEquals(expected: ModelsOrder::count(), actual: 2);
    }
}
