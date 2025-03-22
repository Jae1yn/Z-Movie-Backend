<?php

namespace App\Http\Controllers\Admin;

use App\Common\Code;
use App\Common\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Traits\TokenTrait;
use App\Repositories\AdminRepository;
use App\Support\Util;
use Illuminate\Support\Arr;

class LoginController extends Controller {

    use TokenTrait;

    const TOKEN_PRIVATE_KEY_PATH = 'crt/admin/private.pem';

    protected AdminRepository $repository;

    public function __construct(AdminRepository $repository) {
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
        $account = Arr::get($data, 'account');
        $info = $this->repository->getAccount($account, ['id', 'name', 'email', 'password']);
        if (empty($info)) {
            return codeRender(Code::LOGIN_ACCOUNT_PWD_ERROR);
        }

        if (!blank($password) && !password_verify($password, $info['password'])) {
            return codeRender(Code::LOGIN_ACCOUNT_PWD_ERROR);
        }

        unset($info['password']);
        $token = Util::tokenEncode($info, self::TOKEN_PRIVATE_KEY_PATH);
        $this->delToken($info['email']);
        $this->setToken($info['email'], $token);
        $info['token'] = $token;
        return codeRender(Code::OK, $info);
    }

    /**
     * Logout.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function logout() {
        $email = app(Constants::ADMIN_LOGIN)['email'];
        $this->delToken($email);

        return codeRender(Code::OK);
    }
}
