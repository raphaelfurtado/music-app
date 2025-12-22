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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repertoire_id')->constrained()->onDelete('cascade');
            $table->string('name'); // "Entrada dos Noivos"
            $table->string('predominant_key')->nullable(); // "G" (ajuda na transição)
            $table->integer('order')->default(0); // Posição na lista (1, 2, 3...)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
