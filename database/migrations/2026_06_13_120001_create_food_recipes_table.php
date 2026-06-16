<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cooking_time')->default(0);
            $table->unsignedInteger('serving_size')->default(1);
            $table->unsignedInteger('calories')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_recipes');
    }
};
