<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\models\ContentType;
use yiisns\admin\controllers\AdminModelEditorController;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class AdminContentTypeController
 * @package yiisns\admin\controllers
 */
class AdminContentTypeController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                   = \Yii::t('yiisns/kernel', 'Content management');
        $this->modelShowAttribute      = 'name';
        $this->modelClassName          = ContentType::className();

        parent::init();
    }
}