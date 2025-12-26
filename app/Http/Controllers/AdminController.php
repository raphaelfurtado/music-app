<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Repertoire;
use App\Models\Song;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso restrito a administradores.');
        }

        // Stats básicos
        $stats = [
            'total_users' => User::count(),
            'total_repertoires' => Repertoire::count(),
            'total_songs' => Song::count(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        // Dados para o gráfico de crescimento de usuários (últimos 30 dias)
        $usersPerDay = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Dados para o gráfico de pizza (Distribuição de Planos)
        $planDistribution = [
            'premium' => User::where('is_premium', true)->count(),
            'free' => User::where('is_premium', false)->count(),
        ];

        return view('admin.dashboard', compact('stats', 'usersPerDay', 'planDistribution'));
    }

    public function users()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso restrito a administradores.');
        }

        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function togglePremium(User $user)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $user->update(['is_premium' => !$user->is_premium]);

        return back()->with('success', 'Status Premium atualizado com sucesso!');
    }

    public function toggleAdmin(User $user)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        // Evitar que o próprio admin se remova
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Você não pode remover seus próprios privilégios de admin.');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        return back()->with('success', 'Status Admin atualizado com sucesso!');
    }

    public function settings()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $notices = [
            'message' => Setting::where('key', 'global_notice_message')->first()?->value ?? '',
            'type' => Setting::where('key', 'global_notice_type')->first()?->value ?? 'info',
            'active' => Setting::where('key', 'global_notice_active')->first()?->value ?? '0',
        ];

        $maintenance = Setting::where('key', 'maintenance_mode')->first()?->value ?? '0';

        return view('admin.settings', compact('notices', 'maintenance'));
    }

    public function updateSettings(Request $request)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        Setting::updateOrCreate(['key' => 'global_notice_message'], ['value' => $request->notice_message]);
        Setting::updateOrCreate(['key' => 'global_notice_type'], ['value' => $request->notice_type]);
        Setting::updateOrCreate(['key' => 'global_notice_active'], ['value' => $request->notice_active ? '1' : '0']);
        Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => $request->maintenance_mode ? '1' : '0']);

        return back()->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function repertoires()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $repertoires = Repertoire::where('is_public', true)
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('admin.repertoires.index', compact('repertoires'));
    }

    public function toggleFeatured(Repertoire $repertoire)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $repertoire->update(['is_featured' => !$repertoire->is_featured]);

        return back()->with('success', 'Status de destaque atualizado!');
    }

    public function rankings()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        // Top 10 usuários por número de repertórios
        $topUsers = User::withCount('repertoires')
            ->orderBy('repertoires_count', 'desc')
            ->take(10)
            ->get();

        // Músicas mais populares (as mais adicionadas em repertórios)
        $topSongs = Song::select('songs.*')
            ->join('block_song', 'songs.id', '=', 'block_song.song_id')
            ->selectRaw('count(block_song.song_id) as total_adds')
            ->groupBy('songs.id', 'songs.title', 'songs.artist', 'songs.key', 'songs.bpm', 'songs.lyrics', 'songs.user_id', 'songs.created_at', 'songs.updated_at')
            ->orderBy('total_adds', 'desc')
            ->take(10)
            ->get();

        return view('admin.rankings', compact('topUsers', 'topSongs'));
    }

    public function exportUsers()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $users = User::all();
        $csvFileName = 'usuarios_music_app_' . now()->format('Y-m-d_H-i') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$csvFileName\"",
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['ID', 'Nome', 'Email', 'Admin', 'Premium', 'Data Cadastro']);

        foreach ($users as $user) {
            fputcsv($handle, [
                $user->id,
                $user->name,
                $user->email,
                $user->is_admin ? 'Sim' : 'Não',
                $user->is_premium ? 'Sim' : 'Não',
                $user->created_at->format('d/m/Y H:i')
            ]);
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }
}
