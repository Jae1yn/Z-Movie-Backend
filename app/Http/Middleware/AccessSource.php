<?php

namespace App\Http\Middleware;

use App\Common\Constants;
use Closure;

class AccessSource {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $accessSource = $request->header('Access-Source', Constants::ACCESS_SOURCE_PC);
        app()->instance(Constants::ACCESS_SOURCE, $accessSource);

        return $next($request);
    }
}
