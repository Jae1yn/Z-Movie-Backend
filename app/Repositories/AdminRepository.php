<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository extends UserRepository {

    public function model() {
        return Admin::class;
    }

}
