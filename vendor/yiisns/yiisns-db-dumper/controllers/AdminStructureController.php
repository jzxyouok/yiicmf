<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.04.2016
 */
namespace yiisns\dbDumper\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\AdminController;

use yii\data\ArrayDataProvider;

/**
 * Class AdminStructureController
 * 
 * @package yiisns\kernel\dbDumper\controllers
 */
class AdminStructureController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/dbDumper', 'The structure of the database');
        
        parent::init();
    }

    public function actionIndex()
    {
        // print_r(\Yii::$app->db->getSchema()->getTableSchemas());die;
        $dataProvider = new ArrayDataProvider([
            'allModels' => \Yii::$app->db->getSchema()->getTableSchemas(),
            'sort' => [
                'attributes' => [
                    'name',
                    'fullName'
                ]
            ],
            'pagination' => [
                'defaultPageSize' => 20
            ]
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}