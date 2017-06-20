<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.02.2016
 */
namespace yiisns\admin\base;

use yiisns\kernel\traits\HasComponentDescriptorTrait;
use yiisns\kernel\traits\WidgetTrait;

use yii\base\Model;
use yii\base\ViewContextInterface;
use yii\widgets\ActiveForm;

/**
 * Class AdminDashboardWidgetRenderable
 * @package yiisns\admin\base
 */
class AdminDashboardWidgetRenderable extends AdminDashboardWidget
{
    /**
     * @var null
     */
    public $viewFile = 'default';

    public function run()
    {
        if ($this->viewFile)
        {
            try
            {
                return $this->render($this->viewFile, [
                    'widget' => $this
                ]);
            } catch (\Exception $e)
            {
                return $e->getMessage();
            }

        } else
        {
            return \Yii::t('yiisns/admin', 'Template not found');
        }
    }
}