<?php

namespace App\Http\Controllers\User;

use App\Common\Code;
use App\Common\Constants;
use App\Exceptions\CodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Traits\TokenTrait;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {

    use TokenTrait;

    protected $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Update user.
     *
     * @param UpdateRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UpdateRequest $request) {
        $params = $this->filter($request);
        $id = app(Constants::LOGIN)['id'];
        try {
            $res = $this->repository->update($params, 1);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return codeRender(Code::DB_ERROR);
        }

        $user = $this->repository->find($id, ['name', 'email', 'created_at', 'updated_at']);
        return codeRender(Code::OK, $user);
    }

    /**
     * Change password
     *
     * @param ChangePasswordRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws CodeException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function changePassword(ChangePasswordRequest $request) {
        $params = $this->filter($request);

        $id = app(Constants::LOGIN)['id'];
        $user = $this->repository->find($id)->toArray();
        if (!$user) {
            throw new CodeException(Code::CHECK_OPERATE_ERROR);
        }

        if (!password_verify($params['old_password'], $user['password'])) {
            throw new CodeException(Code::LOGIN_OLD_PASSWORD_ERROR);
        }

        try {
            $res = $this->repository->update(['password' => password_hash($params['password'], PASSWORD_DEFAULT)], $id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return codeRender(Code::DB_ERROR);
        }
        $this->logoutById(app(Constants::LOGIN)['id']);

        return codeRender(Code::OK);

    }

    /**
     * Logout by id.
     *
     * @param $id
     */
    private function logoutById($id) {
        try {
            $user =$this->repository->find($id)->toArray();
            $this->delToken($user['email']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return codeRender(Code::CHECK_OPERATE_ERROR);
        }

    }

}
