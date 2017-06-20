<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.06.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\widgets\SshConsoleWidget */
?>
<div class="sx-cms-cmds">
    <pre>
        <?= \Yii::$app->console->execute("cd " . ROOT_DIR . " && php yii help;"); ?>
    </pre>
</div>