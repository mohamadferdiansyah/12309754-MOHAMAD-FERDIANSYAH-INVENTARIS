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
        Schema::table('returned_items', function (Blueprint $table) {
            $table->integer('good_condition')->default(0);
            $table->integer('broken')->default(0);
            $table->integer('missing')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('returned_items', function (Blueprint $table) {
            //
        });
    }
};
