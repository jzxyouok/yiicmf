<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.04.2016
 */
namespace yiisns\kernel\relatedProperties\propertyTypes;

use yiisns\kernel\relatedProperties\PropertyType;

/**
 * Class PropertyTypeFile
 * 
 * @package yiisns\kernel\relatedProperties\propertyTypes
 */
class PropertyTypeFile extends PropertyType
{
    public $code = self::CODE_FILE;

    public $name = '';

    public function init()
    {
        parent::init();
        
        if (!$this->name) {
            $this->name = \Yii::t('yiisns/kernel', 'File');
        }
    }
}