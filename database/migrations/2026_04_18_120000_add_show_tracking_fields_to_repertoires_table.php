<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('repertoires', function (Blueprint $table) {
            $table->timestamp('show_started_at')->nullable()->after('is_featured');
            $table->timestamp('last_show_started_at')->nullable()->after('show_started_at');
            $table->timestamp('last_show_ended_at')->nullable()->after('last_show_started_at');
            $table->unsignedInteger('last_show_duration_seconds')->nullable()->after('last_show_ended_at');
            $table->unsignedBigInteger('total_show_duration_seconds')->default(0)->after('last_show_duration_seconds');
            $table->unsignedInteger('total_shows')->default(0)->after('total_show_duration_seconds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repertoires', function (Blueprint $table) {
            $table->dropColumn([
                'show_started_at',
                'last_show_started_at',
                'last_show_ended_at',
                'last_show_duration_seconds',
                'total_show_duration_seconds',
                'total_shows',
            ]);
        });
    }
};
