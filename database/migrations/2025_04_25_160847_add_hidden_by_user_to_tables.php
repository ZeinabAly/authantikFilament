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
        $tables = ['orders', 'products', 'addresses', 'reservations']; // etc.

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->boolean('hidden_by_user')->default(false);
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['orders', 'products', 'addresses', 'reservations']; // etc.

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('hidden_by_user');
            });
        }
    }
};
