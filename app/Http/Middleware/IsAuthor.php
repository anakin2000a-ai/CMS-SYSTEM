<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAuthor
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->is_author != true) {
            return response()->json([
                'message' => 'Unauthorized. Only authors can create articles.'
            ], 403);
        }

        return $next($request);
    }
}
