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
            //
            for($n=2;$n<4;$n++){
                $column_name="theme_name".$n;
                $table->string($column_name)->nullable();
                $table->foreign($column_name)->references("theme_name")->on("themes");
            }
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
