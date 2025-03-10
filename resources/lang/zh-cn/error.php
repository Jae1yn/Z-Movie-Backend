<?php

use App\Common\Code;

return [
    Code::OK => '操作成功',

    Code::FAIL                => '操作失败',
    Code::PARAM_ERROR         => '请求参数错误',
    Code::DB_ERROR            => '数据库操作错误',
    Code::SERVER_ERROR        => '服务器内部错误',
    Code::CHECK_EMPTY_ERROR   => '不能为空',
    Code::CHECK_UNIQUE_ERROR  => '已经存在',
    Code::CHECK_LENGTH_ERROR  => '超出长度',
    Code::CHECK_OPERATE_ERROR => '操作数据不存在',

    Code::SMS_ERROR               => '短信发送失败',
    Code::AUTH_TOKEN_EMPTY_ERROR  => 'token无效',
    Code::AUTH_BEARRE_ERROR       => '请求header无效',
    Code::AUTH_TOKEN_EXPIRE_ERROR => 'Token过期',
    Code::AUTH_LOGIN_OTHER_ERROR  => '您的账号已在别处登录',
];
