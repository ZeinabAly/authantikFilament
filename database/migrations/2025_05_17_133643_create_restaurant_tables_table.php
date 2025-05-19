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
        Schema::create('restaurant_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Exemple : Table 1, VIP A, etc.
            $table->string('position'); // Exemple : Salle 1, Salle VIP, etc.
            $table->integer('seats')->default(4); // Nombre de places
            $table->enum('status', ['free', 'occupied', 'reserved'])->default('free');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_tables');
    }
};
