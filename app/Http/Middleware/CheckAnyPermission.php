<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAnyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$permissions
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!has_any_permission($permissions)) {
            abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
}