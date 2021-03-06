<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.05.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\admin\widgets\filters\AdminFiltersForm */
/* @var $filter \yiisns\kernel\models\AdminFilter */
$widget = $this->context;

$editModalId = $widget->id . '-modal-update-filter';
?>


<div class="form-group form-group-footer">
    <div class="col-sm-12">
        <hr style="margin-top: 5px; margin-bottom: 15px;"/>

        <button type="submit" class="btn btn-default pull-left">
            <i class="glyphicon glyphicon-search"></i> <?= \Yii::t('yiisns/admin', 'To find'); ?>
        </button>

        <a href="<?= $widget->getFilterUrl($widget->filter); ?>" class="btn btn-default pull-left sx-btn-filter-close" style="margin-left: 10px;">
            <i class="glyphicon glyphicon-remove"></i> <?= \Yii::t('yiisns/admin', 'Close'); ?>
        </a>

        <div class="dropdown pull-right sx-btn-trigger-fields" style="margin-left: 10px;">
            <a class="btn btn-default btn-sm dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="glyphicon glyphicon-plus"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?= \Yii::t('yiisns/admin', 'No filters'); ?>
                </li>
           </ul>
        </div>

        <div class="dropdown pull-right sx-btn-filter-actions">
            <a class="btn btn-default btn-sm dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="glyphicon glyphicon-cog"></i>
            </a>
            <ul class="dropdown-menu">
                <? if ($widget->filter->is_default) : ?>
                    <li>
                        <a href="#" class="sx-btn-filter-save-as"><i class="glyphicon glyphicon-ok-sign"></i> <?= \Yii::t('yiisns/admin', 'Save as'); ?></a>
                    </li>
                    <li>
                        <a href="#" class="sx-btn-filter-delete"><i class="glyphicon glyphicon-remove"></i> <?= \Yii::t('yiisns/admin', 'Reset'); ?></a>
                    </li>
                <? else : ?>
                    <li>
                        <a href="#<?= $widget->getEditFilterFormModalId(); ?>" data-toggle="modal" data-target="#<?= $widget->getEditFilterFormModalId(); ?>"><i class="glyphicon glyphicon-pencil"></i> <?= \Yii::t('yiisns/admin', 'Edit'); ?></a>
                    </li>
                    <li>
                        <a href="#" class="sx-btn-filter-save-values"><i class="glyphicon glyphicon-ok-circle"></i> <?= \Yii::t('yiisns/admin', 'Save'); ?></a>
                    </li>
                    <li>
                        <a href="#" class="sx-btn-filter-save-as"><i class="glyphicon glyphicon-ok-sign"></i> <?= \Yii::t('yiisns/admin', 'Save as'); ?></a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#" class="sx-btn-filter-delete"><i class="glyphicon glyphicon-remove"></i> <?= \Yii::t('yiisns/admin', 'Delete'); ?></a>
                    </li>
                <? endif; ?>
           </ul>
        </div>
    </div>
</div>