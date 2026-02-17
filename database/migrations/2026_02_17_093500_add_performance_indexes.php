<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ============================================================
        // TABLE : orders
        // Colonnes souvent filtrées/triées dans votre Filament
        // ============================================================
        Schema::table('orders', function (Blueprint $table) {
            // Filtrée dans OrderResource, StatsCaisse, StatsClient
            $table->index('status');

            // Filtrée dans OrderResource
            $table->index('lieu');

            // Clé étrangère sans index auto (déclarée avec bigInteger + foreign)
            $table->index('user_id');
            $table->index('address_id');

            // Triée dans StatsCaisse : whereDate('created_at', ...)
            $table->index('created_at');

            // Filtrée dans StatsCaisse : whereNotNull('delivred_date')
            $table->index('delivred_date');

            // Index composé : requête la plus fréquente dans StatsCaisse
            // Order::whereDate('created_at', $today)->where('status', 'Livrée')
            $table->index(['status', 'created_at']);

            // Filtrée pour masquer les commandes : hidden_by_user = false
            $table->index('hidden_by_user');
        });

        // ============================================================
        // TABLE : order_items
        // Jointures très fréquentes (withCount, MostOrderedDishes...)
        // ============================================================
        Schema::table('order_items', function (Blueprint $table) {
            // Clé étrangère sans index auto → jointure order → order_items
            $table->index('order_id');
            $table->index('product_id');
        });

        // ============================================================
        // TABLE : products
        // Colonnes filtrées dans ProductResource et front
        // ============================================================
        Schema::table('products', function (Blueprint $table) {
            // Filtré dans ProductResource
            $table->index('stock_status');

            // Filtré sur la page d'accueil du front
            $table->index('featured');
            $table->index('platDuJour');

            // Clé étrangère sans index auto (déclarée avec bigInteger + foreign)
            $table->index('sousCategory_id');

            // Tri par date dans ProductResource
            $table->index('created_at');
        });

        // ============================================================
        // TABLE : reservations
        // Note : 'date' est déjà indexé dans votre migration d'origine !
        // On ajoute juste user_id et status
        // ============================================================
        Schema::table('reservations', function (Blueprint $table) {
            // Clé étrangère sans index auto
            $table->index('user_id');

            // Filtré dans ReservationResource
            $table->index('status');
        });

        // ============================================================
        // TABLE : transactions
        // Jointures avec orders et users
        // ============================================================
        Schema::table('transactions', function (Blueprint $table) {
            // Clés étrangères sans index auto
            $table->index('order_id');
            $table->index('user_id');

            // Filtré pour les rapports
            $table->index('status');
        });

        // ============================================================
        // TABLE : addresses
        // Jointure fréquente depuis orders
        // ============================================================
        Schema::table('addresses', function (Blueprint $table) {
            // Clé étrangère sans index auto
            $table->index('user_id');
        });

        // ============================================================
        // TABLE : depenses
        // Requête dans StatsCaisse : whereDate('date', $today)->sum('montant')
        // ============================================================
        Schema::table('depenses', function (Blueprint $table) {
            $table->index('date');
        });

        // ============================================================
        // TABLE : employees
        // ============================================================
        Schema::table('employees', function (Blueprint $table) {
            // Clé étrangère sans index auto
            $table->index('user_id');

            // Filtré dans EmployeeResource
            $table->index('is_active');
        });

        // ============================================================
        // TABLE : sous_categories
        // ============================================================
        Schema::table('sous_categories', function (Blueprint $table) {
            // Déjà indexé via foreignId()->constrained() mais on s'assure
            // (si ce n'est pas le cas avec bigInteger + foreign)
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['lieu']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['address_id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['delivred_date']);
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['hidden_by_user']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['stock_status']);
            $table->dropIndex(['featured']);
            $table->dropIndex(['platDuJour']);
            $table->dropIndex(['sousCategory_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('depenses', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('sous_categories', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
        });
    }
};