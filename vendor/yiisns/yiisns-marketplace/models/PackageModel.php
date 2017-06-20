<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.06.2016
 */
namespace yiisns\marketplace\models;

use yiisns\apps\helpers\UrlHelper;
use yii\base\Component;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $created_at
 * @property string $name
 * @property string $packagistCode
 * @property string $imageSrc
 * @property string $imagesSrc
 * @property string $url
 * @property string $authorName
 * @property string $authorImage
 * @property UrlHelper $adminUrl Class PackageModel
 * @package yiisns\kernel\marketplace\models
 */
class PackageModel extends Model
{
    public $apiData = [];

    /**
     *
     * @param $packagistCode
     * @return null|static
     */
    static public function fetchByCode($packagistCode)
    {
        $result = \Yii::$app->marketplace->fetch([
            'packages/view-by-code',
            [
                'packagistCode' => (string) $packagistCode
            ]
        ]);
        
        if (! $result) {
            return null;
        }
        
        return new static([
            'apiData' => $result
        ]);
    }

    /**
     * Installed packages
     *
     * @return static[]
     */
    static public function fetchInstalls()
    {
        // Installed package Codes
        $extensionCodes = ArrayHelper::map(\Yii::$app->extensions, 'name', 'name');
        
        $result = \Yii::$app->marketplace->fetch([
            'packages',
            [
                // 'codes' => $extensionCodes,
                'per-page' => 200
            ]
        ]);
        
        $items = ArrayHelper::getValue($result, 'items');
        
        $resultModels = [];
        
        if ($items) {
            foreach ($items as $data) {
                $model = new static([
                    'apiData' => $data
                ]);
                
                $resultModels[$model->getPackagistCode()] = $model;
            }
        }
        
        return $resultModels;
    }

    /**
     *
     * @param string $name            
     * @return mixed
     * @throws \yii\base\UnknownPropertyException
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->apiData)) {
            return ArrayHelper::getValue($this->apiData, $name);
        }
        
        return parent::__get($name);
    }

    /**
     *
     * @return string
     */
    public function getPackagistCode()
    {
        return (string) ArrayHelper::getValue($this->apiData, 'related.packagist_code');
    }

    /**
     *
     * @return string
     */
    public function getPackagistUrl()
    {
        return (string) 'https://packagist.org/packages/' . $this->packagistCode;
    }

    /**
     *
     * @return string
     */
    public function getSupport()
    {
        return (string) ArrayHelper::getValue($this->apiData, 'related.support');
    }

    /**
     *
     * @return string
     */
    public function getInstallHelp()
    {
        return (string) ArrayHelper::getValue($this->apiData, 'related.install');
    }

    /**
     *
     * @return string
     */
    public function getDemoUrl()
    {
        return (string) ArrayHelper::getValue($this->apiData, 'related.demo_url');
    }

    /**
     *
     * @return string
     */
    public function getVideoUrl()
    {
        return (string) ArrayHelper::getValue($this->apiData, 'related.video_url');
    }

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->absoluteUrl;
    }

    /**
     *
     * @return UrlHelper
     */
    public function getAdminUrl()
    {
        return UrlHelper::construct('/admin/admin-marketplace/catalog', [
            'code' => $this->packagistCode
        ])->enableAdmin();
    }

    /**
     *
     * @return bool
     */
    public function isInstalled()
    {
        $extensions = ArrayHelper::map(\Yii::$app->extensions, 'name', 'name');
        
        return (bool) ArrayHelper::getValue($extensions, $this->packagistCode);
    }

    /**
     *
     * @return null|Extension
     */
    public function createExtension()
    {
        if (! $this->isInstalled()) {
            return null;
        }
        
        $extensionData = ArrayHelper::getValue(\Yii::$app->extensions, $this->packagistCode);
        $extension = new Extension($extensionData);
        
        $extension->marketplacePackage = $this;
        return $extension;
    }
}