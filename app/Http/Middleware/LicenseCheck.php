<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LicenseCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Kata Rahasia (Salt) - Jangan beritahu siapapun!
        $salt = "KONOHA_SECRET_2024"; 
        $domain = $request->getHost();
        
        // Generate kunci yang diharapkan berdasarkan domain yang sedang diakses
        $expectedKey = md5($domain . $salt);

        // Jika Key di config tidak cocok dengan kunci domain, kunci aplikasi!
        if (config('app.license_key') !== $expectedKey) {
            return response()->view('errors.license', [], 403);
        }

        return $next($request);
    }
}
