<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRegisterToken
{
    /**
     * Blokir akses ke halaman register jika token tidak cocok.
     * Token diatur di .env → REGISTER_TOKEN=xxxxx
     * Akses: /register?token=xxxxx
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validToken = config('app.register_token');

        // Jika token belum diset di .env, tolak semua akses
        if (empty($validToken)) {
            abort(403, 'Registrasi tidak tersedia.');
        }

        $inputToken = $request->query('token');

        if ($inputToken !== $validToken) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Link registrasi tidak valid atau sudah kedaluwarsa.']);
        }

        return $next($request);
    }
}
