<?php

namespace Tests\Feature\Orders;

use App\Enums\Location;
use App\Enums\StatusOrder;
use App\Facade\PriceRepositoryFacade;
use App\Models\Order as ModelsOrder;
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

    public function runDatabaseMigrations()
    {
        $this->artisan('migrate --path=/database/migrations/2014_10_12_000000_create_users_table.php');
        $this->artisan('migrate --path=/database/migrations/2023_06_02_025859_create_products_table.php');
        $this->artisan('migrate --path=/database/migrations/2023_06_02_030111_create_type_groups_table.php');
        $this->artisan('migrate --path=/database/migrations/2023_06_02_030132_create_prices_table.php');
        $this->artisan('migrate --path=/database/migrations/2023_06_02_035355_create_types_table.php');
        $this->artisan('migrate --path=/database/migrations/2023_06_02_115527_create_orders_table.php');
        $this->artisan('migrate --path=/database/migrations/2023_06_03_004646_add_column_orders_table.php');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback --step=7');
        });
    }

    public function test_invalid_header(): void
    {
        $response = $this->post(
            uri: route(name: 'api.v1.user.orders.store')
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
            uri: route(name: 'api.v1.user.orders.store'),
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
                    "order"
                ]
            ]
        );

        $response = $this->post(
            uri: route(name: 'api.v1.user.orders.store'),
            data: [
                "order" => ["test"]
            ],
            headers: $this->headerRequest
        );

        $response->assertStatus(422);

        $response->assertJsonStructure(
            structure: [
                "error",
                "status",
                "message",
                "errors" => [
                    "order.0.product_id",
                    "order.0.count",
                    "order.0.consume_location"
                ]
            ]
        );
    }

    public function test_buy_product_with_invalid_type(): void
    {
        $this->createProductWithSingleVariety();

        $response = $this->post(
            uri: route(name: 'api.v1.user.orders.store'),
            data: [
                'order' => [
                    [
                        'product_id' => 1,
                        'type_id' => 2,
                        'count' => 1,
                        'consume_location' => Location::IN_SHOP->value
                    ]
                ]
            ],
            headers: $this->headerRequest
        );

        $response->assertStatus(404);

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
            uri: route(name: 'api.v1.user.orders.store'),
            data: [
                'order' => [
                    [
                        'product_id' => 1,
                        'type_id' => 1,
                        'count' => 1,
                        'consume_location' => Location::IN_SHOP->value
                    ]
                ]
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
                    "invoiceId"
                ]
            ]
        );

        $order = ModelsOrder::firstOrFail();
        $price = PriceRepositoryFacade::getPrice(productId: 1, typeId: 1);

        $this->assertEquals(expected: $order->invoice_id, actual: $response->json()['data']['invoiceId']);
        $this->assertEquals(expected: $order->product_id, actual: 1);
        $this->assertEquals(expected: $order->type_id, actual: 1);
        $this->assertEquals(expected: $order->count, actual: 1);
        $this->assertEquals(expected: $order->consume_location, actual: Location::IN_SHOP);
        $this->assertEquals(expected: $order->status, actual: StatusOrder::WAITING);
        $this->assertEquals(expected: $order->price, actual: $price);
        $this->assertEquals(expected: ModelsOrder::count(), actual: 1);
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
