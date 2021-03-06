<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.10.2016
 * @since 1.0.0
 */
namespace yiisns\admin\components;

use \yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Class Storage
 *
 * @package yiisns\kernel\components
 */
class UrlRule extends \yii\web\UrlRule
{
    const ADMIN_PARAM_NAME = 'namespace';

    const ADMIN_PARAM_VALUE = 'admin';

    /**
     *
     * @var string
     */
    public $adminPrefix = '~sx';

    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
        
        if (! $this->adminPrefix) {
            throw new InvalidConfigException(\Yii::t('yiisns/admin', "Incorrectly configured module {admin} to {yiisns}", [
                'admin' => 'admin',
                "yiisns" => "yiisns"
            ]));
        }
    }

    /**
     *
     * @param \yii\web\UrlManager $manager            
     * @param string $route            
     * @param array $params            
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        $routeData = explode('/', $route);
        $isAdminRoute = false;
        if (isset($routeData[1])) {
            if (strpos($routeData[1], 'admin-') !== false) {
                $isAdminRoute = true;
            }
        }
        
        if (ArrayHelper::getValue($params, self::ADMIN_PARAM_NAME) == self::ADMIN_PARAM_VALUE) {
            $isAdminRoute = true;
        }
        
        if ($isAdminRoute === false) {
            return false;
        }
        
        ArrayHelper::remove($params, self::ADMIN_PARAM_NAME);
        
        $url = $this->adminPrefix . '/' . $route;
        if (! empty($params) && ($query = http_build_query($params)) !== '') {
            $url .= '?' . $query;
        }
        
        return $url;
    }

    /**
     *
     * @param \yii\web\UrlManager $manager            
     * @param \yii\web\Request $request            
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $params = $request->getQueryParams();
        $firstPrefix = substr($pathInfo, 0, strlen($this->adminPrefix));
        
        if ($firstPrefix == $this->adminPrefix) {
            if (! \Yii::$app->getModule('admin')->checkAccess()) {
                return false;
            }
            
            $route = str_replace($this->adminPrefix, '', $pathInfo);
            if (! $route || $route == '/') {
                $route = 'admin/index';
            }
            
            $params[self::ADMIN_PARAM_NAME] = self::ADMIN_PARAM_VALUE;
            return [
                $route,
                $params
            ];
            // return ['admin/admin-user', $params];
        }
        
        return false; // this rule does not apply
    }
}