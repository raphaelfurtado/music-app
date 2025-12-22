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
        Schema::create('repertoires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // "Casamento João & Maria"
            $table->text('description')->nullable(); // "Acústico..."
            $table->string('icon')->default('library_music'); // Ícone do Material Symbols
            $table->string('color')->nullable(); // Ex: "blue" (opcional para customização)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repertoires_tabl');
    }
};
