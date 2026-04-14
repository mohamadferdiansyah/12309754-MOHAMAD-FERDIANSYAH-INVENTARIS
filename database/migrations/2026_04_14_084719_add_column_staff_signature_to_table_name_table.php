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
        Schema::table('borrowed_items', function (Blueprint $table) {
            $table->string('staff_signature')->nullable(); // Path tanda tangan staff
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrwed_items', function (Blueprint $table) {
            //
        });
    }
};
