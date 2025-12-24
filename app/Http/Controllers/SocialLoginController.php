<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    // 1. Redireciona o usuário para o Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Recebe o retorno do Google
    // 2. Recebe o retorno do Google
    public function handleGoogleCallback()
    {
        try {
            // TENTATIVA 1: Adicione o ->stateless() aqui.
            // Isso resolve 90% dos problemas de "InvalidStateException" em subdomínios/produção
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Verifica se já existe pelo ID do Google
            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                // Se não achou pelo ID, tenta pelo E-mail
                $user = User::where('email', $googleUser->email)->first();

                if ($user) {
                    // Atualiza conta existente
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar
                    ]);
                } else {
                    // Cria novo usuário
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                        'password' => bcrypt(Str::random(16))
                    ]);
                }
            }

            Auth::login($user);

            return redirect()->route('dashboard'); // Ajuste a rota se necessário

        } catch (\Exception $e) {
            // AQUI ESTÁ O TRUQUE: 
            // Vamos matar a execução e mostrar o erro na tela preta
            dd($e->getMessage(), $e->getTraceAsString());

            // return redirect()->route('login')->with('error', 'Erro ao logar com Google.');
        }
    }
}