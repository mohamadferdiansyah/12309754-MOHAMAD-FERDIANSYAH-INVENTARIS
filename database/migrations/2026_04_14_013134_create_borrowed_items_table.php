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
        Schema::create('borrowed_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('item_id')
                ->constrained('item_stocks')
                ->cascadeOnDelete();

            $table->integer('total_item');
            $table->string('name_of_borrower');
            $table->date('date');
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_items');
    }
};
