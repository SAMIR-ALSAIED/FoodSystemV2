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
        if (!Schema::hasTable('order_items')) {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

                   $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete(); // لو الطلب اتشال، الأصناف تتحذف

            // كل OrderItem مربوط بمنتج
            $table->foreignId('product_id')->constrained('products');

            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2); // السعر عند إضافة الطلب
            $table->timestamps();
        });
        
    }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
