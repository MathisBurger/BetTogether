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
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('joinPolicy');
            $table->string('betCreationPolicy');
            $table->timestamps();
            $table->foreignId('admin_id')->constrained('users');
        });
        Schema::create('community_members', function (Blueprint $table) {
            $table->foreignId('community_id')->constrained('communities');
            $table->foreignId('member_id')->constrained('users');
            $table->primary(['community_id', 'member_id']);
        });
        Schema::create('community_bet_creators', function (Blueprint $table) {
            $table->foreignId('community_id')->constrained('communities');
            $table->foreignId('creator_id')->constrained('users');
            $table->primary(['community_id', 'creator_id']);
        });
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained('communities');
            $table->foreignId('creator_id')->constrained('users');
            $table->timestamps();
            $table->string('betText');
            $table->integer('totalPoints');
            $table->string('determinationStrategy');
            $table->dateTime('endDateTime');
            $table->boolean('isDeterminated')->default(false);
        });
        Schema::create('placed_bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bet_id')->constrained('bets');
            $table->integer('points')->nullable();
        });
        Schema::create('bet_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bet_id')->constrained('bets');
            $table->foreignId('placed_bet_id')->constrained('placed_bets');
            $table->string('type');
            $table->string('stringValue')->nullable();
            $table->integer('integerValue')->nullable();
            $table->float('floatValue')->nullable();
        });
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained('communities');
            $table->string('value');
            $table->date('periodStart')->nullable();
            $table->date('periodEnd')->nullable();
            $table->boolean('isAllTime');
        });
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('leaderboard_id')->constrained('leaderboards');
            $table->integer('rank');
            $table->integer('points');
            $table->integer('diffPointsToLastBet');
            $table->integer('diffRanksToLastBet');
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
