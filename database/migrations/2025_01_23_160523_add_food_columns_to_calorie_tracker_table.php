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
        Schema::table('calorie_tracker', function (Blueprint $table) {
            $table->string('morning_breakfast_food')->nullable();
            $table->string('lunch_food')->nullable();
            $table->string('evening_snacks_food')->nullable();
            $table->string('dinner_food')->nullable();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calorie_tracker', function (Blueprint $table) {
            $table->dropColumn(['morning_breakfast_food', 'lunch_food', 'evening_snacks_food', 'dinner_food']);
        });
    }
};
