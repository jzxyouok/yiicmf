<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.06.2016
 */
namespace yiisns\apps\widgets\formInputs\componentSettings;

use yiisns\apps\Exception;
use yiisns\apps\helpers\StringHelper;
use yiisns\apps\helpers\UrlHelper;
use yiisns\admin\Module;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\widget\codemirror\CodemirrorWidget;

/**
 * Class ComponentSettingsWidget
 * @package yiisns\kernel\widgets\formInputs\componentSettings
 */
class ComponentSettingsWidget extends InputWidget
{
    /**
     * @var array Общие js опции текущего виджета
     */
    public $clientOptions = [];

    /**
     * @var string ID селекта компонентов
     */
    public $componentSelectId   = "";
    public $buttonText          = "";
    public $buttonClasses       = "sx-btn-edit btn btn-xs btn-default";

    public function init()
    {
        parent::init();

        if(!$this->buttonText)
        {
            $this->buttonText = \Yii::t('yiisns/kernel','Setting property');
        }
    }

    /**
	 * @inheritdoc
	 */
	public function run()
	{
        if ($this->hasModel())
        {
            $name   = Html::getInputName($this->model, $this->attribute);

            $value = null;

            if (is_array($this->model->{$this->attribute}))
            {
                $value  = StringHelper::base64EncodeUrl(serialize((array) $this->model->{$this->attribute}));
            } else if(is_string($this->model->{$this->attribute}))
            {
                $value = $this->model->{$this->attribute};
            }


            $this->options['id'] = Html::getInputId($this->model, $this->attribute);

			//$element = Html::activeHiddenInput($this->model, $this->attribute, $this->options);
            $element = Html::hiddenInput($name, $value, $this->options);
		} else
        {
            $element = Html::hiddenInput($this->name, $this->value, $this->options);
		}

        $this->registerPlugin();

        $this->clientOptions['componentSelectId']       = $this->componentSelectId;
        $this->clientOptions['componentSettingsId']     = Html::getInputId($this->model, $this->attribute);
        $this->clientOptions['id']                      = $this->id;
        $this->clientOptions['backend']                 = UrlHelper::construct('/admin/admin-universal-component-settings/index')
                                                            ->setSystemParam(Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
                                                            ->enableAdmin()
                                                            ->toString();

        return $this->render('element', [
            'widget'    => $this,
            'element'   => $element
        ]);
	}



    /**
	 * Registers CKEditor plugin
	 */
	protected function registerPlugin()
	{
        ComponentSettingsWidgetAsset::register($this->view);
	}
}

