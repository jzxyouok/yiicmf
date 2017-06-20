<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.05.2016
 */
/* @var $this yii\web\View */
/* @var $controller \yiisns\apps\controllers\AdminSiteController */
$controller = \Yii::$app->controller;
?>

    <? $columns         = \yii\helpers\ArrayHelper::getValue($controller->callableData, 'columns'); ?>
    <? $selectedColumns = \yii\helpers\ArrayHelper::getValue($controller->callableData, 'selectedColumns'); ?>

    <? if ($columns) : ?>
        <?= $form->fieldSet(\Yii::t('yiisns/admin', 'Table fields')); ?>

            <div class="row">
                <div class="col-lg-6">

                    <label><?=\Yii::t('yiisns/admin', 'Available fields')?></label>
                    <p><?=\Yii::t('yiisns/admin', 'Double-click for item, turn it on')?></p>
                    <hr />
                    <?= \yii\helpers\Html::listBox('possibleColumns', [], $columns, [
                        'size'      => '20',
                        'class'     => 'form-control',
                        'id'     => "sx-possibleColumns",
                    ]); ?>

                </div>
                <div class="col-lg-6">
                    <label><?=\Yii::t('yiisns/admin', 'Included fields')?></label>
                    <p><?=\Yii::t('yiisns/admin', 'Double-click for item, turn it off. You can also change the order of items by dragging them.')?></p>
                    <hr />
                    <ul id="sx-visible-selected">

                    </ul>
                    <div style="display: none;">
                        <?= $form->field($model, 'visibleColumns')->listBox($columns, [
                            'size' => '20',
                            'multiple' => 'multiple'
                        ]); ?>
                    </div>
                </div>
            </div>

        <?= $form->fieldSetEnd(); ?>
    <? endif; ?>

    <?= $form->fieldSet(\Yii::t('yiisns/kernel','Pagination')); ?>
        <?= $form->fieldRadioListBoolean($model, 'enabledPjaxPagination', \Yii::$app->appCore->booleanFormat()); ?>
        <?= $form->fieldInputInt($model, 'pageSize'); ?>
        <?= $form->fieldInputInt($model, 'pageSizeLimitMin'); ?>
        <?= $form->fieldInputInt($model, 'pageSizeLimitMax'); ?>
        <?= $form->field($model, 'pageParamName')->textInput(); ?>
    <?= $form->fieldSetEnd(); ?>

    <?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Priority')); ?>
        <?= $form->fieldSelect($model, 'orderBy', (new \yiisns\kernel\models\ContentElement())->attributeLabels()); ?>
        <?= $form->fieldSelect($model, 'order', [
            SORT_ASC    => "ASC (".\Yii::t('yiisns/kernel', 'from smaller to larger').")",
            SORT_DESC   => "DESC (".\Yii::t('yiisns/kernel', 'from highest to lowest').")",
        ]); ?>
    <?= $form->fieldSetEnd(); ?>



<?

$this->registerCss(<<<CSS
#sx-visible-selected li
{
    list-style: none;
    margin: 3px;
    padding: 5px;
    border: 1px solid silver;
    cursor: move;
}
CSS
);


$options = [
    'id'                => \yii\helpers\Html::getInputId($model, 'visibleColumns'),
    'selectedColumns'   => $model->visibleColumns ? $model->visibleColumns : $selectedColumns,
    'hasColumns'        => $model->visibleColumns
];
$optionsString = \yii\helpers\Json::encode($options);

\yii\jui\Sortable::widget();

$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.Columns = sx.classes.Component.extend({

        _init: function()
        {},

        _onDomReady: function()
        {
            var self = this;

            this.JQueryVisibleSelected      = $('#sx-visible-selected');
            this.JQuerySelect               = $('#' + this.get('id'));
            this.JQueryPossibleColumns      = $('#sx-possibleColumns');

            this.JQueryVisibleSelected.sortable({
                out: function( event, ui )
                {
                    self.updateHiddenSelect();
                }
            });

            $("option", this.JQueryPossibleColumns).on('dblclick', function()
            {
                self.appendToVisible($(this));
            });

            /*if (_.size(this.get('hasColumns')))
            {
                this.updateVisible();
            } else
            {
                this.initVisible();
            }*/

            this.initVisible();

        },


        appendToVisible: function(JQuerySelect)
        {
            var self = this;
            this.JQueryVisibleSelected.append(
                $("<li>", {
                    'data-value': JQuerySelect.attr("value")
                }).text(JQuerySelect.text())
                .on('dblclick', function()
                {
                    $(this).remove();
                    self.updateHiddenSelect();
                })
            );

            this.updateHiddenSelect();
        },

        /**
        * Обновление скрытого элемента
        */
        updateHiddenSelect: function()
        {
            var self = this;

            this.JQuerySelect.empty();

            $('li', this.JQueryVisibleSelected).each(function()
            {
                $("<option>", {
                    'value': $(this).data("value"),
                    'selected': 'selected'
                }).text($(this).text())
                .appendTo(self.JQuerySelect);
            });
        },

        updateVisible: function()
        {
            var self = this;

            this.JQueryVisibleSelected.empty();

            console.log(this.JQueryVisibleSelected);

            $('option', this.JQuerySelect).each(function()
            {
                if ($(this).is(":selected"))
                {
                    $("<li>", {'data-value': $(this).attr("value") }).text($(this).text())
                    .on('dblclick', function()
                    {
                        $(this).remove();
                        self.updateHiddenSelect();
                    })
                    .appendTo(self.JQueryVisibleSelected);
                }
            });
        },

        initVisible: function()
        {
            var self = this;

            this.JQueryVisibleSelected.empty();

            _.each(this.get('selectedColumns'), function(value, key)
            {
                if (value)
                {
                    $("<li>", {
                        'data-value': value
                    }).text( $('option[value=' + value + ']', self.JQuerySelect).text() )
                    .on('dblclick', function()
                    {
                        $(this).remove();
                        self.updateHiddenSelect();
                    })
                    .appendTo(self.JQueryVisibleSelected);
                }
            });
        },

        _onWindowReady: function()
        {}
    });

    new sx.classes.Columns($optionsString);
})(sx, sx.$, sx._);
JS
);
?>