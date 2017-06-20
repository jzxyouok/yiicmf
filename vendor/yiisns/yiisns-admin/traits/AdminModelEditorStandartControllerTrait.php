<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.05.2016
 */
namespace yiisns\admin\traits;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\base\AppCore;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\widgets\Pjax;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveField;
use yii\widget\chosen\Chosen;

/**
 * Class AdminActiveFormTrait
 * 
 * @package yiisns\admin\traits
 */
trait AdminModelEditorStandartControllerTrait
{
    /**
     *
     * @param $model
     * @param $action
     * @return bool
     */
    public function eachMultiActivate($model, $action)
    {
        try {
            $model->active = AppCore::BOOL_Y;
            return $model->save(false);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     *
     * @param $model
     * @param $action
     * @return bool
     */
    public function eachMultiInActivate($model, $action)
    {
        try {
            $model->active = AppCore::BOOL_N;
            return $model->save(false);
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     *
     * @param $model
     * @param $action
     * @return bool
     */
    public function eachMultiDef($model, $action)
    {
        try {
            $model->def = AppCore::BOOL_Y;
            return $model->save(false);
        } catch (\Exception $e) {
            return false;
        }
    }
}