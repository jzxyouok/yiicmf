<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.02.2016
 */
/* @var $this yii\web\View */

?>

<?
$freeSpace  = (float) disk_free_space("/");
$totalSpace = (float) disk_total_space("/");
$usedSpace = $totalSpace - $freeSpace;

$freeSpacePercent = ($freeSpace * 100) / $totalSpace;
$usedSpacePercent = 100 - $freeSpacePercent;
?>

<div class="col-md-12">

    <?
        $baseOptions =
        [
          'title' => ['text' => \Yii::t('yiisns/kernel','At percent ratio')],
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
                            [\Yii::t('yiisns/kernel', 'Free'), round($freeSpacePercent, 2)],
                            [\Yii::t('yiisns/kernel', 'Used'), round($usedSpacePercent, 2)],
                      ]

              ],
          ]
       ];
        echo \yii\widget\highcharts\Highcharts::widget(['options' => $baseOptions]);
    ?>
    <hr />
    <p><b><?= \Yii::t('yiisns/kernel','Total at server')?>:</b> <?= Yii::$app->formatter->asShortSize($totalSpace); ?></p>
    <p><b><?= \Yii::t('yiisns/kernel','Used')?>:</b> <?= Yii::$app->formatter->asShortSize($usedSpace); ?></p>
    <p><b><?= \Yii::t('yiisns/kernel','Free')?>:</b> <?= Yii::$app->formatter->asShortSize($freeSpace); ?></p>
</div>