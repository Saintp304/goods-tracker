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
    Schema::create('shipments', function (Blueprint $table) {
        $table->id();
        $table->string('tracking_number')->unique();
        $table->string('sender_name');
        $table->string('receiver_name');
        $table->string('receiver_phone')->nullable();
        $table->string('origin');
        $table->string('destination');
        $table->enum('status', ['pending', 'in_transit', 'delivered', 'held', 'cancelled'])->default('pending');
        $table->date('eta')->nullable();
        $table->string('currency')->default('USD');
        $table->decimal('subtotal', 15, 2)->default(0);
        $table->decimal('tax', 15, 2)->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
