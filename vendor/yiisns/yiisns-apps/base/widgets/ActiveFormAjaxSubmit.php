<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2016
 */
namespace yiisns\apps\base\widgets;

use yiisns\kernel\traits\ActiveFormAjaxSubmitTrait;

/**
 *
 * 'afterValidateCallback' => new \yii\web\JsExpression(<<<JS
    function(jForm, AjaxQuery)
    {
        var Handler = new sx.classes.AjaxHandlerStandartRespose(AjaxQuery);
        var Blocker = new sx.classes.AjaxHandlerBlocker(AjaxQuery, {
            'wrapper' : jForm.closest('.modal-content')
        });

        Handler.bind('success', function()
        {
            _.delay(function()
            {
                window.location.reload();
            }, 1000);
        });
    }
JS
        )
JS
)
 *
 * Class ActiveFormAjaxSubmit
 * @package yiisns\apps\base\widgets
 */
class ActiveFormAjaxSubmit extends ActiveForm
{
    use ActiveFormAjaxSubmitTrait;
    public $afterValidateCallback = '';

    public function __construct($config = [])
    {
        $this->enableAjaxValidation = true;
        parent::__construct($config);
    }
}