<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.04.2016
 */
namespace yiisns\sshConsole\assets;

use yii\web\AssetBundle;

/**
 * Class AdminSshConsoleAsset
 * @package yiisns\kernel\sshConsole\assets
 */
class AdminSshConsoleAsset extends SshConsoleAsset
{
    public $css = [
        'ssh-console/ssh-console.css',
        'ssh-console/themes/ubuntu.css',
    ];
    public $js =
    [
        'ssh-console/ssh-console.js',
    ];
    public $depends = [
        '\yiisns\admin\assets\AdminAsset',
        '\yii\widget\simpleajaxuploader\Asset',
    ];
}
