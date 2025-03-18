<?php

namespace App\Http\Controllers\User;

use App\Common\Code;
use App\Common\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Traits\TokenTrait;
use App\Repositories\UserRepository;
use App\Support\Util;
use Illuminate\Support\Arr;

class LoginController extends Controller {

    use TokenTrait;

    protected $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Login.
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request) {
        $data = $this->filter($request);
        $password = Arr::get($data, 'password');
        $user = $this->repository->detail(['email' => Arr::get($data, 'email')], ['id', 'name', 'email', 'password']);
        if (empty($user)) {
            return codeRender(Code::LOGIN_ACCOUNT_PWD_ERROR);
        }

        if (!blank($password) && !password_verify($password, $user['password'])) {
            return codeRender(Code::LOGIN_ACCOUNT_PWD_ERROR);
        }

        unset($user['password']);
        $token = Util::tokenEncode($user);
        $this->delToken($user['email']);
        $this->setToken($user['email'], $token);
        $user['token'] = $token;
        return codeRender(Code::OK, $user);
    }

    /**
     * Logout.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function logout() {
        $email = app(Constants::LOGIN)['email'];
        $this->delToken($email);

        return codeRender(Code::OK);
    }
}
