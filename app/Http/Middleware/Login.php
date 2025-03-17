<?php

namespace App\Http\Middleware;

use App\Common\Code;
use App\Common\Constants;
use App\Http\Traits\TokenTrait;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Support\Util;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Login {
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
        $info = Util::tokenDecode($token);
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

        $user = User::findOrFail($data['id']);;
        if (!$user) {
            return codeRender(Code::AUTH_TOKEN_EXPIRE_ERROR);
        }

        app()->instance(Constants::LOGIN, $data);
        return $next($request);
    }


}
