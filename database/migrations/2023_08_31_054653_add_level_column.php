<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // levelを追加した時のmigration
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quiz_lists', function (Blueprint $table) {
            $table->integer("level");
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
