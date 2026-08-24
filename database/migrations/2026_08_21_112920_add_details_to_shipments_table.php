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
        Schema::table('shipments', function (Blueprint $table) {
            // Sender details
            $table->string('sender_phone')->nullable()->after('sender_name');
            $table->text('sender_address')->nullable()->after('sender_phone');
            $table->string('sender_country')->nullable()->after('sender_address');

            // Receiver details
            $table->string('receiver_email')->nullable()->after('receiver_name');
            $table->text('receiver_address')->nullable()->after('receiver_phone');
            $table->string('receiver_country')->nullable()->after('receiver_address');

            // Package details
            $table->text('package_description')->nullable()->after('destination');
            $table->string('package_type')->nullable()->after('package_description');
            $table->string('package_weight')->nullable()->after('package_type');
            $table->integer('package_quantity')->nullable()->after('package_weight');
            $table->string('shipment_image')->nullable()->after('package_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn([
                'sender_phone', 'sender_address', 'sender_country',
                'receiver_email', 'receiver_address', 'receiver_country',
                'package_description', 'package_type', 'package_weight',
                'package_quantity', 'shipment_image'
            ]);
        });
    }
};
