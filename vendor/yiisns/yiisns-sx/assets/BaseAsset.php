<?php
/**
 * BaseAsset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.01.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;

use yiisns\apps\base\AssetBundle;
use yiisns\sx\File;

/**
 * Class BaseAsset
 * 
 * @package yiisns\sx\assets
 */
abstract class BaseAsset extends AssetBundle
{
    public $sourcePath = '@vendor/yiisns/yiisns-sx/assets';

    public $css = [];

    public $js = [];

    public $depends = [];

    public function init()
    {
        parent::init();
        
        $this->js = (array) $this->js;
        if (count($this->js) <= 1) {
            return;
        }
        
        $fileName = 'yiisns-sx-' . md5($this->className()) . ".js";
        $fileMinJs = \Yii::getAlias('@app/runtime/assets/js/' . $fileName);
        
        if (file_exists($fileMinJs)) {
            $this->js = [
                $fileName
            ];
            
            $this->sourcePath = '@app/runtime/assets/js';
            
            return;
        }
        
        $fileContent = '';
        foreach ($this->js as $js) {
            $fileContent .= file_get_contents($this->sourcePath . '/' . $js);
        }
        
        if ($fileContent) {
            $file = new File($fileMinJs);
            $file->make($fileContent);
        }
    }
}