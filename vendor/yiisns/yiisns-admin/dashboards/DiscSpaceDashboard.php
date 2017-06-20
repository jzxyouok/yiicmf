<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
namespace yiisns\admin\dashboards;

use yiisns\apps\base\Widget;
use yiisns\apps\base\WidgetRenderable;
use yiisns\apps\helpers\UrlHelper;
use yiisns\admin\base\AdminDashboardWidget;
use yiisns\admin\base\AdminDashboardWidgetRenderable;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Class DiscSpaceDashboard
 * 
 * @package yiisns\admin\dashboards
 */
class DiscSpaceDashboard extends AdminDashboardWidgetRenderable
{
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/kernel', 'Disk space')
        ]);
    }

    public $viewFile = 'disc-space';

    public $name;

    public function init()
    {
        parent::init();
        
        if (! $this->name) {
            $this->name = \Yii::t('yiisns/kernel', 'Disk space');
        }
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name'], 'string']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name' => \Yii::t('yiisns/kernel', 'Name')
        ]);
    }

    /**
     *
     * @param ActiveForm $form            
     */
    public function renderConfigForm(ActiveForm $form = null)
    {
        echo $form->field($this, 'name');
    }
}