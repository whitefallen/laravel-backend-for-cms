<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
				header('Access-Control-Allow-Origin: *');
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['info' => 440, 'status' => 'Token is Invalid']);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(['info' => 440, 'status' => 'Token is Expired']);
                }else{
                    return response()->json(['info' => 440, 'status' => 'Authorization Token not found']);
                }
            }
            return $next($request);
    }
}
