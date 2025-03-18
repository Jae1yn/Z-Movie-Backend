<?php

namespace App\Http\Traits;

use App\Common\Constants;
use App\Common\RedisConstant;
use Illuminate\Support\Facades\Redis;

trait TokenTrait {
    public function setToken(string $email, $token) {
        $key = $this->getLoginKey($email);
        Redis::setex($key, 2592000, $token);//默认30天
    }

    public function getToken($email) {
        $key = $this->getLoginKey($email);
        return Redis::get($key);
    }

    public function delToken($email, $accessSource = FALSE) {
        $key = $this->getLoginKey($email, $accessSource);
        Redis::del($key);
    }

    protected function getLoginKey($email, $accessSource = FALSE) {
        $source = (bool) $accessSource ? $accessSource : app(Constants::ACCESS_SOURCE);
        return RedisConstant::USER_TOKEN . $email . $source;
    }
}
