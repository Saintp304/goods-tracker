<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite doesn't support altering enum/check constraints directly.
        // We must recreate the table.

        Schema::rename('shipments', 'shipments_old');

        // Drop the unique index so it can be recreated on the new table
        DB::statement("DROP INDEX IF EXISTS shipments_tracking_number_unique");

        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->string('sender_name');
            $table->string('sender_phone')->nullable();
            $table->text('sender_address')->nullable();
            $table->string('sender_country')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_email')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->text('receiver_address')->nullable();
            $table->string('receiver_country')->nullable();
            $table->string('origin');
            $table->string('destination');
            $table->enum('status', ['pending', 'picked_up', 'in_transit', 'delivered', 'held', 'cancelled'])->default('pending');
            $table->text('package_description')->nullable();
            $table->string('package_type')->nullable();
            $table->string('package_weight')->nullable();
            $table->integer('package_quantity')->nullable();
            $table->string('shipment_image')->nullable();
            $table->date('eta')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO shipments (id, tracking_number, sender_name, sender_phone, sender_address, sender_country, receiver_name, receiver_email, receiver_phone, receiver_address, receiver_country, origin, destination, status, package_description, package_type, package_weight, package_quantity, shipment_image, eta, created_at, updated_at) SELECT id, tracking_number, sender_name, sender_phone, sender_address, sender_country, receiver_name, receiver_email, receiver_phone, receiver_address, receiver_country, origin, destination, status, package_description, package_type, package_weight, package_quantity, shipment_image, eta, created_at, updated_at FROM shipments_old");

        Schema::drop('shipments_old');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('shipments', 'shipments_old');

        // Drop the unique index so it can be recreated on the new table
        DB::statement("DROP INDEX IF EXISTS shipments_tracking_number_unique");

        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->string('sender_name');
            $table->string('sender_phone')->nullable();
            $table->text('sender_address')->nullable();
            $table->string('sender_country')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_email')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->text('receiver_address')->nullable();
            $table->string('receiver_country')->nullable();
            $table->string('origin');
            $table->string('destination');
            $table->enum('status', ['pending', 'in_transit', 'delivered', 'held', 'cancelled'])->default('pending');
            $table->text('package_description')->nullable();
            $table->string('package_type')->nullable();
            $table->string('package_weight')->nullable();
            $table->integer('package_quantity')->nullable();
            $table->string('shipment_image')->nullable();
            $table->date('eta')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO shipments (id, tracking_number, sender_name, sender_phone, sender_address, sender_country, receiver_name, receiver_email, receiver_phone, receiver_address, receiver_country, origin, destination, status, package_description, package_type, package_weight, package_quantity, shipment_image, eta, created_at, updated_at) SELECT id, tracking_number, sender_name, sender_phone, sender_address, sender_country, receiver_name, receiver_email, receiver_phone, receiver_address, receiver_country, origin, destination, status, package_description, package_type, package_weight, package_quantity, shipment_image, eta, created_at, updated_at FROM shipments_old");

        Schema::drop('shipments_old');
    }
};
