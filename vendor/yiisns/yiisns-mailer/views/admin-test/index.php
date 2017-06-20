
<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.01.2016
 * @since 1.0.0
 */
/* @var $this yii\web\View */
/* @var $model \yiisns\admin\models\forms\SshConsoleForm */
use yiisns\admin\widgets\ActiveForm;
use \yii\helpers\Html;
?>

<div class="sx-widget-ssh-console">
    <? $form = ActiveForm::begin([
        'usePjax' => true
    ]) ?>

        <?= $form->field($model, 'to')->textInput([
            'placeholder'   => 'email',
            'value'         => \Yii::$app->user->identity->email,
        ]); ?>

        <?= $form->field($model, 'from')->textInput([
            'placeholder' => 'email',
            'value' => \Yii::$app->appSettings->adminEmail
        ]); ?>

        <?= $form->field($model, 'subject')->textInput([
            'placeholder' => \Yii::t('yiisns/mail', 'Subject'),
            'value' => \Yii::t('yiisns/mail', 'Letter test')
        ]); ?>

        <?= $form->field($model, 'content')->textarea([
            'placeholder' => \Yii::t('yiisns/mail', 'Body'),
            'value' => \Yii::t('yiisns/mail', 'Letter test'),
            'rows' => 8
        ]); ?>

        <?= Html::tag('div',
            Html::submitButton(\Yii::t('yiisns/mail', "Send {email}",['email' => "email"]), ['class' => 'btn btn-primary']),
            ['class' => 'form-group']
        ); ?>

        <? if ($result) : ?>
            <h2><?=\Yii::t('yiisns/mail', 'Result of sending')?>: </h2>
                    <div class="sx-result-container">
                        <pre id="sx-result">
<p><?= $result; ?></p>
                        </pre>
                    </div>
        <? endif; ?>
    <h2><?= \Yii::t('yiisns/mail', 'Configuration of component {app} sending {email}',['app' => 'app', 'email' => 'email'])?>: </h2>
    <div class="sx-result-config">
        <pre id="sx-result">
<p><?= \Yii::t('yiisns/mail', 'Mail component')?>: <?= \Yii::$app->mailer->className(); ?></p>
<p><?= \Yii::t('yiisns/mail', 'Transport')?>: <?= (new \ReflectionObject(\Yii::$app->mailer->transport))->getName(); ?></p>
<p><?= \Yii::t('yiisns/mail', 'Transport running')?>: <?= (int) \Yii::$app->mailer->transport->isStarted(); ?></p>
<p><?= \Yii::t('yiisns/mail', 'Mailer viewPath')?>: <?= \Yii::$app->mailer->viewPath; ?></p>
<p><?= \Yii::t('yiisns/mail', 'Mailer messageClass')?>: <?= \Yii::$app->mailer->messageClass; ?></p>
        </pre>
    </div>
    <h2><?=\Yii::t('yiisns/mail', 'Configuration of {app} sending {email}',['app' => 'app', 'email' => 'email'])?>: </h2>
    <div class="sx-result-config">
        <pre id="sx-result">
<p><?= \Yii::t('yiisns/mail', 'Sendmail Path')?>: <?= ini_get('sendmail_path') ?></p>
<p><?= \Yii::t('yiisns/mail', 'Sendmail From')?>: <?= ini_get('sendmail_from') ?></p>
        </pre>
    </div>
    <? ActiveForm::end() ?>
</div>