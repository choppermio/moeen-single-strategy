<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\ResponseRedirect)  $next
     * @param  string  $permission
     * @return \Illuminate\Http\Response|\Illuminate\Http\ResponseRedirect
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $position = current_user_position();
        
        if (!$position) {
            abort(403, 'ليس لديك صلاحية الوصول إلى هذه الصفحة');
        }

        // Check if user has the required permission
        if (!$position->hasPermission($permission)) {
            abort(403, 'ليس لديك صلاحية الوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
}
