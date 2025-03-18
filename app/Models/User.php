<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel {

    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    // 表名
    protected $table = 'users';

    const TABLE_NAME = 'users';
}
