<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
/* @var $this   yii\web\View */
/* @var $widget \yiisns\apps\appsWidgets\treeMenu\TreeMenuWidget */
/* @var $model   \yiisns\kernel\models\Tree */
$class = '';
if (\Yii::$app->appSettings->getCurrentTree()->id == $model->id)
{
    $class = 'active';
}
?>
<li><a href="<?= $model->url; ?>" title="<?= $model->name; ?>"><?= $model->name; ?></a></li>