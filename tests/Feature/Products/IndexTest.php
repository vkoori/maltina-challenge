<?php

namespace Tests\Feature\Products;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function test_invalid_header(): void
    {
        $this->expectException(JwtException::class);
        $this->expectExceptionMessage('Your request header is invalid!');

        $response = $this->get(
            uri: route(name: 'api.v1.general.products.index')
        );

        $response->seeStatusCode(401);
    }

    public function test_get_empty_list_of_products(): void
    {
        $response = $this->get(
            uri: route(name: 'api.v1.general.products.index'),
            headers: $this->headerRequest
        );

        $response->seeStatusCode(200);

        $response->seeJsonStructure(structure: [
            "error",
            "status",
            "message",
            "data" => [
                "paginate" => [
                    "currentPage",
                    "lastPage",
                    "total",
                ],
                "data" => [],
            ],
            "meta" => [
                "status",
            ]
        ]);
    }

    public function test_get_list_of_products(): void
    {
        ModelProduct::factory()->create();

        $response = $this->get(
            uri: route(name: 'api.v1.general.products.index'),
            headers: $this->headerRequest
        );

        $response->seeStatusCode(200);

        $response->seeJsonStructure(structure: [
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
                        "types",
                        "sizes",
                        "prices"
                    ]
                ],
            ],
            "meta" => [
                "status",
            ]
        ]);
    }
}
