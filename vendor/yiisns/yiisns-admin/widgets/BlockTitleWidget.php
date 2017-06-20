<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.10.2016
 */
namespace yiisns\admin\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class BlockTitleWidget extends Widget
{
    /**
     * @var array HTML属性的小部件容器标签
     * 
     * @see \yii\helpers\Html::renderTagAttributes() 有关如何呈现属性的详细信息
     */
    public $options = [];
    public $content = '';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->view->registerCss(<<<CSS
.sx-admin-block-title
{
    background: #e0e8ea;
    padding: 8px 70px 10px!important;
    font-weight: bold;
    text-align: center!important;
    color: #4b6267;
    text-shadow: 0 1px #fff;
    font-size: 14px;
    margin-bottom: 5px;
}
CSS
);
        Html::addCssClass($this->options, 'sx-admin-block-title');
        echo Html::tag('div', $this->content, $this->options);
    }
}