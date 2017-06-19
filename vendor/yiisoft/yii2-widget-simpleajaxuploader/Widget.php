<?php
/**
 * Widget
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.10.2016
 * @since 1.0.0
 */
namespace yii\widget\simpleajaxuploader;

use yii\widget\simpleajaxuploader\Asset;

use yii\helpers\Json;
use yii\base\Widget as BaseWidget;

/**
 * For example:
 *
 * <?php
 * namespace bla\bla;
 * 
 * use yii\widget\simpleajaxuploader\Widget;

 * echo Widget::widget({
 *      "clientOptions" =>
 *      [
 *          "name" => ""
 *      ]
 * });
 * ```
 *
 * @author HimikLab
 * @see http://www.jacklmoore.com/colorbox/
 * @package himiklab\colorbox
 */
class Widget extends BaseWidget
{
    /** @var array $targets */
    public $clientOptions = [];

    public function init()
    {
        parent::init();
        $view = $this->getView();

        $options = Json::encode($this->clientOptions);
        $script = "new ss.SimpleUpload($options);" . PHP_EOL;

        $view->registerJs($script);
        Asset::register($view);
    }
}