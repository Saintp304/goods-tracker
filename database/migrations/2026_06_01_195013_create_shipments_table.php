<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();

            // Sender
            $table->string('sender_name');
            $table->string('sender_phone')->nullable();
            $table->text('sender_address')->nullable();
            $table->string('sender_country')->nullable();

            // Receiver
            $table->string('receiver_name');
            $table->string('receiver_email')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->text('receiver_address')->nullable();
            $table->string('receiver_country')->nullable();

            $table->string('origin');
            $table->string('destination');

            $table->enum('status', [
                'pending', 'picked_up', 'in_transit', 'cleared_transit',
                'held', 'delivered', 'cancelled',
            ])->default('pending');

            // Package
            $table->text('package_description')->nullable();
            $table->string('package_type')->nullable();
            $table->string('package_weight')->nullable();
            $table->integer('package_quantity')->nullable();
            $table->string('shipment_image')->nullable();

            $table->date('eta')->nullable();

            // Financial
            $table->string('currency')->nullable();
            $table->string('payment_type')->default('instant');
            $table->decimal('subtotal', 12, 2)->nullable();
            $table->decimal('tax', 12, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
