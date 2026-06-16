<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->after('recipe_id');
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });

        DB::table('bookmarks')->update(['created_at' => now(), 'updated_at' => now()]);
    }

    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
};
