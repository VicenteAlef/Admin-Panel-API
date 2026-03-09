<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\TwoFactorCodeMail;

class AuthController extends Controller
{
    /**
     * Passo 1: Valida credenciais e envia código 2FA
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Tenta validar as credenciais (mas NÃO loga o usuário ainda)
        if (!Auth::validate($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        $user = User::where('email', $request->email)->first();

        // Verifica se está ativo
        if (!$user->is_active) {
            return response()->json(['error' => 'Usuário inativo'], 403);
        }

        // Gera código de 6 dígitos numéricos
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Salva no banco
        $user->update(['two_factor_code' => $code]);

        // Envia o e-mail (em produção é ideal colocar em fila - Queue)
        Mail::to($user->email)->send(new TwoFactorCodeMail($code));

        return response()->json([
            'message' => 'Código de verificação enviado para o seu e-mail.',
            'step' => '2fa_required',
            'email' => $user->email
        ]);
    }

    /**
     * Passo 2: Valida o código 2FA e retorna o JWT
     */
    public function verify2FA(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->two_factor_code !== $request->code) {
            return response()->json(['error' => 'Código inválido ou expirado.'], 401);
        }

        // Código correto: limpa o 2FA, marca como online e gera o token JWT
        $user->update([
            'two_factor_code' => null,
            'is_online' => true
        ]);

        // Gera o token efetivamente logando o usuário
        $token = Auth::login($user);

        return $this->respondWithToken($token);
    }

    /**
     * Retorna os dados do usuário autenticado
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Desloga (invalida o token) e marca como offline
     */
    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->update(['is_online' => false]);
        }

        Auth::logout();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    /**
     * Atualiza o token expirado
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Formata o array de resposta com o token
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user() // Opcional: já devolver os dados do usuário junto com o token
        ]);
    }
}
