<?php


namespace App\Support;


class WeakPwd {

    private static $forbidden_keywords = ["root", "admin", "oracle", "system", "mysql"];

    private static $allow_special_characters = '_\/-.$@!%#?&';

    private static $str_continuities = [
        "1234567890 0987654321", //数字倒序
        "qwertyuiop asdfghjkl zxcvbnm QWERTYUIOP ASDFGHJKL ZXCVBNM", //主键盘顺序
        "poiuytrewq lkjhgfdsa mnbvcxz POIUYTREWQ LKJHGFDSA MNBVCXZ", //主键盘逆序
        "qaz wsx edc rfv tgb yhn ujm QAZ WSX EDC RFV TGB YHN UJM",//主键盘正向斜
        "zaq xsw cde vfr bgt nhy mju ZAQ XSW CDE VFR BGT NHY MJU",//主键盘正向斜逆序
        "esz rdx tfc ygv uhb ijn okm OKM IJN UHB YGV TFC RDX ESZ",//主键盘反向斜
        "zse xdr cft vgy bhu nji mko MKO NJI BHU VGY CFT XDR ZSE",//主键盘反向斜逆序
        "147 369 258 852 963 741", //小键盘
        //特殊字符不计算在内 否则无休止
    ];


    public static function validation($password) {
        return self::same($password) || self::continuous($password);
    }

    /**
     * FUNCTION_NAME : same
     * author : jp
     * 是否是一样的
     *
     * @param $password
     *
     * @return bool
     */
    public static function same($password) {

        $len = strlen($password);
        for ($i = 0; $i < $len - 1; $i++) {
            $current = substr($password, $i, 1);
            $next = substr($password, $i + 1, 1);
            if ($current != $next) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * FUNCTION_NAME : continuous
     * author : jp
     * 是否是自增的
     *
     * @param     $password
     * @param int $step
     *
     * @return bool
     */
    public static function continuous($password, $step = 1) {
        $len = strlen($password);

        $res = ord(substr($password, 0, 1)) - ord(substr($password, 1, 1));

        if (abs($res) == $step) {
            for ($i = 1; $i < $len - 1; $i++) {
                $current = substr($password, $i, 1);
                $next = substr($password, $i + 1, 1);
                if (ord($current) - ord($next) != $res) {
                    return FALSE;
                }
            }
        }
        else {
            return FALSE;
        }

        return TRUE;


    }

}
