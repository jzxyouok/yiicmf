<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 01.03.2016
 */
/* @var $this yii\web\View */

echo $this->render('@yiisns/admin/views/admin-user/_form', [
    'model'           => $model,
    'relatedModel'    => $relatedModel,
    'passwordChange'  => $passwordChange,
]);
