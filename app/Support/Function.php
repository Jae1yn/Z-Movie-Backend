<?php
if (!function_exists('codeRender')) {
    /**
     * 返回JSON
     * $code: 返回code
     * $data: 返回数据
     * $other: 额外信息
     */
    function codeRender($code, $data = '', $message = '')
    {
        $status = 200;

        $content = [
            'code'    => $code,
            'message' => !empty($message) ? $message : trans('error')[$code],
            'data'    => $data
        ];
        $headers = [];
        $headers["Spend-time"] = microtime(TRUE) - LARAVEL_START;
        return response($content, $status, $headers);
    }
}

if (!function_exists('randomInteger')) {
    function randomInteger($length = 1)
    {
        $rand = '';
        for ($i = 0; $i < $length; $i++) {
            $rand .= mt_rand(0, 9);
        }
        return $rand;
    }
}

if (!function_exists('arr2obj')) {

    function arr2obj($data, $column)
    {
        if (is_string($column)) {
            if (isset($data[$column])) {
                $data[$column] = (object)$data[$column];
            }
        } elseif (is_array($column)) {
            foreach ($column as $key => $value) {
                if (isset($data[$value])) {
                    $data[$value] = (object)$data[$value];
                }
            }
        }

        return $data;
    }
}

if (!function_exists('ip')) {
    /**
     * 获取客户端IP地址
     *
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean $adv  是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function ip($type = 0, $adv = FALSE)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if (NULL !== $ip) {
            return $ip[$type];
        }

        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (FALSE !== $pos) {
                    unset($arr[$pos]);
                }
                $ip = trim(current($arr));
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip   = $long ? [$ip, $long] : ['0.0.0.0', 0];
        return $ip[$type];
    }
}

if (!function_exists('read_dir_queue')) {
    /**
     * 队列读目录内文件
     *
     * @param string $dir  目录
     * @param int    $type 返回类型。0 返回文件名（无扩展名）；1 返回完整文件名；2 返回带路径的完整文件名
     * @return array
     */
    function read_dir_queue($dir, $type = 0)
    {
        $files = [];
        $queue = [$dir];
        while ($path = current($queue)) {
            next($queue);
            if (is_dir($path) && $handle = opendir($path)) {
                while (($file = readdir($handle)) !== FALSE) {
                    if ($file === '.' || $file === '..' || $file === '.DS_Store') {
                        continue;
                    }
                    $real_path = $path . '/' . $file;

                    if (is_dir($real_path)) {
                        $queue[] = $real_path;
                        continue;
                    }
                    switch ($type) {
                        case 1:
                            if ($path == $dir) {
                                $files[] = '/' . $file;
                            } else {
                                $files[] = substr($path, strripos($path, '/') + 1) . '/' . $file;
                            }
                            break;
                        case 2:
                            $files[] = $real_path;
                            break;
                        default:
                            $files[] = current(explode('.', $file));
                            break;
                    }
                }
                closedir($handle);
            }
        }
        return $files;
    }
}

if (!function_exists('rand_password')) {
    /**
     * 生成随机密码
     *
     * @param int $length
     * @return string
     */
    function rand_password($length = 8)
    {
        // 密码字符集
        $chars    = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
            'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y', 'z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $keys     = array_rand($chars, $length);
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[$keys[$i]];
        }
        return $password;
    }
}

if (!function_exists('array_two_dimensional')) {
    function array_two_dimensional($data)
    {
        if (is_null($data)) {
            return [];
        }

        if (is_string($data)) {
            return [[$data]];
        }

        if (is_numeric($data)) {
            return [[$data]];
        }

        if (array_key_exists('0', $data)) {
            return $data;
        }
        return [$data];
    }
}
