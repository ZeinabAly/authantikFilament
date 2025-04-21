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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nocmd')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('address_id')->unsigned(); //Si lieu est sur place ou a emporter, l'adresse est Authantik
            $table->decimal('subtotal');
            $table->decimal('discount')->default(0);
            $table->decimal('tax');
            $table->decimal('total');
            $table->string('name');
            $table->string('phone');
            $table->enum('lieu', ['Sur place', 'A emporter', 'A livrer'])->default('Sur place');
            $table->enum('status', ['En cours', 'Livrée', 'Annulée'])->default('En cours');
            $table->string('note')->nullable();
            $table->boolean('is_shipping_different')->default(false);
            $table->date('delivred_date')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
