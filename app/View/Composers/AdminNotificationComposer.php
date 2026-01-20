<?php

namespace App\View\Composers;

use App\Models\Order;
use Illuminate\View\View;

class AdminNotificationComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Hitung pesanan pending (notifikasi)
        $newOrdersCount = Order::whereIn('status_order', ['Pending', 'Menunggu Pembatalan'])
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->count();

        $view->with('newOrdersCount', $newOrdersCount);
    }
}

