<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    public function loginWithGoogleToken(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'credential' => ['required', 'string'],
        ]);

        try {
            $payload = $this->decodeAndValidateGoogleIdToken($validated['credential']);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Token Google invalido ou expirado.',
            ], 422);
        }

        $googleId = $payload['sub'] ?? null;
        $email = $payload['email'] ?? null;
        $name = $payload['name'] ?? null;
        $avatar = $payload['picture'] ?? null;
        $emailVerified = $payload['email_verified'] ?? false;

        if (!$googleId || !$email) {
            return response()->json([
                'message' => 'Dados de usuario Google incompletos.',
            ], 422);
        }

        if (!in_array($emailVerified, [true, 'true', 1, '1'], true)) {
            return response()->json([
                'message' => 'E-mail Google nao verificado.',
            ], 422);
        }

        $user = User::where('google_id', $googleId)->first();

        if (!$user) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleId,
                    'avatar' => $avatar,
                ]);
            } else {
                $user = User::create([
                    'name' => $name ?: Str::before($email, '@'),
                    'email' => $email,
                    'google_id' => $googleId,
                    'avatar' => $avatar,
                    'password' => bcrypt(Str::random(32)),
                ]);
            }
        }

        Auth::login($user, true);

        return response()->json([
            'message' => 'Login realizado com sucesso.',
            'redirect' => route('dashboard'),
        ]);
    }

    private function decodeAndValidateGoogleIdToken(string $idToken): array
    {
        $jwks = Cache::remember('google_jwks', now()->addHours(6), function () {
            $response = Http::timeout(8)->get('https://www.googleapis.com/oauth2/v3/certs');

            if (!$response->successful()) {
                throw new \RuntimeException('Falha ao buscar chaves publicas do Google.');
            }

            $data = $response->json();
            if (!is_array($data) || empty($data['keys']) || !is_array($data['keys'])) {
                throw new \RuntimeException('JWKS Google invalido.');
            }

            return $data;
        });

        $keys = JWK::parseKeySet($jwks);
        $decoded = JWT::decode($idToken, $keys);
        $payload = (array) $decoded;

        $expectedAud = config('services.google.client_id');
        if (!$expectedAud || ($payload['aud'] ?? null) !== $expectedAud) {
            throw new \RuntimeException('Audience invalida.');
        }

        $issuer = $payload['iss'] ?? null;
        if (!in_array($issuer, ['accounts.google.com', 'https://accounts.google.com'], true)) {
            throw new \RuntimeException('Issuer invalido.');
        }

        return $payload;
    }
}
