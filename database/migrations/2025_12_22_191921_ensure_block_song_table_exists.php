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
        // Verifica se a tabela já existe para não dar erro
        if (!Schema::hasTable('block_song')) {
            Schema::create('block_song', function (Blueprint $table) {
                $table->id();
                $table->foreignId('block_id')->constrained()->onDelete('cascade');
                $table->foreignId('song_id')->constrained()->onDelete('cascade');
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
