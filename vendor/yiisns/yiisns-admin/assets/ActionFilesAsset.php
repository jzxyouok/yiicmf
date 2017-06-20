<?php
/**
 * ActionFilesAsset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.11.2016
 * @since 1.0.0
 */
namespace yiisns\admin\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package backend\assets
 */
class ActionFilesAsset extends AdminAsset
{
    public $css = [
    ];
    public $js =
    [
        'actions/files/files.js',
    ];
    public $depends = [
        '\yiisns\sx\assets\Core',
        '\yiisns\sx\assets\Widget',
        '\yii\widget\simpleajaxuploader\Asset',
    ];
}
