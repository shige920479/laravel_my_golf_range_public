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
        Schema::create('reserve_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained();
            $table->foreignId('rental_id')
            ->constrained();
            $table->foreignId('reserve_range_id')
            ->constrained()
            ->onDelete('cascade');
            $table->date('reserve_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('cancelled')->default(false);
            $table->unsignedInteger('fee');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserve_rentals');
    }
};
