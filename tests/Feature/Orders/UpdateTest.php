<?php

namespace Tests\Feature\Orders;

use App\Enums\StatusOrder;
use App\Models\Order as ModelsOrder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /* public function runDatabaseMigrations()
    {
        $this->artisan('migrate --path=/database/migrations/2023_06_02_115527_create_orders_table.php');
        $this->artisan('migrate --path=/database/migrations/?????????????????_create_users_table.php');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback --step=2');
        });
    } */

    public function test_email_should_be_sent_when_status_is_updated(): void
    {
        $customer = User::factory()->create();
        $order = ModelsOrder::factory()->create(attributes: [
            'user_id' => $customer->id
        ]);

        Notification::fake();
        $notification = new OrderStatusUpdated();

        $response = $this->patch(
            uri: route(name: 'api.v1.admin.orders.update'),
            data: [
                'status' => StatusOrder::PREPARATION->value
            ]
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

        Notification::assertSentTo([$customer], $notification);
    }
}
