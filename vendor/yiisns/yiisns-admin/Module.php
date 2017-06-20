<?php
/**
 * Module
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */
namespace yiisns\admin;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\models\Site;
use yiisns\admin\assets\AdminAsset;
use yiisns\admin\components\UrlRule;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Object;
use yii\web\Application;

/**
 * Class Module
 */
class Module extends \yii\base\Module
{
    const SYSTEM_QUERY_NO_ACTIONS_MODEL = 'no-actions';

    const SYSTEM_QUERY_EMPTY_LAYOUT = 'sx-empty-layout';
    
    /**
     * @var array the list of IPs that are allowed to access this module.
     * Each array element represents a single IP filter which can be either an IP address
     * or an address with wildcard (e.g. 192.168.0.*) to represent a network segment.
     * The default value is `['127.0.0.1', '::1']`, which means the module can only be accessed
     * by localhost.
     */
    public $allowedIPs = ['*'];

    public $controllerNamespace = 'yiisns\admin\controllers';

    /**
     * @return boolean whether the module can be accessed by the current user
     */
    public function checkAccess()
    {
        $ip = \Yii::$app->getRequest()->getUserIP();
    
        foreach ($this->allowedIPs as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                return true;
            }
        }
    
        \Yii::warning('Access to Admin is denied due to IP address restriction. The requested IP is ' . $ip, __METHOD__);
    
        return false;
    }
    
    /**
     *
     * @param array $data            
     * @return string
     */
    public function createUrl(array $data)
    {
        $data[UrlRule::ADMIN_PARAM_NAME] = UrlRule::ADMIN_PARAM_VALUE;
        return \Yii::$app->urlManager->createUrl($data);
    }

    /**
     * TODO: is depricated
     *
     * @return string
     */
    public function getNoImage()
    {
        return \Yii::$app->admin->noImage;
    }
}