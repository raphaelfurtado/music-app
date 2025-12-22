<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepertoireController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. PÁGINA INICIAL (Pública)
// Essa rota carrega o arquivo 'resources/views/welcome.blade.php' (seu code 1.html)
Route::get('/', function () {
    return view('welcome');
});

// 2. ROTAS PROTEGIDAS (Só acessa logado)
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [RepertoireController::class, 'index'])->name('dashboard');
    Route::resource('repertoires', RepertoireController::class);

    Route::get('blocks/{block}/edit', [BlockController::class, 'edit'])->name('blocks.edit');
    
    // Blocos e Sugestões
    Route::get('repertoires/{repertoire}/blocks/create', [BlockController::class, 'create'])->name('blocks.create');
    Route::delete('blocks/{block}', [BlockController::class, 'destroy'])->name('blocks.destroy');
    Route::get('/suggestions', [SuggestionController::class, 'index'])->name('suggestions');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('songs', SongController::class);
});

require __DIR__.'/auth.php';