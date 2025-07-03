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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // Informations générales
            $table->string('name')->default('Mon Restaurant');
            $table->string('slogan')->nullable();
            $table->text('description')->nullable();
            
            // Design et branding
            $table->string('logo_path')->nullable();
            $table->string('primary_color')->default('#ff6b6b');
            $table->string('secondary_color')->default('#4ecdc4');
            $table->string('accent_color')->default('#ffd93d');
            
            // Menu
            $table->string('menu_pdf_path')->nullable();
            $table->string('menu_link')->nullable();
            $table->text('special_offers')->nullable();
            
            // Réseaux sociaux
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('snapchat_url')->nullable();
            
            // Contact
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('maps_link')->nullable();
            
            // Livraison
            $table->string('delivery_zone')->nullable();
            $table->text('delivery_apps')->nullable();
            
            // Horaires (JSON pour flexibilité)
            $table->json('opening_hours')->nullable();
            
            // Métadonnées
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
