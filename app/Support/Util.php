<?php

namespace App\Support;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * 工具类
 */
class Util
{

    /**
     * NOTES : 生成token
     * @param $arr
     * @return string
     */
    public static function tokenEncode($arr)
    {
        $privateKey = file_get_contents(resource_path('crt/private.pem'));

        $token = [
 			'exp' => time() + env('TOKEN_EXPIRE_TIME', 30*24*60*60), //过期时间,这里设置30天
            'data' => $arr //自定义信息，不要定义敏感信息
        ];

        return JWT::encode($token, $privateKey, 'RS256');
    }

    /**
     * NOTES : 解密token
     * @param $token
     * @return array|string
     */
    public static function tokenDecode($token)
    {
        try {
            $publicKey = file_get_contents(resource_path('crt/public.pem'));
            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));
            return (array) $decoded;
        } catch (Exception $e) {
            return '';
        }
    }
}
