<?php
/**
 * Filter
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 11.12.2016
 * @since 1.0.0
 */

namespace yiisns\apps\components\imaging\filters;

use yii\base\Component;
use yii\imagine\Image;

/**
 * Class Crop
 * @package yiisns\apps\components\imaging
 */
class Crop extends \yiisns\apps\components\imaging\Filter
{
    public $w       = 0;
    public $h       = 0;
    public $s       = [0, 0];

    protected function _save()
    {
        Image::crop($this->_originalRootFilePath, $this->w, $this->h, $this->s)->save($this->_newRootFilePath);
        Image::thumbnail($this->_originalRootFilePath, $this->w, $this->h, $this->s)->save($this->_newRootFilePath);
    }
}