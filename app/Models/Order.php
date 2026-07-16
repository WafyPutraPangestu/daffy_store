<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'user_id',
    'order_number',
    'status',
    'recipient_name',
    'shipping_address',
    'city',
    'province',
    'postal_code',
    'courier',
    'courier_service',
    'shipping_cost',
    'subtotal',
    'total_amount',
    'snap_token',
    'tracking_number',
    'total_weight',
])]
class Order extends Model
{
    protected function casts(): array
    {
        return [
            'shipping_cost' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
