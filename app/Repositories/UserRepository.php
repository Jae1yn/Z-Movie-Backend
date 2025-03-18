<?php

namespace App\Repositories;

use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository {

    public function model() {
        return User::class;
    }

    public function detail($param, $column = ['*']) {
        if (empty($param)) {
            return [];
        }
        $this->applyConditions($param);
        $res = $this->first($column);
        return empty($res) ? [] : $res->toArray();
    }

}
