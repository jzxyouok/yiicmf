<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.05.2016
 */
namespace yiisns\kernel\traits;

use yiisns\apps\helpers\UrlHelper;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\widgets\Pjax;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widget\chosen\Chosen;

/**
 * Class ActiveFormAjaxSubmit
 * @package yiisns\kernel\traits
 */
trait ActiveFormAjaxSubmitTrait
{
    public function registerJs()
    {
        $afterValidateCallback = $this->afterValidateCallback;
        if ($afterValidateCallback)
        {
            $this->view->registerJs(<<<JS

                    $('#{$this->id}').on('beforeSubmit', function (event, attribute, message) {
                        return false;
                    });

                    $('#{$this->id}').on('ajaxComplete', function (event, jqXHR, textStatus) {
                        if (jqXHR.status == 403)
                        {
                            sx.notify.error(jqXHR.responseJSON.message);
                        }
                    });

                    $('#{$this->id}').on('afterValidate', function (event, messages) {

                        if (event.result === false)
                        {
                            sx.notify.error('Check the fields in the form');
                            return false;
                        }

                        var Jform = $(this);
                        var ajax = sx.ajax.preparePostQuery($(this).attr('action'), $(this).serialize());
                        var callback = $afterValidateCallback;
                        callback(Jform, ajax);
                        ajax.execute();
                        return false;
                    });

JS
);
        } else
        {
            $this->view->registerJs(<<<JS

                    $('#{$this->id}').on('beforeSubmit', function (event, attribute, message) {
                        return false;
                    });

                    $('#{$this->id}').on('afterValidate', function (event, messages) {

                        if (event.result === false)
                        {
                            sx.notify.error('Check the fields in the form');
                            return false;
                        }

                        var Jform = $(this);
                        var ajax = sx.ajax.preparePostQuery($(this).attr('action'), $(this).serialize());

                        var handler = new sx.classes.AjaxHandlerStandartRespose(ajax, {
                            'blockerSelector' : '#' + $(this).attr('id'),
                            'enableBlocker' : true,
                        });

                        ajax.execute();

                        return false;
                    });
JS
);
        }
    }
    public function run()
    {
        parent::run();
        $this->registerJs();
    }
}