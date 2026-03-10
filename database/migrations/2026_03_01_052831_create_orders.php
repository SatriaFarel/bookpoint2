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

            /* penjual */
            $table->foreignId('seller_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /* pembeli */
            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /* kode order */
            $table->string('order_code')
                ->unique()
                ->index();

            /* total harga */
            $table->decimal('total_price', 15, 2)
                ->default(0);

            /* metode pembayaran */
            $table->string('payment_method')
                ->nullable();

            /* jumlah dibayar */
            $table->decimal('paid_amount', 15, 2)
                ->nullable();

            /* status order */
            $table->enum('status', [
                'pending',
                'paid',
                'done'
            ])->default('pending');

            /* opsional (jika suatu saat pakai pengiriman) */
            $table->string('resi')->nullable();
            $table->string('expedition')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};