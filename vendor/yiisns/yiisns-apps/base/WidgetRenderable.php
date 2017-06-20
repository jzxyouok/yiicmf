<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.05.2016
 */

namespace yiisns\apps\base;

use yiisns\apps\helpers\UrlHelper;
use yiisns\apps\base\Widget;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
/**
 * Class WidgetRenderable
 * @package yiisns\apps\base
 */
class WidgetRenderable extends Widget
{
    /**
     * @var null
     */
    public $viewFile = 'default';

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'viewFile'  => \Yii::t('yiisns/kernel', 'File-template'),
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            [['viewFile'], 'string'],
        ]);
    }

    protected function _run()
    {
        if ($this->viewFile)
        {
            return $this->render($this->viewFile, [
                'widget' => $this
            ]);
        } else
        {
            return \Yii::t('yiisns/kernel', 'Template not found');
        }
    }
}