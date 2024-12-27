<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $roleAdmin = Role::where('name', 'admin')->first();

        if ($user->role_id != $roleAdmin->id) {
            return response([
                'message' => 'user tidak dapat mengakses halaman ini, yang hanya bisa hanya admin'
            ], 403);
        }

        return $next($request);
    }
}
