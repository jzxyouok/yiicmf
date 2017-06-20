<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.03.2016
 */
namespace yiisns\form2\widgets;

use yiisns\admin\widgets\ActiveForm;
use yiisns\admin\traits\ActiveFormTrait;
use yiisns\admin\traits\AdminActiveFormTrait;
use yiisns\kernel\traits\ActiveFormAjaxSubmitTrait;
use yiisns\form\models\Form;
use yiisns\form2\models\Form2Form;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\widget\chosen\Chosen;

/**
 * Class ActiveFormRelatedProperties
 * @package yiisns\kernel\widgets
 */
class ActiveFormConstructForm extends \yiisns\apps\base\widgets\ActiveForm
{
    use AdminActiveFormTrait;
    use ActiveFormAjaxSubmitTrait;
    
    public $afterValidateCallback = '';

    /**
     * @var Form2Form
     */
    public $modelForm;

    public function __construct($config = [])
    {
        $this->validationUrl = \yiisns\apps\helpers\UrlHelper::construct('form2/backend/validate')->toString();
        $this->action = \yiisns\apps\helpers\UrlHelper::construct('form2/backend/submit')->toString();

        $this->enableAjaxValidation = true;

        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        echo \yii\helpers\Html::hiddenInput('sx-model-value',   $this->modelForm->id);
        echo \yii\helpers\Html::hiddenInput('sx-model',         $this->modelForm->className());
    }
}