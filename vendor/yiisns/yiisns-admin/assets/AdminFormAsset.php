<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.06.2016
 */
namespace yiisns\admin\assets;
/**
 * Class AdminFormAsset
 * @package yiisns\admin\assets
 */
class AdminFormAsset extends AdminAsset
{
    public $css =
    [
        'css/form.css',
    ];

    public $js = [
        'js/classes/Form.js',
    ];

    public $depends =
    [
        'yiisns\admin\assets\AdminAsset',
    ];
}