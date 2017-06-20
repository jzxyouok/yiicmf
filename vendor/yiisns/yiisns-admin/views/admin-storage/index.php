<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 29.04.2016
 */
?>
<h2><?=\Yii::t('yiisns/kernel','Servers to store the files.')?></h2>
<? foreach(\Yii::$app->storage->getClusters() as $count => $cluster) : ?>
<div class="sx-box sx-p-10 sx-bg-primary">
    <div class="row">
        <div class="col-md-12">
            <h3><b><?= $count+1; ?>. <?= $cluster->name; ?></b></h3>
            <hr />
        </div>
        <div class="col-md-4">
            <p><b><?=\Yii::t('yiisns/kernel', 'Public file path')?>: </b> <?= $cluster->publicBaseUrl; ?></p>
            <p><b><?=\Yii::t('yiisns/kernel', 'The folder on the server')?>: </b> <?= $cluster->rootBasePath; ?></p>

            <p><b><?=\Yii::t('yiisns/kernel', 'Total available space')?></b>: <?= Yii::$app->formatter->asShortSize($cluster->getTotalSpace()); ?></p>
            <p><b><?=\Yii::t('yiisns/kernel', 'Used')?></b>: <?= Yii::$app->formatter->asShortSize($cluster->getUsedSpace()); ?></p>
            <p><b><?=\Yii::t('yiisns/kernel', 'Free')?></b>: <?= Yii::$app->formatter->asShortSize($cluster->getFreeSpace()); ?></p>

            <? if ($cluster instanceof \yiisns\apps\components\storage\ClusterLocal) : ?>
                <? if ($cluster->publicBaseUrlIsAbsolute) : ?>
                    <p><b><?=\Yii::t('yiisns/kernel', 'Files download from domain')?>: </b> <?= $cluster->publicBaseUrlIsAbsolute; ?></p>
                <? endif; ?>
            <? endif; ?>
        </div>
        <div class="col-md-5">
            <ul class="statistics">
                <li>
                    <i class="icon-pie-chart"></i>
                    <div class="number"><?= round($cluster->getFreeSpacePct()); ?>%</div>
                    <div class="title"><?=\Yii::t('yiisns/kernel','Free place')?></div>
                    <div class="progress thin">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $cluster->getFreeSpacePct(); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $cluster->getFreeSpacePct(); ?>%">
                            <span class="sr-only"><?= round($cluster->getFreeSpacePct()); ?>% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-md-3">
            <?
                $baseOptions =
                [
                  'title' => ['text' => \Yii::t('yiisns/kernel', 'At percent ratio')],
                  'chart' => [
                      'type' => 'pie',

                  ],
                   'plotOptions' =>
                   [
                       'pie' =>
                       [
                            'allowPointSelect' => 'true',
                            'cursor' => "pointer",
                            'depth' => 35,
                           'dataLabels' =>
                           [
                               'enabled' => 'true',
                               'format' => '{point.name}',
                           ]
                       ]
                   ],
                  'series' => [
                      [
                          'type'=> 'pie',
                          'name'=> '%',
                          'data'=>
                              [
                                    [\Yii::t('yiisns/kernel', 'Free'), round($cluster->getFreeSpacePct())],
                                    [\Yii::t('yiisns/kernel', 'Used'), round($cluster->getUsedSpacePct())],
                              ]

                      ],
                  ]
               ];
                echo \yii\widget\highcharts\Highcharts::widget(['options' => $baseOptions]);
                ?>
        </div>
    </div>
</div>
<? endforeach; ?>