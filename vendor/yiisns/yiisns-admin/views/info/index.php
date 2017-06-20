<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.01.2016
 * @since 1.0.0
 */
/* @var $this yii\web\View */
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;

$autoEnvFile = '';
if (file_exists(APP_ENV_GLOBAL_FILE))
{
    $autoEnvFile = \Yii::t('yiisns/kernel', 'Yes').' ';
    $autoEnvFile .= "<a class='btn btn-xs btn-primary' href='" . \yiisns\apps\helpers\UrlHelper::construct('admin/info/remove-env-global-file')->enableAdmin()->toString() . "'>".\Yii::t('yiisns/kernel','Delete')."</a>  ";
} else
{
    $autoEnvFile = \Yii::t('yiisns/kernel', 'No').' ';
}
$autoEnvFile .= "<a class='btn btn-xs btn-primary' href='" . \yiisns\apps\helpers\UrlHelper::construct('admin/info/write-env-global-file', ['env' => 'dev'])->enableAdmin()->toString() . "'>".\Yii::t('yiisns/kernel', 'To record')." dev</a>  ";
$autoEnvFile .= "<a class='btn btn-xs btn-primary' href='" . \yiisns\apps\helpers\UrlHelper::construct('admin/info/write-env-global-file', ['env' => 'prod'])->enableAdmin()->toString() . "'>".\Yii::t('yiisns/kernel', 'To record')." prod</a>";

?>
<? $form = ActiveForm::begin(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Project configuration')); ?>
    <?php
    echo $this->render('table', [
        'values' => [
            'YiiSNS' => \Yii::$app->appSettings->descriptor->version,
            \Yii::t('yiisns/kernel', '{yii} Version', ['yii' => 'Yii']) => $application['yii'],
            \Yii::t('yiisns/kernel', 'Project name') => $application['name'] . " (<a href='" . \yiisns\apps\helpers\UrlHelper::construct('admin/admin-settings')->enableAdmin()->toString() . "'>".\Yii::t('yiisns/kernel', 'edit')."</a>)",
            \Yii::t('yiisns/kernel', 'Application Environment ({yii_env})', ['yii_env' => 'YII_ENV']) => $application['env'],
            \Yii::t('yiisns/kernel', 'Development mode ({yii_debug})', ['yii_debug' => 'YII_DEBUG']) => $application['debug'] ? \Yii::t('yiisns/kernel', 'Yes') : \Yii::t('yiisns/kernel', 'No'),
            \Yii::t('yiisns/kernel', "Checks environment variables").' (APP_ENV_GLOBAL_FILE)' => $autoEnvFile . " <a class='btn btn-xs btn-default' title='" . APP_ENV_GLOBAL_FILE . "'>i</a>",
        ],
    ]);
    ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'All extensions and modules {yii}',['yii' => 'Yii'])); ?>
    <?if (!empty($extensions)) {
        echo $this->render('table', [
            'values' => $extensions,
        ]);
    }?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', '{php} configuration', ['php' => "PHP"])); ?>
    <?
    echo $this->render('table', [
        'values' => [
            'PHP Version' => $php['version'],
            'Xdebug' => $php['xdebug'] ? 'Enabled' : 'Disabled',
            'APC' => $php['apc'] ? 'Enabled' : 'Disabled',
            'Memcache' => $php['memcache'] ? 'Enabled' : 'Disabled',
            'Xcache' => $php['xcache'] ? 'Enabled' : 'Disabled',
            'Gd' => $php['gd'] ? 'Enabled' : 'Disabled',
            'Imagick' => $php['imagick'] ? 'Enabled' : 'Disabled',
            'Sendmail Path' => ini_get('sendmail_path'),
            'Sendmail From' => ini_get('sendmail_from'),
            'open_basedir' => ini_get('open_basedir'),
            'realpath_cache_size' => ini_get('realpath_cache_size'),
            'xcache.cacher' => ini_get('xcache.cacher'),
            'xcache.ttl' => ini_get('xcache.ttl'),
            'xcache.stat' => ini_get('xcache.stat'),
            'xcache.size' => ini_get('xcache.size'),
        ],
    ]);
    ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', '{php} info', ['php' => 'PHP'])); ?>
    <iframe id="php-info" src='<?= \yiisns\apps\helpers\UrlHelper::construct('/admin/info/php')->enableAdmin()->toString(); ?>' width='100%' height='1000'></iframe>;
<?= $form->fieldSetEnd(); ?>
<? ActiveForm::end(); ?>