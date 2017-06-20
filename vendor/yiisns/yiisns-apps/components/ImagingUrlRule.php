<?php
/**
 * ImagingUrlRule
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 11.12.2016
 * @since 1.0.0
 */
namespace yiisns\apps\components;

use yiisns\apps\helpers\StringHelper;
use yiisns\kernel\models\Tree;
use yiisns\sx\File;

use yii\base\InvalidConfigException;
use yii\helpers\Url;

/**
 * 
 * @package yiisns\apps\components
 */
class ImagingUrlRule extends \yii\web\UrlRule
{
    /**
     *
     * @var bool
     */
    public $useLastDelimetr = true;

    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
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
        return false;
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
        
        $sourceOriginalFile = File::object($pathInfo);
        $extension = $sourceOriginalFile->getExtension();
        
        if (! $extension) {
            return false;
        }
        
        if (! in_array(StringHelper::strtolower($extension), (array) \Yii::$app->imaging->extensions)) {
            return false;
        }
        
        return [
            'apps/imaging/process',
            $params
        ];
    }
}