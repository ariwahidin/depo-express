<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidateSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request);

        if (Auth::check()) {
            // if ($user->session_id !== session()->getId()) {
            //     Auth::logout(); // Logout jika sesi tidak cocok
            //     return redirect('/login')->with('message', 'Session expired. Please log in again.');
            // }
        }
        return $next($request);
    }
}
