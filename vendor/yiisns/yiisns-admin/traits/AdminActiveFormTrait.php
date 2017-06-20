<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.05.2016
 */
namespace yiisns\admin\traits;

use yiisns\apps\helpers\UrlHelper;

use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\widgets\Pjax;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveField;
use yii\widget\chosen\Chosen;

/**
 * Class AdminActiveFormTrait
 * 
 * @package yiisns\admin\traits
 */
trait AdminActiveFormTrait
{
    /**
     *
     * @param Model $model            
     * @return string
     */
    public function buttonsStandart(Model $model, $buttons = ['apply', 'save', 'close'])
    {
        $baseData = [];
        $baseData['indexUrl'] = UrlHelper::construct(\Yii::$app->controller->id . '/index')->toString();
        if (\Yii::$app->controller instanceof AdminModelEditorController) {
            $baseData['indexUrl'] = \Yii::$app->controller->getIndexUrl();
        }
        $baseData['isEmptyLayout'] = (int) \Yii::$app->admin->isEmptyLayout();
        $baseData['input-id'] = $this->id . '-submit-btn';
        
        $baseDataJson = Json::encode($baseData);
        
        if (\Yii::$app->admin->isEmptyLayout()) {
            $buttons = [
                'apply'
            ];
        }
        
        $submit = "";
        if (in_array("save", $buttons)) {
            $submit .= Html::submitButton("<i class=\"glyphicon glyphicon-save\"></i> " . \Yii::t('yiisns/kernel', 'Save'), [
                'class' => 'btn btn-success',
                'onclick' => "return sx.CmsActiveFormButtons.go('save');"
            ]);
        }
        
        if (in_array("apply", $buttons)) {
            $submit .= ' ' . Html::submitButton("<i class=\"glyphicon glyphicon-ok\"></i> " . \Yii::t('yiisns/kernel', 'Apply'), [
                'class' => 'btn btn-primary',
                'onclick' => "return sx.CmsActiveFormButtons.go('apply');"
            ]);
        }
        
        if (in_array("close", $buttons)) {
            $submit .= ' ' . Html::submitButton("<i class=\"glyphicon glyphicon-remove\"></i> " . \Yii::t('yiisns/kernel', 'Cancel'), [
                'class' => 'btn btn-danger pull-right',
                'onclick' => "return sx.CmsActiveFormButtons.go('close');"
            ]);
        }
        
        $submit .= Html::hiddenInput("submit-btn", 'apply', [
            'id' => $baseData['input-id']
        ]);
        
        \Yii::$app->view->registerJs(<<<JS
    (function(sx, $, _)
    {
        sx.classes.CmsActiveFormButtons = sx.classes.Component.extend({

            _init: function()
            {},

            _onDomReady: function()
            {},

            go: function(value)
            {
                if (value == "close")
                {
                    if (this.get('isEmptyLayout'))
                    {

                    } else
                    {
                        window.location = this.get('indexUrl');
                    }
                    return false;
                } else
                {
                    $("#" + this.get('input-id')).val(value);
                }

                return true;
            }
        });

        sx.CmsActiveFormButtons = new sx.classes.CmsActiveFormButtons({$baseDataJson});
    })(sx, sx.$, sx._);
JS
);
        return Html::tag('div', $submit, [
            'class' => 'form-group sx-buttons-standart'
        ]);
    }

    /**
     *
     * @param $model
     * @param $attribute
     * @param $items
     * @param array $config            
     * @param array $fieldOptions            
     * @return ActiveField
     */
    public function fieldSelect($model, $attribute, $items, $config = [], $fieldOptions = [])
    {
        $config = ArrayHelper::merge([
            'allowDeselect' => false
        ], $config, [
            'items' => $items
        ]);
        
        foreach ($config as $key => $value) {
            if (property_exists(Chosen::className(), $key) === false) {
                unset($config[$key]);
            }
        }
        
        return $this->field($model, $attribute, $fieldOptions)->widget(Chosen::className(), $config);
    }
}