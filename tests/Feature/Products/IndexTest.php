<?php

namespace Tests\Feature\Products;

use App\Models\Price as ModelsPrice;
use App\Models\Product as ModelsProduct;
use App\Models\Type as ModelsType;
use App\Models\TypeGroup as ModelsTypeGroup;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function runDatabaseMigrations()
    {
        $this->artisan('migrate --path=/database/migrations/2023_06_02_025859_create_products_table.php');
        $this->artisan('migrate --path=/database/migrations/2023_06_02_030111_create_type_groups_table.php');
        $this->artisan('migrate --path=/database/migrations/2023_06_02_030132_create_prices_table.php');
        $this->artisan('migrate --path=/database/migrations/2023_06_02_035355_create_types_table.php');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    public function test_invalid_header(): void
    {
        $response = $this->get(
            uri: route(name: 'api.v1.general.products.index')
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
                "message" => "Your request header is invalid!",
                "errors" => []
            ],
        );
    }

    public function test_get_empty_list_of_products(): void
    {
        $response = $this->get(
            uri: route(name: 'api.v1.general.products.index'),
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
                "data",
            ]
        ]);
    }

    public function test_get_list_of_products(): void
    {
        $this->seed(ProductSeeder::class);

        $response = $this->get(
            uri: route(name: 'api.v1.general.products.index'),
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
                        "product_id",
                        "product_name",
                        "groups",
                        "prices"
                    ]
                ],
            ]
        ]);
    }

    public function test_get_list_when_has_not_variety(): void
    {
        $product = ModelsProduct::factory()->create();
        $price = ModelsPrice::factory()->create(attributes: [
            'product_id' => $product->id,
            'type_id' => null,
        ]);

        $response = $this->get(
            uri: route(name: 'api.v1.general.products.index'),
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
                    "data" => [
                        [
                            "product_id",
                            "product_name",
                            "groups",
                            "prices" => [
                                [
                                    "type_id",
                                    "price"
                                ]
                            ]
                        ]
                    ],
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
                            "product_id" => 1,
                            "product_name" => $product->name,
                            "groups" => null,
                            "prices" => [
                                [
                                    "type_id" => null,
                                    "price" => $price->price
                                ]
                            ]
                        ]
                    ],
                ]
            ]
        );
    }

    public function test_get_list_when_has_variety(): void
    {
        $product = ModelsProduct::factory()->create();
        $typeGroup = ModelsTypeGroup::factory()->create([
            'product_id' => $product->id
        ]);
        $type = ModelsType::factory()->create([
            'type_group_id' => $typeGroup->id
        ]);
        $price = ModelsPrice::factory()->create(attributes: [
            'product_id' => $product->id,
            'type_id' => $type->id,
        ]);

        $response = $this->get(
            uri: route(name: 'api.v1.general.products.index'),
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
                    "data" => [
                        [
                            "product_id",
                            "product_name",
                            "groups" => [
                                "group_id",
                                "group_name",
                                "types" => [
                                    [
                                        "type_id",
                                        "type_name"
                                    ]
                                ]
                            ],
                            "prices" => [
                                [
                                    "type_id",
                                    "price"
                                ]
                            ]
                        ]
                    ],
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
                            "product_id" => 1,
                            "product_name" => $product->name,
                            "groups" => [
                                "group_id" => $typeGroup->id,
                                "group_name" => $typeGroup->name,
                                "types" => [
                                    [
                                        "type_id" => $type->id,
                                        "type_name" => $type->name
                                    ]
                                ]
                            ],
                            "prices" => [
                                [
                                    "type_id" => null,
                                    "price" => $price->price
                                ]
                            ]
                        ]
                    ],
                ]
            ]
        );
    }
}
