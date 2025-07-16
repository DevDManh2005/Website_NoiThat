<?php

// app/Http/Middleware/EmployeeMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('employee')->check()) {
            return redirect()->route('auth.login.form');
        }

        return $next($request);
    }
}
