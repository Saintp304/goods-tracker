<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Fix the broken foreign‑key reference on the `shipment_histories` table.
 *
 * The historic migration `2026_08_21_123014_update_shipments_status_enum_to_include_picked_up`
 * renamed the `shipments` table, created a new one and dropped the old table.
 * Unfortunately the `shipment_histories` table still referenced the old table name
 * (`shipments_old`).  SQLite – which powers this project – does not support altering
 * an existing foreign‑key constraint, so the table must be rebuilt.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite does not support dropping a foreign key directly, so we recreate the table.
        DB::statement('PRAGMA foreign_keys=off');

        // Re‑create the table with a correct foreign key reference to the current `shipments` table.
        Schema::create('shipment_histories_tmp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')
                ->constrained('shipments')
                ->cascadeOnDelete();
            $table->string('location');
            $table->string('info');
            $table->timestamps();
        });

        // Copy existing rows to the new table.
        DB::statement(
            'INSERT INTO shipment_histories_tmp (id, shipment_id, location, info, created_at, updated_at) '
            . 'SELECT id, shipment_id, location, info, created_at, updated_at FROM shipment_histories'
        );

        // Drop the old table and rename the temporary one.
        Schema::drop('shipment_histories');
        Schema::rename('shipment_histories_tmp', 'shipment_histories');

        DB::statement('PRAGMA foreign_keys=on');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re‑create the original broken state for rollback purposes.
        DB::statement('PRAGMA foreign_keys=off');

        Schema::create('shipment_histories_tmp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id');
            $table->string('location');
            $table->string('info');
            $table->timestamps();

            // The original (incorrect) constraint referenced the dropped `shipments_old` table.
            $table->foreign('shipment_id')
                ->references('id')
                ->on('shipments_old')
                ->cascadeOnDelete();
        });

        DB::statement(
            'INSERT INTO shipment_histories_tmp (id, shipment_id, location, info, created_at, updated_at) '
            . 'SELECT id, shipment_id, location, info, created_at, updated_at FROM shipment_histories'
        );

        Schema::drop('shipment_histories');
        Schema::rename('shipment_histories_tmp', 'shipment_histories');

        DB::statement('PRAGMA foreign_keys=on');
    }
};
