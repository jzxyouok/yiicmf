<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.03.2016
 */
namespace yiisns\admin\widgets\formInputs;

use yiisns\apps\Exception;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\User;
use yiisns\kernel\models\Publication;
use yiisns\admin\Module;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Application;
use yii\widgets\InputWidget;

/**
 * @property $modelData
 *
 * Class SelectModelDialogInput
 * @package yiisns\admin\widgets\formInputs
 */
class SelectModelDialogUserInput extends SelectModelDialogInput
{
    /**
     * @var string
     */
    public $baseRoute = 'admin/admin-tools/select-user';

    /**
     * @var string
     */
    public $viewFile  = 'select-model-dialog-user-input';

    /**
     * @return User
     */
    public function getModelData()
    {
        if ($this->model && $id = $this->model->{$this->attribute})
        {
            $userClass = \Yii::$app->user->identityClass;
            return $userClass::findOne($id);
        }
    }
}