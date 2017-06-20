<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 12.04.2016
 */
?>
<div class="col-md-12 sx-empty-hide">

    <div class="row sx-main-head sx-bg-glass sx-bg-glass-hover">
        <div class="col-md-11 pull-left">
            <?= \yii\widgets\Breadcrumbs::widget([
                'homeLink' => ['label' => \Yii::t("yii", "Home"), 'url' =>
                    \yiisns\apps\helpers\UrlHelper::construct('admin/index')->enableAdmin()->toString()
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <div class="col-md-1">
            <div class="pull-right">

                <? if (\Yii::$app->user->can('admin/admin-role') && \Yii::$app->controller instanceof \yiisns\admin\controllers\AdminController) : ?>

                    <a href="#sx-permissions-for-controller" class="btn btn-default btn-primary sx-fancybox">
                        <i class="glyphicon glyphicon-exclamation-sign" data-sx-widget="tooltip-b" data-original-title="<?=\Yii::t('yiisns/kernel','Setting up access to this section')?>" style="color: white;"></i>

                    </a>

                    <div style="display: none;">
                        <div id="sx-permissions-for-controller" style="min-height: 300px;">

                            <?
                            $adminPermission = \Yii::$app->authManager->getPermission(\yiisns\rbac\SnsManager::PERMISSION_ADMIN_ACCESS);
                            $items = [];
                            foreach (\Yii::$app->authManager->getRoles() as $role)
                            {
                                if (\Yii::$app->authManager->hasChild($role, $adminPermission))
                                {
                                    $items[] = $role;
                                }
                            }
                            ?>
                            <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
                                'permissionName'        => \Yii::$app->controller->permissionName,
                                'permissionDescription' => \Yii::t('yiisns/kernel','Administration')." | " . \Yii::$app->controller->name,
                                'label'                 => \Yii::t('yiisns/kernel','Setting up access to the section').": " . \Yii::$app->controller->name,
                                'items'                 => \yii\helpers\ArrayHelper::map($items, 'name', 'description'),
                            ]); ?>
                            <?=\Yii::t('yiisns/kernel','Specify which groups of users will have access.')?>
                            <hr />
                            <? \yii\bootstrap\Alert::begin([
                                'options' => [
                                  'class' => 'alert-info',
                                ],
                            ])?>
                                <p><?=\Yii::t('yiisns/kernel','Code privileges')?>: <b><?= \Yii::$app->controller->permissionName; ?></b></p>
                                <p><?=\Yii::t('yiisns/kernel','The list displays only those groups that have access to the system administration.')?></p>
                            <? \yii\bootstrap\Alert::end()?>
                        </div>
                    </div>

                <? endif; ?>

            </div>
        </div>
    </div>
</div>