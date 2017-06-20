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
$freeSpace = (float) disk_free_space("/");
$totalSpace = (float) disk_total_space("/");
$usedSpace = $totalSpace - $freeSpace;

$freeSpacePercent = ($freeSpace * 100) / $totalSpace;
$usedSpacePercent = 100 - $freeSpacePercent;
$this->registerCss(<<<CSS
ul.statistics
{
    margin-bottom: 10px;
}
CSS
)?>
<div class="site-index">
	<div class="body-content">
		<ul class="statistics">
			<li><i class="icon-pie-chart"></i>
				<div class="number"><?= round($freeSpacePercent); ?>%</div>
				<div class="title"><?=\Yii::t('yiisns/kernel', 'Free place')?></div>
				<div class="progress thin">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $freeSpacePercent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $freeSpacePercent; ?>%">
						<span class="sr-only"><?= $freeSpacePercent; ?>% Complete (success)</span>
					</div>
				</div></li>
			<li><i class="icon-users"></i>
				<div class="number">
					<a
						href="<?= \yiisns\apps\helpers\UrlHelper::construct('/admin/admin-user')->enableAdmin()->toString(); ?>"><?= \yiisns\kernel\models\User::find()->count(); ?></a>
				</div>
				<div class="title"><?=\Yii::t('yiisns/kernel', 'Number of users')?></div>
			</li>
		</ul>
	</div>
</div>