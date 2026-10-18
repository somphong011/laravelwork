<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // ตรวจสอบว่าผู้ใช้ล็อกอินอยู่ และ Role ตรงกับที่อนุญาตหรือไม่
        if (!$request->user() || !in_array($request->user()->role->value, $roles)) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        return $next($request);
    }
}
