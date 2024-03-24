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
        Schema::table('quiz_lists', function (Blueprint $table) {
            $table->text("answer2")->nullable();
            $table->text("answer3")->nullable();
            $table->text("answer4")->nullable();
            $table->text("answer5")->nullable();
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
