<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.04.2016
 */
namespace yiisns\admin\widgets\filters;

use yiisns\apps\base\AssetBundle;

/**
 * Class SelectLanguage
 * @package common\widgets\selectLanguage
 */
class AdminFiltersFormAsset extends AssetBundle
{
    public $sourcePath = '@yiisns/admin/widgets/filters/assets';

    public $css = [
        'filters-form.css',
    ];

    public $js = [
        'filters-form.js',
    ];

    public $depends =
    [
        'yiisns\admin\assets\AdminAsset',
    ];
}