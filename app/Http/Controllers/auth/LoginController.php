<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-store, private');
    }

    public function store(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                ],
                'password' => [
                    'required',
                    'string',
                    'max:1024',
                ],
                'remember' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'email.required' => 'Informe seu e-mail.',
                'email.email' => 'Informe um e-mail válido.',
                'email.max' => 'O e-mail deve ter no máximo 255 caracteres.',
                'password.required' => 'Informe sua senha.',
                'password.max' => 'A senha informada é muito longa.',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email', 'remember'))
                ->with(
                    'erro',
                    'Confira os campos informados e tente novamente.'
                );
        }

        $key = 'school-login:' . hash(
            'sha256',
            Str::lower($request->string('email')->toString())
                . '|'
                . $request->ip()
        );

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()
                ->withInput($request->only('email', 'remember'))
                ->with(
                    'erro',
                    "Muitas tentativas. Aguarde {$seconds} segundos para tentar novamente."
                );
        }

        $authenticated = Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        );

        if (! $authenticated) {
            RateLimiter::hit($key, 60);

            return back()
                ->withErrors([
                    'email' => 'E-mail ou senha incorretos.',
                ])
                ->withInput($request->only('email', 'remember'))
                ->with('erro', 'E-mail ou senha incorretos.');
        }

        RateLimiter::clear($key);

        $request->session()->regenerate();

        return redirect()
            ->intended(route('dashboard.index'))
            ->with(
                'sucesso',
                'Login realizado com sucesso. Bem-vindo ao EduGestão!'
            );
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'sucesso',
                'Você saiu do sistema com segurança.'
            );
    }
}