<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.03.2016
 *
 * @var \yiisns\kernel\models\ContentElement $model
 *
 */
?>
<li>
    <a href="<?= $model->url; ?>" title="<?= $model->name; ?>"><?= $model->name; ?></a>
    <br />
    <small><?= \Yii::$app->formatter->asDate($model->published_at, 'full'); ?></small>
</li>