<?php
/**
 * Thumbnail
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
use Imagine\Image\ManipulatorInterface;
use yii\base\Exception;

/**
 * Class Thumbnail
 * @package yiisns\apps\components\imaging\filters
 */
class Thumbnail extends \yiisns\apps\components\imaging\Filter
{
    public $w       = 50;
    public $h       = 50;
    public $m       = ManipulatorInterface::THUMBNAIL_OUTBOUND;

    public function init()
    {
        parent::init();

        if (!$this->w && !$this->h)
        {
            throw new Exception(\Yii::t('yiisns/apps', 'You must specify a width or height'));
        }

    }

    protected function _save()
    {
        if (!$this->w)
        {
            $size = Image::getImagine()->open($this->_originalRootFilePath)->getSize();
            $width = ($size->getWidth() * $this->h) / $size->getHeight();
            Image::thumbnail($this->_originalRootFilePath, (int) round($width), $this->h, $this->m)->save($this->_newRootFilePath);

        } else if (!$this->h)
        {
            $size = Image::getImagine()->open($this->_originalRootFilePath)->getSize();
            $height = ($size->getHeight() * $this->w) / $size->getWidth();
            Image::thumbnail($this->_originalRootFilePath, $this->w, (int) round($height), $this->m)->save($this->_newRootFilePath);
        } else
        {
            Image::thumbnail($this->_originalRootFilePath, $this->w, $this->h, $this->m)->save($this->_newRootFilePath);
        }
    }
}