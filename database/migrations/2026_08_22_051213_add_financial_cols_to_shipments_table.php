<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('currency')->default('USD')->after('eta');
            $table->decimal('subtotal', 15, 2)->default(0)->after('currency');
            $table->decimal('tax', 15, 2)->default(0)->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['currency', 'subtotal', 'tax']);
        });
    }
};
