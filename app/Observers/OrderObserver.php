<?php

namespace App\Observers;

use App\Jobs\NotificationQueue;
use App\Models\Order;

class OrderObserver
{
    public function updating(Order $order)
    {
        match (true) {
            $this->isStatusUpdated(order: $order) => dispatch(job: new NotificationQueue(order: $order)),
            default => null,
        };
    }

    private function isStatusUpdated(Order $order): bool
    {
        return $order->getOriginal(key: 'status') != $order->getAttribute(key: 'status');
    }
}
