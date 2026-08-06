<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    /**
     * Channel yang digunakan: database (tersimpan di tabel notifications)
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data yang disimpan ke kolom 'data' (JSON) di tabel notifications
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'order_id'      => $this->order->id,
            'order_number'  => $this->order->order_number,
            'customer_name' => $this->order->recipient_name,
            'total_amount'  => $this->order->total_amount,
            'order_url'     => route('admin.order.show', $this->order->id),
        ];
    }
}
