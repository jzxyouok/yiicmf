<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.05.2016
 */
namespace yiisns\apps\base;

use yiisns\kernel\base\AppCore;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\base\Component;
use yiisns\kernel\traits\WidgetTrait;

use yii\base\InvalidCallException;
use yii\base\ViewContextInterface;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class Widget
 * @package yiisns\apps\base
 */
abstract class Widget extends Component implements ViewContextInterface
{
    use WidgetTrait;

    /**
     * @var string
     */
    protected $_token;

    /**
     * static self::begin()
     * @var bool
     */
    protected $_isBegin = false;

    public function init()
    {
        $this->_token = \Yii::t('yiisns/kernel', 'Widget').': ' . $this->id;

        $this->defaultAttributes = $this->attributes;

        \Yii::beginProfile("Init: " . $this->_token);
            $this->initSettings();
        \Yii::endProfile("Init: " . $this->_token);
    }


    /**
     * 
     * @return string
     */
    public function _begin()
    {
        if ($this->_isBegin === true)
        {
            return '';
        }
        $this->_isBegin = true;

        \Yii::$app->toolbar->initEnabled();
        if (\Yii::$app->toolbar->editWidgets == AppCore::BOOL_Y && \Yii::$app->toolbar->enabled)
        {
            $id = 'sx-infoblock-' . $this->id;

            return Html::beginTag('div',
            [
                'class'     => 'skeeks-cms-toolbar-edit-view-block',
                'id'        => $id,
                'title'     => \Yii::t('yiisns/kernel', "Double-click on the block will open the settings manager"),
                'data'      =>
                [
                    'id' => $this->id,
                    'config-url' => $this->getCallableEditUrl()
                ]
            ]);
        }

        return "";
    }

    /**
     * 
     * @return string
     */
    public function _end()
    {
        $result = "";

        if (\Yii::$app->toolbar->editWidgets == AppCore::BOOL_Y && \Yii::$app->toolbar->enabled)
        {
            $id = 'sx-infoblock-' . $this->id;

            $this->view->registerJs(<<<JS
new sx.classes.toolbar.EditViewBlock({'id' : '{$id}'});
JS
);
            $callableData = $this->callableData;

            $callableDataInput = Html::textarea('callableData', base64_encode(serialize($callableData)), [
                'id'    => $this->callableId,
                'style' => 'display: none;'
            ]);

            $result = $callableDataInput;
            $result .= Html::endTag('div');
        }

        return $result;
    }

    /**
     * @param string    $namespace  Unique code, which is attached to the settings in the database
     * @param array     $config     Standard widget settings
     *
     * @return static
     */
    static public function beginWidget($namespace, $config = [])
    {
        $config = ArrayHelper::merge(['namespace' => $namespace], $config);
        return static::begin($config);
    }

    /**
     * Begins a widget.
     * This method creates an instance of the calling class. It will apply the configuration
     * to the created instance. A matching [[end()]] call should be called later.
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @return static the newly created widget instance
     */
    public static function begin($config = [])
    {
        $config['class'] = get_called_class();
        /* @var $widget Widget */
        $widget = \Yii::createObject($config);
        static::$stack[] = $widget;

        echo $widget->_begin();

        return $widget;
    }

    /**
     * Ends a widget.
     * Note that the rendering result of the widget is directly echoed out.
     * @return static the widget instance that is ended.
     * @throws InvalidCallException if [[begin()]] and [[end()]] calls are not properly nested
     */
    public static function end()
    {
        if (!empty(static::$stack)) {
            $widget = array_pop(static::$stack);
            if (get_class($widget) === get_called_class()) {
                echo $widget->run();
                echo $widget->_end();
                return $widget;
            } else {
                throw new InvalidCallException(\Yii::t('yiisns/kernel','"Expecting end() of {widget}, found {class}',['widget' => get_class($widget) , 'class' => get_called_class()]));
            }
        } else {
            throw new InvalidCallException(\Yii::t('yiisns/kernel',"Unexpected {class}::end() call. A matching begin() is not found.",['class' => get_called_class()]));
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        if (YII_ENV == 'prod')
        {
            try
            {
                \Yii::beginProfile('Run: ' . $this->_token);
                    $content = $this->_run();
                \Yii::endProfile('Run: ' . $this->_token);
            }
            catch (\Exception $e)
            {
                $content = \Yii::t('yiisns/kernel', 'Error widget {class}',['class' => $this->className()]). " (" . $this->descriptor->name . "): " . $e->getMessage();
            }
        } else
        {
            \Yii::beginProfile('Run: ' . $this->_token);
                $content = $this->_run();
            \Yii::endProfile('Run: ' . $this->_token);
        }

        if ($this->_isBegin)
        {
            $result = $content;
        } else
        {
            $result = $this->_begin();
            $result .= $content;
            $result .= $this->_end();
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function _run()
    {
        return '';
    }
}