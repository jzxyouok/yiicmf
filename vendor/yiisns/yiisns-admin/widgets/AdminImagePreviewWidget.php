<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 08.10.2016
 */

namespace yiisns\admin\widgets;

use yiisns\mail\helpers\Html;

use yiisns\kernel\models\StorageFile;
use yii\base\Widget;

class AdminImagePreviewWidget extends Widget
{
    /**
     * @var StorageFile
     */
    public $image = null;

    /**
     * @var string
     */
    public $maxWidth        = '50px';

    public function run()
    {
        if ($this->image)
        {
            $originalSrc    = $this->image->src;
            $src            = \Yii::$app->imaging->getImagingUrl($this->image->src, new \yiisns\apps\components\imaging\filters\Thumbnail());
        } else
        {
            $src            = \Yii::$app->getModule('admin')->noImage;
            $originalSrc    = $src;
        }


        return "<a href='" . $originalSrc . "' class='sx-fancybox sx-img-link-hover' title='".\Yii::t('yiisns/kernel','Increase')."' data-pjax='0'>
                    <img src='" . $src . "' style='width: " . $this->maxWidth . ";' />
                </a>";
    }
}