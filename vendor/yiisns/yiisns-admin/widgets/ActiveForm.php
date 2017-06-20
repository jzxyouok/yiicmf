<?php
/**
 * ActiveForm
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 11.11.2016
 * @since 1.0.0
 */
namespace yiisns\admin\widgets;

use yiisns\apps\helpers\UrlHelper;

use yiisns\admin\assets\AdminFormAsset;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\traits\ActiveFormTrait;
use yiisns\admin\traits\AdminActiveFormTrait;
use yiisns\admin\widgets\Pjax;
use yiisns\kernel\traits\ActiveFormAjaxSubmitTrait;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widget\chosen\Chosen;

/**
 * Class ActiveForm
 * @package yiisns\admin\widgets
 */
class ActiveForm extends \yiisns\apps\base\widgets\ActiveForm
{
    use AdminActiveFormTrait;
    use ActiveFormAjaxSubmitTrait;

    /**
     * @var bool
     */
    public $usePjax = true;

    /**
     * @var bool
     */
    public $useAjaxSubmit = false;
    public $afterValidateCallback = '';

    /**
     * @var bool
     */
    public $enableAjaxValidation = true;

    /**
     * @var array
     */
    public $pjaxOptions = [];

    /**
     * Initializes the widget.
     * This renders the form open tag.
     */
    public function init()
    {
        if ($classes = ArrayHelper::getValue($this->options, 'class'))
        {
            $this->options = ArrayHelper::merge($this->options, [
                'class' => $classes . ' sx-form-admin'
            ]);
        } else
        {
            $this->options = ArrayHelper::merge($this->options, [
                'class' => 'sx-form-admin'
            ]);
        }

        if ($this->usePjax)
        {
            Pjax::begin(ArrayHelper::merge([
                'id' => 'sx-pjax-form-' . $this->id,
            ], $this->pjaxOptions));

            $this->options = ArrayHelper::merge($this->options, [
                'data-pjax' => true
            ]);

            echo \yiisns\admin\widgets\Alert::widget();
        }

        parent::init();
    }

    public function run()
    {
        parent::run();

        $clientOptions = Json::encode([
            'id' => $this->id,
            'msg_title' => \Yii::t('yiisns/admin', 'This field is required'),
        ]);


        AdminFormAsset::register($this->view);

        $this->view->registerJs(<<<JS
(function(sx, $, _)
{
    new sx.classes.forms.AdminForm({$clientOptions});
})(sx, sx.$, sx._);
JS
);


        if ($this->useAjaxSubmit)
        {
            $this->registerJs();
        }

        if ($this->usePjax)
        {
            Pjax::end();
        }
    }


    /**
     * TODO: is depricated (1.2) use buttonsStandart
     * @param Model $model
     * @return string
     */
    public function buttonsCreateOrUpdate(Model $model)
    {
        /*if (Validate::validate(new IsNewRecord(), $model)->isValid())
        {
            $submit = Html::submitButton("<i class=\"glyphicon glyphicon-saved\"></i> " . \Yii::t('yiisns/kernel', 'Create'), ['class' => 'btn btn-success']);
        } else
        {
            $submit = Html::submitButton("<i class=\"glyphicon glyphicon-saved\"></i> " .  \Yii::t('yiisns/kernel', 'Update'), ['class' => 'btn btn-primary']);
        }*/
        return $this->buttonsStandart($model);
    }

    public function fieldSet($name, $options = [])
    {
        return <<<HTML
        <div class="sx-form-fieldset">
            <h3 class="sx-form-fieldset-title">{$name}</h3>
            <div class="sx-form-fieldset-content">
HTML;

    }

    public function fieldSetEnd()
    {
        return <<<HTML
            </div>
        </div>
HTML;

    }
}