<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.05.2016
 */
namespace yiisns\apps\components\urlRules;

use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\Tree;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class UrlRuleContentElement
 * 
 * @package yiisns\kernel\components\urlRules
 */
class UrlRuleContentElement extends \yii\web\UrlRule
{

    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public static $models = [];

    /**
     *
     * @param \yii\web\UrlManager $manager            
     * @param string $route            
     * @param array $params            
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        if ($route == 'apps/content-element/view') {
            $contentElement = $this->_getElement($params);
            
            if (! $contentElement) {
                return false;
            }
            
            $url = '';
            
            $tree = ArrayHelper::getValue($params, 'tree');
            ArrayHelper::remove($params, 'tree');
            // We need to build on what that particular section of the settings
            if (! $tree) {
                $tree = $contentElement->tree;
            }
            
            if ($tree) {
                $url = $tree->dir . '/';
            }
            
            $url .= $contentElement->id . '-' . $contentElement->code;
            
            if (strpos($url, '//') !== false) {
                
                $url = preg_replace('#/+#', '/', $url);
            }
            
            /**
             *
             * @see parent::createUrl()
             */
            if ($url !== '') {
                $url .= ($this->suffix === null ? $manager->suffix : $this->suffix);
            }
            
            /**
             *
             * @see parent::createUrl()
             */
            if (! empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '?' . $query;
            }
            
            if ($tree && $tree->site) {
                if ($tree->site->server_name) {
                    return $tree->site->url . '/' . $url;
                }
            }
            
            return $url;
        }
        
        return false;
    }

    /**
     *
     * @param $params
     * @return bool|ContentElement
     */
    protected function _getElement(&$params)
    {
        $id = (int) ArrayHelper::getValue($params, 'id');
        $contentElement = ArrayHelper::getValue($params, 'model');
        
        if (! $id && ! $contentElement) {
            return false;
        }
        
        if ($contentElement && $contentElement instanceof ContentElement) {
            self::$models[$contentElement->id] = $contentElement;
        } else {
            /**
             *
             * @var $contentElement ContentElement
             */
            if (! $contentElement = ArrayHelper::getValue(self::$models, $id)) {
                $contentElement = ContentElement::findOne([
                    'id' => $id
                ]);
                self::$models[$id] = $contentElement;
            }
        }
        
        ArrayHelper::remove($params, 'id');
        ArrayHelper::remove($params, 'code');
        ArrayHelper::remove($params, 'model');
        
        return $contentElement;
    }

    /**
     *
     * @param \yii\web\UrlManager $manager            
     * @param \yii\web\Request $request            
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        if ($this->mode === self::CREATION_ONLY) {
            return false;
        }
        
        if (! empty($this->verb) && ! in_array($request->getMethod(), $this->verb, true)) {
            return false;
        }
        
        $pathInfo = $request->getPathInfo();
        if ($this->host !== null) {
            $pathInfo = strtolower($request->getHostInfo()) . ($pathInfo === '' ? '' : '/' . $pathInfo);
        }
        
        $params = $request->getQueryParams();
        $suffix = (string) ($this->suffix === null ? $manager->suffix : $this->suffix);
        $treeNode = null;
        
        if (! $pathInfo) {
            return false;
        }
        
        if (! preg_match('/\/(?<id>\d+)\-(?<code>\S+)$/i', "/" . $pathInfo, $matches)) {
            return false;
        }
        
        return [
            'apps/content-element/view',
            [
                'id' => $matches['id'],
                'code' => $matches['code']
            ]
        ];
    }
}