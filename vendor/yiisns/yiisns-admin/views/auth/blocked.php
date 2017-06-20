<?php
/**
 * auth
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.02.2016
 */
/* @var $this \yii\web\View */
use yii\helpers\Html;
//use \yiisns\admin\widgets\ActiveForm;
use \yiisns\apps\base\widgets\ActiveFormAjaxSubmit as ActiveForm;

$this->registerJs(<<<JS
    (function(sx, $, _)
    {

        sx.createNamespace('classes', sx);
        sx.classes.Blocked = sx.classes.Component.extend({
        
            _init: function()
            {},

            _onDomReady: function()
            {
                _.delay(function()
                {
                    $("[type=password]").val('');
                }, 200);
            },
            
            afterValidate: function(jForm, ajaxQuery)
            {
                var handler = new sx.classes.AjaxHandlerStandartRespose(ajaxQuery, {
                    'blocker'                           : sx.AppUnAuthorized.PanelBlocker,
                    'blockerSelector'                   : '',
                    'enableBlocker'                     : true,
                    'redirectDelay'                     : 500,
                    'allowResponseSuccessMessage'       : false,
                    'allowResponseErrorMessage'         : false,
                });

                handler.bind('success', function(e, data)
                {
                    _.delay(function()
                    {
                        sx.AppUnAuthorized.triggerBeforeReddirect();
                    }, 200)
                });
            }
        });

        sx.Blocked = new sx.classes.Blocked();
    })(sx, sx.$, sx._);
JS
);
$logoutUrl = \yiisns\apps\helpers\UrlHelper::construct('admin/auth/logout')->enableAdmin()->setCurrentRef();
?>
<div class="main sx-content-block sx-windowReady-fadeIn">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <div class="panel panel-primary sx-panel">
            <div class="panel-body">
                <div class="panel-content">
                        <?php $form = ActiveForm::begin([
                            'id'                            => 'blocked-form',
                            'validationUrl'                 => (string) \yiisns\apps\helpers\UrlHelper::constructCurrent()->enableAjaxValidateForm(),
                            'afterValidateCallback'         => 'sx.Blocked.afterValidate',
                        ]); ?>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <img src="<?= \yiisns\apps\helpers\Image::getSrc(\Yii::$app->user->identity->image ? \Yii::$app->user->identity->image->src : null); ?>" style="width: 100%;"/>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'password')->passwordInput([
                                            'placeholder' =>  \Yii::t('yiisns/kernel', 'Password'),
                                            'autocomplete' => 'off',
                                        ])->label(\Yii::$app->user->identity->displayName) ?>
                                        <?= Html::submitButton("<i class='glyphicon glyphicon-lock'></i> " . \Yii::t('yiisns/admin', 'Unlock'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                                    </div>
                                </div>
                        <?php ActiveForm::end(); ?>
                                <div>
                                    <hr />
                                    <div style="color:#999;margin:1em 0">
                                        <?=\Yii::t('yiisns/kernel', 'You have successfully logged in, but not for too long been active in the control panel site.')?>
                                        <?=\Yii::t('yiisns/kernel', 'Please confirm that it is you, and enter your password.')?>
                                        <p>

                                            <?= Html::a('<i class="glyphicon glyphicon-off"></i>  ' . \Yii::t('yiisns/admin', 'Exit'), $logoutUrl, [
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'class' => 'btn btn-danger btn-xs pull-right',
                                            ]); ?>
                                        </p>
                                    </div>
                                </div>
                </div>
            </div>
        </div>
    </div><!-- End .col-lg-12  -->
    <div class="col-lg-4"></div>
</div>