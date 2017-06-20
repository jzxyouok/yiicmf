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
class SeoPageName extends Filter
{
    /**
     *
     * @param string $value            
     * @return string
     */
    public function filter($value)
    {
        $value = trim($value);
        
        if (strlen($value) < 2) {
            $value = $value . "-" . md5(microtime());
        }
        
        if (strlen($value) > 64) {
            $value = substr($value, 0, 64);
        }
        
        $filter = new Translit();
        $value = $filter->filter(trim($value));
        $value = strtolower($value);
        
        $result = [];
        if ($array = explode("-", $value)) {
            foreach ($array as $node) {
                if (trim($node)) {
                    $result[] = trim($node);
                }
            }
        }
        // Remove - from the beginning of the line, and with a few - from the middle
        $value = implode('-', $result);
        
        if (strlen($value) < 2 || strlen($value) > 64) {
            $value = $this->filter($value);
        }
        
        return $value;
    }
}