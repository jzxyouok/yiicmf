<?php
/**
 * Translit
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.10.2016
 * @since 1.0.0
 */

namespace yiisns\sx\filters\string;
use yiisns\sx\Filter;
/**
 * Class Cx_Filter_String_Strtoupper
 */
class Translit
    extends Filter
{
    /**
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        if (preg_match('/[^A-Za-z0-9_\-]/', $value)) {
            $tr = array(
                "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
                "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
                "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
                "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
                "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
                "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
                "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
                "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
                "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
                "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
                "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
                "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
                "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
                //" "=> "_", "."=> "", "/"=> "_"
                " "=> "-", "."=> "", "/"=> "_"
            );
            $value = strtr($value, $tr);
            $value = preg_replace('/[^A-Za-z0-9_\-]/', '', $value);
        }

        return $value;
    }
}