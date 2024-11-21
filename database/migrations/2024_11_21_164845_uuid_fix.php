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
        $tables = [
            'communities',
            'bets',
            'placed_bets',
            'bet_answers',
            'leaderboards',
            'standings',
        ];

        Schema::drop('community_bet_creators');
        Schema::drop('community_members');

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                // Add a temporary UUID column
                $table->uuid('uuid')->nullable();
            });
        }

        // Populate the new UUID column with generated UUIDs
        foreach ($tables as $table) {
            DB::table($table)->update(['uuid' => DB::raw('uuid_generate_v4()')]);
        }

        Schema::table('bets', function (Blueprint $table) {
            $table->dropForeign(['community_id']);
            $table->dropColumn('community_id');
            $table->dropForeign(['creator_id']);
            $table->dropColumn('creator_id');
        });

        Schema::table('placed_bets', function (Blueprint $table) {
            $table->dropForeign(['bet_id']);
            $table->dropColumn('bet_id');
        });

        Schema::table('bet_answers', function (Blueprint $table) {
            $table->dropForeign(['bet_id']);
            $table->dropColumn('bet_id');
            $table->dropForeign(['placed_bet_id']);
            $table->dropColumn('placed_bet_id');
        });

        Schema::table('leaderboards', function (Blueprint $table) {
            $table->dropForeign(['community_id']);
            $table->dropColumn('community_id');
        });

        Schema::table('standings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropForeign(['leaderboard_id']);
            $table->dropColumn('leaderboard_id');
        });

        // Replace old ID columns with UUID
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropPrimary(); // Drop old primary key
                $table->dropColumn('id'); // Drop the old ID column
                $table->renameColumn('uuid', 'id'); // Rename the UUID column to ID
                $table->primary('id'); // Set the new ID column as the primary key
            });
        }

        // Re-add foreign keys with updated references
        Schema::create('community_members', function (Blueprint $table) {
            $table->uuid('community_id');
            $table->bigInteger('member_id');
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['community_id', 'member_id']);
        });

        Schema::create('community_bet_creators', function (Blueprint $table) {
            $table->uuid('community_id');
            $table->bigInteger('creator_id');
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['community_id', 'creator_id']);
        });

        Schema::table('bets', function (Blueprint $table) {
            $table->uuid('community_id');
            $table->bigInteger('creator_id');
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('placed_bets', function (Blueprint $table) {
            $table->uuid('bet_id');
            $table->foreign('bet_id')->references('id')->on('bets')->onDelete('cascade');
        });

        Schema::table('bet_answers', function (Blueprint $table) {
            $table->uuid('bet_id')->nullable();
            $table->uuid('placed_bet_id')->nullable();
            $table->foreign('bet_id')->references('id')->on('bets')->onDelete('cascade');
            $table->foreign('placed_bet_id')->references('id')->on('placed_bets')->onDelete('cascade');
        });

        Schema::table('leaderboards', function (Blueprint $table) {
            $table->uuid('community_id');
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
        });

        Schema::table('standings', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->uuid('leaderboard_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('leaderboard_id')->references('id')->on('leaderboards')->onDelete('cascade');
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
