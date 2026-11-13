<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EnsurePublicSiteIsOnline
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! DB::table('variables')->where('name', 'public')->value('value')) {
            return redirect('/offline');
        }

        return $next($request);
    }
}
