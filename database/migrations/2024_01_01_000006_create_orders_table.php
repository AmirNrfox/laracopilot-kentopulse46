<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->string('status')->default('pending'); // pending, processing, shipped, delivered, cancelled
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, refunded
            $table->string('payment_method')->nullable(); // zarinpal, whatsapp
            $table->string('transaction_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->text('notes')->nullable();
            $table->decimal('subtotal', 12, 0);
            $table->decimal('discount', 12, 0)->default(0);
            $table->decimal('shipping', 12, 0)->default(0);
            $table->decimal('total', 12, 0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};