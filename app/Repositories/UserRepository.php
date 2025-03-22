<?php

namespace App\Repositories;

use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository {

    public function model() {
        return User::class;
    }

    public function getAccount($account, $column = ['*']) {
        return $this->model->select($column)->where(function ($q) use ($account) {
            $q->where('name', '=', $account)->orWhere('email', '=', $account);
        })->first()->toArray();
    }

}
