<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotDeleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $chirp = $request->route('chirp');

        if (!$chirp || $chirp->is_deleted) {
            return redirect()->back()->with('error', 'Chirp not found.');
        }

        return $next($request);
    }
}
