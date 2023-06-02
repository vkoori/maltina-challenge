<?php

namespace App\Dto;

use App\Models\Order;
use Illuminate\Support\Collection;

class InvoicePassenger
{
    /**
     * @var Collection<Order>
     */
    private Collection $orders;

    public function __construct(private string $invoiceId)
    {
    }

    public function getInvoiceId(): string
    {
        return $this->invoiceId;
    }

    public function setOrders(Collection $orders): void
    {
        $this->orders = $orders;
    }

    /**
     * @return Collection<Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }
}
