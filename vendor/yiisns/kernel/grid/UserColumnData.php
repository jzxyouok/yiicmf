<?php
/**
 * UserColumnData
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\grid;

use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\User;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;
use yii\widget\chosen\Chosen;

/**
 * Class UserColumnData
 * @package yiisns\kernel\grid
 */
class UserColumnData extends DataColumn
{
    public function init()
    {
        parent::init();

        /*$this->filter = ArrayHelper::map(
            \Yii::$app->appSettings->findUser()->all(),
            'id',
            'displayName'
        );*/

        if ($this->grid->filterModel && $this->attribute)
        {
            $this->filter = \yiisns\admin\widgets\formInputs\SelectModelDialogUserInput::widget([
                'model'             => $this->grid->filterModel,
                'attribute'         => $this->attribute,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $userId = (int) $model->{$this->attribute};
        $user = User::findOne($userId);

        if ($user)
        {
            if (!$srcImage = $user->getAvatarSrc())
            {
                $srcImage = \Yii::$app->appSettings->noImageUrl;
            }

            $this->grid->view->registerCss(<<<CSS
.sx-user-preview
{

}
.sx-user-preview .sx-user-preview-controll
{
    display: none;
}

.sx-user-preview:hover .sx-user-preview-controll
{
    display: inline;
}
CSS
);
            return "<div class='sx-user-preview'>" . Html::img($srcImage, [
                'width' => 25,
                'style' => 'margin-right: 5px;'
            ]) . $user->getDisplayName() . "
                <div class='sx-user-preview-controll'>" . Html::a("<i class='glyphicon glyphicon-pencil' title='Update'></i>", UrlHelper::construct(['/admin/admin-user/update', 'pk' => $user->id])->enableAdmin()->toString(),
                [
                    'class' => 'btn btn-xs btn-default',
                    'data-pjax' => 0
                ]) . '</div></div>';
        } else
        {
            return null;
        }
    }
}