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
    public function redirectToGoogle(Request $request)
    {
        if ($request->boolean('popup')) {
            session(['google_login_popup' => true]);
        }

        $provider = Socialite::driver('google');
        if (method_exists($provider, 'stateless')) {
            $provider = $provider->stateless();
        }

        return $provider
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    // 2. Recebe o retorno do Google
    public function handleGoogleCallback()
    {
        $isPopupFlow = session()->pull('google_login_popup', false);

        try {
            $provider = Socialite::driver('google');
            if (method_exists($provider, 'stateless')) {
                $provider = $provider->stateless();
            }

            $googleUser = $provider->user();
            
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

            if ($isPopupFlow) {
                return view('auth.social-popup-callback', [
                    'success' => true,
                    'redirectUrl' => route('dashboard'),
                    'message' => 'Login realizado com sucesso.'
                ]);
            }

            return redirect()->route('dashboard'); // Ou para onde desejar

        } catch (\Exception $e) {
            if ($isPopupFlow) {
                return view('auth.social-popup-callback', [
                    'success' => false,
                    'redirectUrl' => route('login'),
                    'message' => 'Erro ao logar com Google.'
                ]);
            }

            return redirect()->route('login')->with('error', 'Erro ao logar com Google.');
        }
    }
}