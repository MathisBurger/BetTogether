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
        Schema::table('bets', function (Blueprint $table) {
            $table->dropForeign('creator_id');
            $table->foreign('creator_id')->references('id')->on('users')->nullOnDelete();
        });
        Schema::table('communities', function (Blueprint $table) {
            $table->dropForeign('admin_id');
            $table->foreign('admin_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
