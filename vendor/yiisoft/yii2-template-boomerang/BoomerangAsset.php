<?php

namespace yii\template\boomerang;

use yii\web\AssetBundle;

class BoomerangAsset extends AssetBundle
{
    public $sourcePath = '@yii/template/boomerang/src/';

    /**
     * @param string $asset
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function getAssetUrl($asset)
    {
        return \Yii::$app->assetManager->getAssetUrl(\Yii::$app->assetManager->getBundle(static::className()), $asset);
    }
}