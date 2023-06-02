<?php

namespace Tests\Feature\Orders;

use App\Models\Price as ModelsPrice;
use App\Models\Product as ModelsProduct;
use App\Models\Type as ModelsType;
use App\Models\TypeGroup as ModelsTypeGroup;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function test_invalid_header(): void
    {
        $response = $this->post(
            uri: route(name: 'api.v1.user.order.store')
        );

        $response->assertStatus(401);

        $response->assertJsonStructure(
            structure: [
                "error",
                "status",
                "message",
                "errors" => []
            ],
            responseData: [
                "error" => true,
                "status" => 401,
                "message" => __('general.invalidHeader'),
                "errors" => []
            ],
        );
    }

    public function test_send_invalid_body(): void
    {
        $response = $this->post(
            uri: route(name: 'api.v1.user.order.store'),
            data: [],
            headers: $this->headerRequest
        );

        $response->assertStatus(422);

        $response->assertJsonStructure(
            structure: [
                "error",
                "status",
                "message",
                "errors" => [
                    "product_id",
                    "type_id",
                    "count",
                    "consume_location"
                ]
            ]
        );
    }

    public function test_buy_product_with_invalid_type(): void
    {
        $this->createProductWithSingleVariety();

        $response = $this->post(
            uri: route(name: 'api.v1.user.order.store'),
            data: [
                'product_id' => 1,
                'type_id' => 2,
                'count' => 1,
                'consume_location' => Location::IN_SHOP
            ],
            headers: $this->headerRequest
        );

        $response->assertStatus(400);

        $response->assertJsonStructure(
            structure: [
                "error",
                "status",
                "message",
                "errors" => []
            ],
            responseData: [
                "error" => true,
                "status" => 400,
                "message" => __('product.invalidType'),
                "errors" => []
            ],
        );
    }

    public function test_buy_product_successfully(): void
    {
        $this->createProductWithSingleVariety();

        $response = $this->post(
            uri: route(name: 'api.v1.user.order.store'),
            data: [
                'product_id' => 1,
                'type_id' => 1,
                'count' => 1,
                'consume_location' => Location::IN_SHOP
            ],
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
                "errors" => []
            ]
        );

        $order = Order::firstOrFail();
        $price = PriceRepositoryFacade::getPrice(productId: 1, typeId: 1);

        $this->assertEquals(expected: $order->product_id, actual: 1);
        $this->assertEquals(expected: $order->type_id, actual: 1);
        $this->assertEquals(expected: $order->count, actual: 1);
        $this->assertEquals(expected: $order->consume_location, actual: Location::IN_SHOP);
        $this->assertEquals(expected: $order->status, actual: Status::WAITING);
        $this->assertEquals(expected: $order->price, actual: $price);
        $this->assertEquals(expected: Order::count(), actual: 1);
    }

    private function createProductWithSingleVariety()
    {
        $product = ModelsProduct::factory()->create();
        $typeGroup = ModelsTypeGroup::factory()->create([
            'product_id' => $product->id
        ]);
        $type = ModelsType::factory()->create([
            'type_group_id' => $typeGroup->id
        ]);
        ModelsPrice::factory()->create(attributes: [
            'product_id' => $product->id,
            'type_id' => $type->id,
        ]);
    }
}
