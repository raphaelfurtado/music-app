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
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Verifica se já existe pelo ID do Google
            $user = User::where('google_id', $googleUser->id)->first();

            if(!$user){
                // Se não achou pelo ID, tenta pelo E-mail (caso a pessoa já tenha conta normal)
                $user = User::where('email', $googleUser->email)->first();

                if($user) {
                    // Atualiza o ID do Google na conta existente
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar
                    ]);
                } else {
                    // Cria um novo usuário
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                        'password' => bcrypt(Str::random(16)) // Senha aleatória segura
                    ]);
                }
            }

            // Realiza o Login
            Auth::login($user);

            return redirect()->route('dashboard'); // Ou para onde desejar

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Erro ao logar com Google.');
        }
    }
}