<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model {
  // 时间设置为 Unix 时间戳
  protected $dateFormat = 'U';

  public function getDateFormat() {
    return 'U';
  }

}
