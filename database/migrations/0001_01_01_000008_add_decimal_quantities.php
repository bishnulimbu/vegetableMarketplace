<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vegetables', function (Blueprint $table) {
            $table->decimal('available_quantity', 10, 2)->default(0)->change();
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->decimal('quantity', 10, 2)->default(1)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('quantity', 10, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('vegetables', function (Blueprint $table) {
            $table->integer('available_quantity')->default(0)->change();
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('quantity')->change();
        });
    }
};
