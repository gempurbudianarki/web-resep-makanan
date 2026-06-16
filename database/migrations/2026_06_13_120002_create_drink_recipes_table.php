<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drink_recipes', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_cold')->default(true);
            $table->string('glass_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drink_recipes');
    }
};
