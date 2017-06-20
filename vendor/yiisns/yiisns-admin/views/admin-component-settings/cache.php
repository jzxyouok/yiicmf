<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 *
 * @var $component \yiisns\kernel\base\Component
 */
/* @var $this yii\web\View */
?>
<?= $this->render('_header', ['component' => $component]); ?>
    <div class="sx-box sx-mb-10 sx-p-10">
        <p><?=\Yii::t('yiisns/kernel','To improve performance, configure each component of the site is cached.')?></p>
        <button type="submit" class="btn btn-danger btn-xs" onclick="sx.ComponentSettings.Cache.clearAll(); return false;">
            <i class="glyphicon glyphicon-remove"></i> <?= \Yii::t('yiisns/kernel', 'Reset all cache'); ?>
        </button>
    </div>
<?= $this->render('_footer'); ?>