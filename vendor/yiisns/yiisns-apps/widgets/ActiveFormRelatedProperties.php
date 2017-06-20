<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.03.2016
 */
namespace yiisns\apps\widgets;

use yiisns\admin\widgets\ActiveForm;
use yiisns\admin\traits\ActiveFormTrait;
use yiisns\admin\traits\AdminActiveFormTrait;
use yiisns\kernel\traits\ActiveFormAjaxSubmitTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\widget\chosen\Chosen;

/**
 * Class ActiveFormRelatedProperties
 *
 * @package yiisns\kernel\widgets
 */
class ActiveFormRelatedProperties extends ActiveForm
{
    use AdminActiveFormTrait;
    use ActiveFormAjaxSubmitTrait;

    public $afterValidateCallback = '';

    /**
     *
     * @var Model
     */
    public $modelHasRelatedProperties;

    public function __construct($config = [])
    {
        $this->validationUrl = \yiisns\apps\helpers\UrlHelper::construct('apps/model-properties/validate')->toString();
        $this->action = \yiisns\apps\helpers\UrlHelper::construct('apps/model-properties/submit')->toString();
        
        $this->enableAjaxValidation = true;
        
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
        
        echo \yii\helpers\Html::hiddenInput("sx-model-value", $this->modelHasRelatedProperties->id);
        echo \yii\helpers\Html::hiddenInput("sx-model", $this->modelHasRelatedProperties->className());
    }
}