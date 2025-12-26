<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepertoireController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\SocialLoginController;
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

    $mode = request('mode'); // fresh ou vazio

    // 2. Tenta rodar a migration
    try {
        if ($mode === 'fresh') {
            Artisan::call('migrate:fresh', ['--force' => true]);
            $msg = "BANCO RESETADO E RECURSADO: ";
        } else {
            Artisan::call('migrate', ['--force' => true]);
            $msg = "MIGRATIONS EXECUTADAS: ";
        }

        return $msg . nl2br(Artisan::output());
    } catch (\Exception $e) {
        return 'ERRO AO RODAR MIGRATIONS: ' . $e->getMessage() . '<br><br>DICA: Se o banco estiver vazio mas com tabelas residuais, tente adicionar "&mode=fresh" ao final da URL (CUIDADO: isso apaga todos os dados!).';
    }
});

Route::get('/auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);

// 1. PÁGINA INICIAL (Pública)
// Essa rota carrega o arquivo 'resources/views/welcome.blade.php' (seu code 1.html)
Route::get('/', function () {
    // Se o usuário já estiver logado, manda direto para a lista de repertórios
    if (auth()->check()) {
        return redirect()->route('repertoires.index');
    }

    $featuredRepertoires = \App\Models\Repertoire::where('is_featured', true)
        ->with('user')
        ->take(6)
        ->get();

    // Se não, mostra a tela de boas-vindas
    return view('welcome', compact('featuredRepertoires'));
});

Route::get('/r/{slug}', [RepertoireController::class, 'publicShow'])->name('repertoires.public');

// 2. ROTAS PROTEGIDAS (Só acessa logado)
Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    });

    Route::get('/dashboard', [RepertoireController::class, 'index'])->name('dashboard');
    Route::post('repertoires/{repertoire}/duplicate', [RepertoireController::class, 'duplicate'])->name('repertoires.duplicate');
    Route::match(['get', 'post'], 'repertoires/{repertoire}/toggle-public', [RepertoireController::class, 'togglePublic'])->name('repertoires.toggle-public');
    Route::get('repertoires/{repertoire}/export', [RepertoireController::class, 'exportPdf'])->name('repertoires.export');
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

    // Admin Dashboard (Protegido no Controller)
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users.index');
    Route::post('/admin/users/{user}/toggle-premium', [App\Http\Controllers\AdminController::class, 'togglePremium'])->name('admin.users.toggle-premium');
    Route::post('/admin/users/{user}/toggle-admin', [App\Http\Controllers\AdminController::class, 'toggleAdmin'])->name('admin.users.toggle-admin');
    Route::get('/admin/settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('admin.settings.index');
    Route::post('/admin/settings', [App\Http\Controllers\AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::get('/admin/repertoires', [App\Http\Controllers\AdminController::class, 'repertoires'])->name('admin.repertoires.index');
    Route::post('/admin/repertoires/{repertoire}/toggle-featured', [App\Http\Controllers\AdminController::class, 'toggleFeatured'])->name('admin.repertoires.toggle-featured');
    Route::get('/admin/rankings', [App\Http\Controllers\AdminController::class, 'rankings'])->name('admin.rankings.index');
    Route::get('/admin/export-users', [App\Http\Controllers\AdminController::class, 'exportUsers'])->name('admin.export.users');

    // Rota Temporária para se tornar Admin (Acesse uma vez para testar o painel)
    Route::get('/make-me-admin', function () {
        auth()->user()->update(['is_admin' => true]);
        return redirect()->route('admin.dashboard')->with('success', 'Agora você é um administrador!');
    });
});

require __DIR__ . '/auth.php';