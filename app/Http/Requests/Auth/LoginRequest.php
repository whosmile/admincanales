<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\WebTransactionalLog;
use App\Models\BitacoraAdministrativa;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            // Registrar intento fallido en ambas bitácoras
            $user = User::where('username', $this->input('username'))->first();
            
            $logData = [
                'user_id' => $user ? $user->id : null,
                'usuario' => $user ? ($user->name . ' ' . $user->apellido) : $this->input('username'),
                'accion' => 'intento_fallido_login',
                'modulo' => 'Autenticación',
                'detalles' => 'Intento fallido de inicio de sesión',
                'ip' => $this->ip(),
                'user_agent' => $this->userAgent()
            ];

            WebTransactionalLog::create($logData + [
                'datos_nuevos' => json_encode([
                    'username' => $this->input('username'),
                    'intentos' => RateLimiter::attempts($this->throttleKey())
                ])
            ]);

            BitacoraAdministrativa::create($logData);

            throw ValidationException::withMessages([
                'username' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        // Registrar inicio de sesión exitoso en ambas bitácoras
        $user = Auth::user();
        $logData = [
            'user_id' => $user->id,
            'usuario' => $user->name . ' ' . $user->apellido,
            'accion' => 'inicio_sesion',
            'modulo' => 'Autenticación',
            'detalles' => 'El usuario ha iniciado sesión en el sistema',
            'ip' => $this->ip(),
            'user_agent' => $this->userAgent()
        ];

        WebTransactionalLog::create($logData);
        BitacoraAdministrativa::create($logData);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Registrar bloqueo por intentos excesivos en ambas bitácoras
        $user = User::where('username', $this->input('username'))->first();

        $logData = [
            'user_id' => $user ? $user->id : null,
            'usuario' => $user ? ($user->name . ' ' . $user->apellido) : $this->input('username'),
            'accion' => 'bloqueo_por_intentos',
            'modulo' => 'Autenticación',
            'detalles' => 'Usuario bloqueado por exceder el límite de intentos de inicio de sesión',
            'ip' => $this->ip(),
            'user_agent' => $this->userAgent()
        ];

        WebTransactionalLog::create($logData + [
            'datos_nuevos' => json_encode([
                'username' => $this->input('username'),
                'tiempo_bloqueo_segundos' => $seconds,
                'intentos_realizados' => RateLimiter::attempts($this->throttleKey())
            ])
        ]);

        BitacoraAdministrativa::create($logData);

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('username')).'|'.$this->ip());
    }
}
