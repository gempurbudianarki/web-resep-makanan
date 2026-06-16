<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE recipes ADD FULLTEXT INDEX recipes_search (title, description)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE recipes DROP INDEX recipes_search');
    }
};
