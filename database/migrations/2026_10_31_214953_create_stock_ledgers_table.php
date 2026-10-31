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
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->enum('transaction_type', ['INBOUND', 'OUTBOUND', 'ADJUSTMENT', 'TRANSFER']);
            $table->decimal('quantity', 12, 4); // Positive for IN, Negative or tracked by type for OUT
            $table->decimal('unit_cost', 12, 4);
            $table->string('reference_type')->nullable(); // e.g., PurchaseOrder, Adjustment
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Who performed the action
            $table->timestamp('recorded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ledgers');
    }
};
