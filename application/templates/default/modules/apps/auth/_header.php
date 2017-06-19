<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2016
 */
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\forms\LoginFormUsernameOrEmail */

use yii\helpers\Html;
use yiisns\apps\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use \yiisns\apps\helpers\UrlHelper;

$this->title = $title;
\Yii::$app->breadcrumbs->createBase()->append($this->title);

\yii\authclient\widgets\AuthChoiceAsset::register($this);

$this->registerCss(<<<CSS
    div.auth-clients
    {
          border-top: solid 1px #eee;
          margin: 0;
          padding: 0;
          text-align: center;
          padding-top: 10px;
    }

    ul.auth-clients
    {
          margin-bottom: 0;
          padding-bottom: 0;
    }

CSS
);

?>

<?= $this->render('@template/include/breadcrumbs', [
    'title' => $this->title
])?>

<? \yiisns\admin\widgets\Pjax::begin(); ?>

<!-- -->
<section>
    <div class="container">
        <div class="row">