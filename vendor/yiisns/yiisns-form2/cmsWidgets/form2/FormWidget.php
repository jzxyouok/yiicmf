<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 16.06.2016
 */

namespace yiisns\form2\cmsWidgets\form2;

use yiisns\apps\base\Widget;
use yiisns\apps\base\WidgetRenderable;
use yiisns\apps\helpers\UrlHelper;
use yiisns\form2\models\Form2Form;

use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Class FormWidget
 * @package yiisns\form2\cmsWidgets\text
 */
class FormWidget extends WidgetRenderable
{
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/form2', 'Form designer')
        ]);
    }

    public $form_id;
    public $form_code;

    public $btn_tag = 'button';
    public $btn_options = [];

    public $btnSubmit = null;
    public $btnSubmitClass = 'btn btn-primary';

    public $afterValidateJs = '';
    public $successJs = '';
    public $errorJs = '';

    public function init()
    {
        if (!$this->btnSubmit)
        {
            $this->btnSubmit = \Yii::t('yiisns/form2', 'Submit');
        }

        $this->btn_options = ArrayHelper::merge([
            'type'  => 'submit',
            'class' => $this->btnSubmitClass,
        ], $this->btn_options);

        parent::init();
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'form_id'        => \Yii::t('yiisns/form2', 'Form'),
            'form_code'      => \Yii::t('yiisns/form2', 'Form code'),
            'btnSubmit'      => \Yii::t('yiisns/form2', 'The inscription on the button send'),
            'btnSubmitClass' => \Yii::t('yiisns/form2', 'CSS Class send button')
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            ['form_id', 'integer'],
            ['form_code', 'string'],
            ['btnSubmit', 'string'],
            ['btnSubmitClass', 'string'],
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/_form.php', [
            'form'  => $form,
            'model' => $this
        ], $this);
    }

    /**
     * @var Form2Form
     */
    public $modelForm;

    protected function _run()
    {
        try
        {
            $form = null;

            if ($this->form_id)
            {
                $this->modelForm = Form2Form::find()->where(['id' => $this->form_id])->one();

                if (!$this->modelForm)
                {
                    throw new ErrorException('The shape is not found: id=' . $this->form_id);
                }

            } else
            {
                if ($this->form_code)
                {
                    $this->modelForm = Form2Form::find()->where(['code' => $this->form_code])->one();
                    if ($form)
                    {
                        $this->form_id = $form->id;
                    }
                }

                if (!$this->modelForm)
                {
                    throw new ErrorException('The shape is not found: code=' . $this->form_code) ;
                }
            }
        } catch (\Exception $e)
        {
            \Yii::warning($e->getMessage(), static::className());
        }

        if (!$this->modelForm)
        {
            return '';
        }

        return parent::_run();
    }
}