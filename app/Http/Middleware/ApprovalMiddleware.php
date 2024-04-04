<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApprovalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if (!auth()->user()->approved) {
                auth()->logout();
                if ($request->ajax()) {
                    return response()->json([
                        'message' => 'Your accounts needs an administrator approval in order to log in.'
                    ], Response::HTTP_UNAUTHORIZED);
                } else {
                    return redirect()->route('login')->with('message', 'Your accounts needs an administrator approval in order to log in.');
                }
            }
        }

        return $next($request);
    }
}
