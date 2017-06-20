<?php
/**
 * AdminAsset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */

namespace yiisns\admin\assets;
/**
 * Class AdminGridAsset
 * @package yiisns\admin\assets
 */
class AdminGridAsset extends AdminAsset
{
    public $css =
    [
        'css/grid.css',
        'css/table.css',
    ];

    public $js = [];

    public $depends =
    [
        'yiisns\admin\assets\AdminAsset',
    ];
}