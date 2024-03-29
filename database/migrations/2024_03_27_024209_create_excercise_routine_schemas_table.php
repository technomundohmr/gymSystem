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
        Schema::create('exercise_routine_schemas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('routine_id')->constrained('routines');
            $table->foreignId('exercise_id')->constrained('exercises');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('repets');
            $table->integer('wieigh');
            $table->string('wieigh_unit');
            $table->integer('timelapse');
            $table->string('timelapse_unit');
            $table->foreignId('created_by_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excercise_routine_schemas');
    }
};
