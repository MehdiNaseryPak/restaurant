<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\BaseResponse;
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
        $user = $request->user();
        if(!$user->is_admin)
            return BaseResponse::error('دسترسی ندارید به این بخش',[],403);
        return $next($request);
    }
}
