<?php
use yii\helpers\Html;

use yii\widgets\ActiveForm;
/**
 * index
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 14.10.2014
 * @since 1.0.0
 */

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $personal bool */

$this->title = $model->getDisplayName();
\Yii::$app->breadcrumbs->createBase()->append($this->title);

/*\Yii::$app->response->redirect($model->getPageUrl('conference'));*/
?>

<?= $this->render('_header', [
    'model'     => $model,
    //'personal'  => $personal,
    'title'     => '',
]); ?>



    <div class="profile-bio">
        <div class="row">
            <div class="col-md-5">
                <? if ($model->image) : ?>
                    <img class="img-responsive md-margin-bottom-10" src="<?= \yiisns\apps\helpers\Image::getSrc($model->image->src); ?>" alt="">
                <? else : ?>
                    <img class="img-responsive md-margin-bottom-10" src="<?= \yiisns\apps\helpers\Image::getSrc(); ?>" alt="">
                <? endif; ?>

                <a class="btn-u btn-u-sm" href="#">Edit</a>
            </div>
            <div class="col-md-7">
                <h2><?= $model->getDisplayName(); ?></h2>
                <!--<span><strong>Position:</strong> Web Designer</span>-->
                <hr>
                <p>Registered: <?=\Yii::$app->formatter->asDate($model->created_at, 'full'); ?> (<?=\Yii::$app->formatter->asRelativeTime($model->created_at); ?>)</p>
                <p>Personal Information.</p>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <!--Social Icons v3-->
        <div class="col-sm-6 sm-margin-bottom-30">
            <div class="panel panel-profile">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-pencil"></i> Social Contacts <small>(option 1)</small></h2>
                    <a href="#"><i class="fa fa-cog pull-right"></i></a>
                </div>
                <div class="panel-body">
                     <ul class="list-unstyled social-contacts-v2">
                        <li><i class="rounded-x tw fa fa-twitter"></i> <a href="#">edward.rooster</a></li>
                        <li><i class="rounded-x fb fa fa-facebook"></i> <a href="#">Edward Rooster</a></li>
                        <li><i class="rounded-x sk fa fa-skype"></i> <a href="#">edwardRooster77</a></li>
                        <li><i class="rounded-x gp fa fa-google-plus"></i> <a href="#">rooster77edward</a></li>
                        <li><i class="rounded-x gm fa fa-envelope"></i> <a href="#">edward77@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--End Social Icons v3-->

        <!--Skills-->
        <div class="col-sm-6 sm-margin-bottom-30">
            <div class="panel panel-profile">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-lightbulb-o"></i> Skills</h2>
                    <a href="#"><i class="fa fa-cog pull-right"></i></a>
                </div>
                <div class="panel-body">
                    <small>HTML/CSS</small>
                    <small>92%</small>
                    <div class="progress progress-u progress-xxs">
                        <div style="width: 92%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="92" role="progressbar" class="progress-bar progress-bar-u">
                        </div>
                    </div>

                    <small>Photoshop</small>
                    <small>77%</small>
                    <div class="progress progress-u progress-xxs">
                        <div style="width: 77%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="77" role="progressbar" class="progress-bar progress-bar-u">
                        </div>
                    </div>

                    <small>PHP</small>
                    <small>85%</small>
                    <div class="progress progress-u progress-xxs">
                        <div style="width: 85%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="85" role="progressbar" class="progress-bar progress-bar-u">
                        </div>
                    </div>

                    <small>Javascript</small>
                    <small>81%</small>
                    <div class="progress progress-u progress-xxs">
                        <div style="width: 81%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="81" role="progressbar" class="progress-bar progress-bar-u">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Skills-->
    </div>
<?= $this->render('_footer'); ?>