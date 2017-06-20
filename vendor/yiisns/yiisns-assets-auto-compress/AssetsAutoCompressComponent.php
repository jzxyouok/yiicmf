<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.08.2016
 */
namespace yiisns\assetsAuto;

use yii\helpers\FileHelper;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\Response;
use yii\web\View;

/**
 * @property SettingsAssetsAutoCompress $settings Class AssetsAutoCompressComponent
 * @package yiisns\assetsAuto
 */
class AssetsAutoCompressComponent extends \yii\assetsAuto\AssetsAutoCompressComponent
{
    /**
     * @return SettingsAssetsAutoCompress
     */
    public function getSettings()
    {
        return \Yii::$app->assetsAutoCompressSettings;
    }

    /**
     * @param Application $app            
     */
    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            $this->enabled = $this->settings->enabled;
            
            foreach ($this->settings->attributeLabels() as $attribute => $label) {
                if ($this->canSetProperty($attribute)) {
                    $this->{$attribute} = $this->settings->{$attribute};
                }
            }
            
            $this->htmlCompressOptions = $this->settings->htmlCompressOptions;
            
            if (! \Yii::$app->admin->requestIsAdmin) {
                parent::bootstrap($app);
            }
        }
    }
}