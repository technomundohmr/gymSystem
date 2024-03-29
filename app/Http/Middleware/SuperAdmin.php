<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if(!empty($token)) {
            $user = Auth::guard('sanctum')->user();

            if(!empty($user)){
                $role = $user->role->machine_id;
                if($role == 'admin') {
                    return $next($request);
                }
            }
        }
        
        return response()->json(['error' => 'Por favor ingrese con un usuario superadministrador'], 403);
    }
}
