<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.07.2016
 */
 
namespace yiisns\apps\helpers;

/**
 * Class StringHelper
 * @package yiisns\kernel\helpers
 */
class StringHelper
{
    /**
     *
     * @param $search
     * @param $replace
     * @param $text
     * @return mixed
     */
    static public function strReplaceOnce($search, $replace, $text)
    {
       $pos = strpos($text, $search);
       return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
    }

    /**
     *
     * @static
     * @param $number
     * @param $suffix
     * @return mixed
     */
    static public function declination($number, $suffix)
    {
        $keys = array(2, 0, 1, 1, 1, 2);
        $mod = $number % 100;
        $suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
        return $suffix[$suffix_key];
    }

    /**
     * @param $string
     * @return string
     */
    static public function strtolower($string)
    {
        return mb_strtolower($string, \Yii::$app->charset);
    }


    /**
     * @param $string
     * @return string
     */
    static public function strtoupper($string)
    {
        return mb_strtoupper($string, \Yii::$app->charset);
    }

    /**
     * @param $string
     * @return string
     */
    static public function ucfirst($string)
    {
        $str = $string;
        $encoding = \Yii::$app->charset;
        return mb_substr(mb_strtoupper($str, $encoding), 0, 1, $encoding) . mb_substr($str, 1, mb_strlen($str)-1, $encoding);
    }

    /**
     * @param $string
     * @return int
     */
    static public function strlen($string)
    {
        $str = $string;
        $encoding = \Yii::$app->charset;
        return  mb_strlen($str, $encoding);
    }

    /**
     * @param $str
     * @param $start
     * @param null $length
     * @return string
     */
    static public function substr($str, $start, $length = null)
    {
        $encoding = \Yii::$app->charset;
        return mb_substr($str, $start, $length, $encoding);
    }

    /**
     * @param $str
     * @param $start
     * @param null $length
     * @return string
     */
    static public function htmlspecialchars($str, $start, $length = null)
    {
        $encoding = \Yii::$app->charset;
        return htmlspecialchars($str, $start, $length, $encoding);
    }

    /**
     * @param $data
     * @return string
     */
    static public function compressBase64EncodeUrl($data)
    {
        return rtrim(strtr(base64_encode(
            gzcompress(serialize($data),9)
        ), '+/', '-_'), '=');
    }

    /**
     * @param $string
     * @return mixed
     */
    static public function compressBase64DecodeUrl($string)
    {
        return unserialize(gzuncompress(base64_decode(str_pad(strtr($string, '-_', '+/'), strlen($string) % 4, '=', STR_PAD_RIGHT))));
    }

    /**
     * @param $data
     * @return string
     */
    static public function base64EncodeUrl($string)
    {
        return rtrim(strtr(base64_encode($string), '+/', '-_'), '=');
    }

    /**
     * @param $string
     * @return mixed
     */
    static public function base64DecodeUrl($string)
    {
        return base64_decode(str_pad(strtr($string, '-_', '+/'), strlen($string) % 4, '=', STR_PAD_RIGHT));
    }
}