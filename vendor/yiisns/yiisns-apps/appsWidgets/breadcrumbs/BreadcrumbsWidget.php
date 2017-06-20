<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */

namespace yiisns\apps\appsWidgets\breadcrumbs;

use yiisns\apps\base\WidgetRenderable;
/**
 * Class breadcrumbs
 * @package yiisns\apps\appsWidgets\Breadcrumbs
 */
class BreadcrumbsWidget extends WidgetRenderable
{
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/kernel', 'Breadcrumbs')
        ]);
    }
}