<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends BaseModel {
    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    // 表名
    protected $table = 'admin';

    const TABLE_NAME = 'admin';
}
