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

Route::get('/rodar-migrations-secreto', function () {
    // 1. Segurança: Verifica a senha que você colocou no YAML
    if (request('key') !== '123456') {
        abort(403, 'Acesso negado');
    }

    // 2. Tenta rodar a migration
    try {
        Artisan::call('migrate', ['--force' => true]);
        return 'Sucesso: ' . nl2br(Artisan::output());
    } catch (\Exception $e) {
        return 'Erro: ' . $e->getMessage();
    }
});

// 1. PÁGINA INICIAL (Pública)
// Essa rota carrega o arquivo 'resources/views/welcome.blade.php' (seu code 1.html)
Route::get('/', function () {
    // Se o usuário já estiver logado, manda direto para a lista de repertórios
    if (auth()->check()) {
        return redirect()->route('repertoires.index');
    }
    
    // Se não, mostra a tela de boas-vindas
    return view('welcome');
});

// 2. ROTAS PROTEGIDAS (Só acessa logado)
Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    });

    Route::get('/dashboard', [RepertoireController::class, 'index'])->name('dashboard');
    Route::resource('repertoires', RepertoireController::class);

    Route::get('blocks/{block}/edit', [BlockController::class, 'edit'])->name('blocks.edit');

    // Blocos e Sugestões
    Route::get('repertoires/{repertoire}/blocks/create', [BlockController::class, 'create'])->name('blocks.create');
    Route::delete('blocks/{block}', [BlockController::class, 'destroy'])->name('blocks.destroy');
    Route::get('/suggestions', [SuggestionController::class, 'index'])->name('suggestions');

    // Perfil
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('songs', SongController::class);

    // Rota de Músicas (Lista de todas as músicas)
    Route::get('/songs', [App\Http\Controllers\SongController::class, 'index'])->name('songs.index');
    
    // Rotas de Criar/Salvar música (que já configuramos antes)
    Route::get('/songs/create', [App\Http\Controllers\SongController::class, 'create'])->name('songs.create');
    Route::post('/songs', [App\Http\Controllers\SongController::class, 'store'])->name('songs.store');

    // Rota de Perfil
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
});

require __DIR__ . '/auth.php';