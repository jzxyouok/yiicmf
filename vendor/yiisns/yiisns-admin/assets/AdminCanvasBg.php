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
 * Class AdminCanvasBg
 * @package yiisns\admin\assets
 */
class AdminCanvasBg extends AdminAsset
{
    public $css =
    [];

    public $js = [
        'plugins/canvas-bg/canvasbg.js',
    ];

    public $depends =
    [
        'yiisns\admin\assets\AdminAsset',
    ];
}