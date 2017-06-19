<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 05.06.2016
 */
namespace yii\widget\codemirror;

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class CodemirrorWidget
 * 
 * @package yii\widget\codemirror
 */
class CodemirrorWidget extends \yii\widgets\InputWidget
{
    public $presetsDir;

    public $assets = [];

    public $clientOptions = [];

    /**
     * Preset name.
     * php|javascript etc.
     * 
     * @var string
     */
    public $preset;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerAssets();
        $this->_registerPlugin();
    }

    /**
     * Registers Assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $settings = $this->clientOptions;
        $assets = $this->assets;
        
        if ($this->preset) {
            $preset = $this->getPreset($this->preset);
            if (isset($preset['assets'])) {
                $assets = ArrayHelper::merge($preset['assets'], $assets);
            }
            
            if (isset($preset['settings'])) {
                $this->clientOptions = ArrayHelper::merge($preset['settings'], $settings);
            }
        }
        CodemirrorAsset::register($this->view, $assets);
    }

    /**
     * Registers CKEditor plugin
     */
    protected function _registerPlugin()
    {
        $view = $this->getView();
        $id = $this->options['id'];
        
        $settings = Json::encode($this->clientOptions);
        $js = "CodeMirror.fromTextArea(document.getElementById('$id'), $settings);";
        $view->registerJs($js);
    }

    public function getPreset($name)
    {
        if ($this->presetsDir)
            $filename = $this->presetsDir . DIRECTORY_SEPARATOR . ucfirst($name) . 'Preset.php';
        else
            $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'presets' . DIRECTORY_SEPARATOR . ucfirst($name) . 'Preset.php';
        return require $filename;
    }
}