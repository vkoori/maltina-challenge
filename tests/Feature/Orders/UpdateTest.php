<?php

namespace Tests\Feature\Orders;

use App\Enums\StatusOrder;
use App\Models\Order as ModelsOrder;
use App\Models\User as ModelsUser;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function test_email_want_to__update_order_not_exists(): void
    {
        $response = $this->patch(
            uri: route(name: 'api.v1.admin.orders.update', parameters: ['order' => 1]),
            data: [
                'status' => StatusOrder::PREPARATION->value
            ],
            headers: $this->headerRequest
        );

        $response->assertStatus(404);
    }

    public function test_email_should_be_sent_when_status_is_updated(): void
    {
        $customer = ModelsUser::factory()->create();
        $order = ModelsOrder::factory()->create(attributes: [
            'user_id' => $customer->id,
            'status' => StatusOrder::WAITING->value,
        ]);

        Notification::fake();

        $response = $this->patch(
            uri: route(name: 'api.v1.admin.orders.update', parameters: ['order' => $order->id]),
            data: [
                'status' => StatusOrder::PREPARATION->value
            ],
            headers: $this->headerRequest
        );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            structure: [
                "error",
                "status",
                "message",
                "data"
            ],
            responseData: [
                "error" => true,
                "status" => 200,
                "message" => __('order.statusUpdated'),
                "data" => []
            ],
        );

        Notification::assertSentTo($customer, OrderStatusUpdated::class);
    }
}
