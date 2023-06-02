<?php

namespace Tests\Feature\Orders;

use App\Enums\StatusOrder;
use App\Models\Order as ModelsOrder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function test_cancel_waiting_order(): void
    {
        $order = ModelsOrder::factory()->create(attributes: [
            'user_id' => 1,
            'status' => StatusOrder::WAITING
        ]);

        $response = $this->delete(
            uri: route(name: 'api.v1.user.orders.cancel', parameters: ['invoiceId' => $order->invoice_id]),
            headers: $this->headerRequest
        );

        $response->assertStatus(200);

        $this->assertEquals(expected: ModelsOrder::count(), actual: 0);
    }

    public function test_cannot_cancel_none_waiting_order(): void
    {
        $order = ModelsOrder::factory()->create(attributes: [
            'user_id' => 1,
            'status' => StatusOrder::DELIVERED
        ]);

        $response = $this->delete(
            uri: route(name: 'api.v1.user.orders.cancel', parameters: ['invoiceId' => $order->invoice_id]),
            headers: $this->headerRequest
        );

        $response->assertStatus(400);

        $this->assertEquals(expected: ModelsOrder::count(), actual: 1);
    }
}
