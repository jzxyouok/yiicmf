<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.06.2016
 */
namespace yiisns\marketplace\models;

use yiisns\marketplace\helpers\ComposerHelper;
use yiisns\marketplace\models\PackageModel;
use yiisns\apps\helpers\FileHelper;
use yiisns\apps\helpers\UrlHelper;
use yii\base\Component;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 *
 * @property string $packagistUrl
 * @property ComposerHelper $composer
 * @property string $controllUrl
 * @property UrlHelper $adminUrl
 * @property string $changeLog
 * @property string $readme Class Extension
 * @package yiisns\kernel\models
 */
class Extension extends Model
{
    public static $extensions = [];

    public static $coreExtensions = [];

    public $name = '';

    public $version = '';

    /**
     *
     * @var array
     */
    public $alias = [];

    /**
     *
     * @var PackageModel
     */
    public $marketplacePackage = null;

    /**
     *
     * @param $name
     * @return static
     */
    static public function getInstance($name)
    {
        $extension = ArrayHelper::getValue(self::$extensions, $name);
        
        if (! $extension || (! $extension instanceof static)) {
            $data = ArrayHelper::getValue(\Yii::$app->extensions, $name);
            if (! $data) {
                return null;
            }
            
            $extension = new static($data);
            self::$extensions[$name] = $extension;
        }
        
        return $extension;
    }

    /**
     *
     * @return static[];
     */
    static public function fetchAll()
    {
        $result = [];
        
        if (\Yii::$app->extensions) {
            foreach (\Yii::$app->extensions as $name => $extensionData) {
                $result[$name] = static::getInstance($name);
            }
        }
        
        return $result;
    }

    /**
     * Get all installed extensions with data from marketplace
     * 
     * @return static[];
     */
    static public function fetchAllWhithMarketplace()
    {
        $result = self::fetchAll();
        
        $packages = PackageModel::fetchInstalls();
        
        foreach ($result as $name => $extension) {
            if ($model = ArrayHelper::getValue($packages, $name)) {
                $extension->marketplacePackage = $model;
            }
        }
        
        return $result;
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => \Yii::t('app', 'Name'),
            'version' => \Yii::t('app', 'Installed version'),
            'alias' => \Yii::t('app', 'Aliases')
        ]);
    }

    /**
     * Path of the file in this extension
     *
     * @param
     *            $filePath
     * @return null|string
     */
    public function getFilePath($filePath)
    {
        $composerFiles = [];
        foreach ($this->alias as $name => $path) {
            $composerFiles[] = $path . '/' . $filePath;
        }
        
        return FileHelper::getFirstExistingFileArray($composerFiles);
    }

    /**
     *
     * @return string
     */
    public function getControllUrl()
    {
        return UrlHelper::construct('/admin/admin-marketplace/install', [
            'packagistCode' => $this->name
        ])->enableAdmin()->toString();
    }

    /**
     *
     * @return UrlHelper
     */
    public function getAdminUrl()
    {
        return UrlHelper::construct('/admin/admin-marketplace/catalog', [
            'code' => $this->name
        ])->enableAdmin();
    }

    /**
     *
     * @return string
     */
    public function getPackagistUrl()
    {
        return 'https://packagist.org/packages/' . $this->name;
    }
}