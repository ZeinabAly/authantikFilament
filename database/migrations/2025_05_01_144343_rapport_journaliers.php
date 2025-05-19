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
        Schema::create('rapport_journaliers', function(Blueprint $table){
            $table->id();
            $table->date('date')->unique();
            $table->decimal('total_ventes', 10, 0);
            $table->decimal('total_depenses', 10, 0);
            $table->decimal('benefice', 10, 0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapport_journaliers');
    }
};
