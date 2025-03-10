<?php


namespace App\Common;


class Code
{
    const OK = 200; // 请求并处理成功

    const CLIENT_ERROR = 9001; //请求错误
    const FAIL = 9002; // 操作失败
    const PARAM_ERROR = 9003; // 请求参数有误
    const DB_ERROR = 9004; // 数据库操作失败
    const SERVER_ERROR = 9005; // 服务器内部错误
    const CHECK_EMPTY_ERROR = 9006; // 不能为空
    const CHECK_UNIQUE_ERROR = 9007; // 不能重复
    const CHECK_LENGTH_ERROR = 9008; // 数据超出长度
    const CHECK_OPERATE_ERROR = 9009; // 操作数据不存在
    const SMS_ERROR = 9010; // 短信发送失败
    const AUTH_TOKEN_EMPTY_ERROR = 9011; // token无效
    const AUTH_TOKEN_EXPIRE_ERROR = 9012; // token过期
    const AUTH_LOGIN_OTHER_ERROR = 9013; // 您的账号已在别处登录
    const AUTH_BEARRE_ERROR = 9014; // token前缀不对
}
