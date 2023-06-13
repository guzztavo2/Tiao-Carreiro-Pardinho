<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\FrontEndCode;

class CodeFrontEnd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $code = FrontEndCode::getCode()->code;
        $front_end_code = $request->header('code');
        $front_end_code = $front_end_code !== null ? FrontEndCode::decrypt($front_end_code) : null;
        if ($front_end_code == null || strcmp($code, $front_end_code) !== 0)
            FrontEndCode::redirectError();

        return $next($request);
    }
}