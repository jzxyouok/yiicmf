<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.02.2016
 */
namespace yiisns\admin\base;

use yiisns\kernel\base\ConfigFormInterface;
use yiisns\kernel\traits\HasComponentDescriptorTrait;
use yiisns\kernel\traits\WidgetTrait;

use yii\base\Model;
use yii\base\ViewContextInterface;
use yii\widgets\ActiveForm;

/**
 * Class AdminDashboardWidget
 * 
 * @package yiisns\admin\base
 */
class AdminDashboardWidget extends Model implements ViewContextInterface, ConfigFormInterface
{
    /**
     *
     * @see \yii\base\Widget
     */
    use WidgetTrait;
    
    use HasComponentDescriptorTrait;

    /**
     * @see \yiisns\kernel\base\ConfigFormInterface
     * @param ActiveForm|null $form            
     */
    public function renderConfigForm(ActiveForm $form) {}

    /**
     *
     * @var null
     */
    public $viewFile = 'default';

    public function run()
    {
        if ($this->viewFile) {
            echo $this->render($this->viewFile, [
                'widget' => $this
            ]);
        } else {
            return \Yii::t('yiisns/admin', 'Template not found');
        }
    }
}