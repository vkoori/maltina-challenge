<?php

namespace App\Jobs;

use App\Facade\UserRepositoryFacade;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NotificationQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Order $order)
    {
    }

    public function handle(): void
    {
        $customer = UserRepositoryFacade::findOrFail(modelId: $this->order->user_id);

        Notification::send($customer, new OrderStatusUpdated);
    }
}
