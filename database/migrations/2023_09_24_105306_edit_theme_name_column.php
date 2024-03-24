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
        // テーマの型をnullableにする
        Schema::table('quiz_lists', function (Blueprint $table) {
            $table->string("theme_name")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_lists', function (Blueprint $table) {
            //
        });
    }
};
