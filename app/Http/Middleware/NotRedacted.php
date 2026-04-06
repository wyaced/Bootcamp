<?php

namespace App\Http\Middleware;

use App\Models\Chirp;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotRedacted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $chirp = $request->route('chirp');

        if (!$chirp) {
            return redirect()->back()->with('error', 'Chirp not found.');
        }

        if ($chirp->is_redacted) {
            return redirect()->back()->with('error', 'This chirp has been redacted and cannot be edited. However, you may delete it if you wish.');
        }

        return $next($request);
    }
}
