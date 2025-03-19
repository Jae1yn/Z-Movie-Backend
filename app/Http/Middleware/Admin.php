<?php

namespace App\Http\Middleware;

use App\Common\Code;
use App\Common\Constants;
use App\Http\Traits\TokenTrait;
use App\Models\User;
use App\Support\Util;
use Closure;
use Illuminate\Support\Str;

class Admin {
    use TokenTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $authorization = $request->header('Authorization');
        if (!str_contains($authorization, Constants::BASE_BEARER . ' ')) {
            return codeRender(Code::AUTH_BEARRE_ERROR);
        }

        $token = Str::substr($authorization, Str::length(Constants::BASE_BEARER) + 1);
        if (empty($token)) {
            return codeRender(Code::AUTH_TOKEN_EMPTY_ERROR);
        }

        // decode token
        $info = Util::tokenDecode($token, 'crt/admin/public.pem');
        if (empty($info)) {
            return codeRender(Code::AUTH_TOKEN_EMPTY_ERROR);
        }
        $data = (array)$info['data'];
        $email = $data['email'];

        // Validate.
        if ($info['exp'] < time()) {
            $this->delToken($email);
            return codeRender(Code::AUTH_TOKEN_EXPIRE_ERROR);
        }
        if ($this->getToken($email) != $token) {
            return codeRender(Code::AUTH_TOKEN_EXPIRE_ERROR);
        }

        $admin = Admin::findOrFail($data['id']);;
        if (!$admin) {
            return codeRender(Code::AUTH_TOKEN_EXPIRE_ERROR);
        }

        app()->instance(Constants::ADMIN_LOGIN, $data);
        return $next($request);
    }


}
