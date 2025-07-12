<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserId
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

      /*  if (current_user_position()->id != 4 || current_user_position()->id != 5) {
            return response('Unauthorized.', 401);
        }
*/
        return $next($request);
    }
}
