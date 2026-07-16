<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status', [
                'menunggu_pembayaran',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan'
            ])->default('menunggu_pembayaran');
            $table->string('recipient_name');
            $table->text('shipping_address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code', 10);
            $table->string('courier');
            $table->string('courier_service');
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->string('snap_token')->nullable();
            $table->string('tracking_number')->nullable();
            $table->integer('total_weight')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
