<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.02.2016
 * @since 1.0.0
 */
namespace yiisns\marketplace\controllers;

use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Comment;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\AdminController;
use yiisns\kernel\models\User;
use yiisns\marketplace\models\PackageModel;

use Yii;

/**
 * Class AdminMarketplaceController
 * 
 * @package yiisns\kernel\marketplace\controllers
 */
class AdminMarketplaceController extends AdminController
{
    public function init()
    {
        $this->name = 'Marketplace';
        parent::init();
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => AdminAction::className(),
                'name' => 'Established'
            ],
            
            'catalog' => [
                'class' => AdminAction::className(),
                'name' => 'Directory'
            ],
            
            'install' => [
                'class' => AdminAction::className(),
                'name' => 'Install/UnInstall',
                'callback' => [
                    $this,
                    'actionInstall'
                ]
            ],
            
            'update' => [
                'class' => AdminAction::className(),
                'name' => 'Platform Update'
            ]
        ];
    }

    public function actionInstall()
    {
        $packageModel = null;
        
        if ($packagistCode = \Yii::$app->request->get('packagistCode')) {
            $packageModel = PackageModel::fetchByCode($packagistCode);
        }
        
        return $this->render($this->action->id, [
            'packagistCode' => $packagistCode,
            'packageModel' => $packageModel
        ]);
    }
}
