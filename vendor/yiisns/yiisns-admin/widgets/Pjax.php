<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.12.2016
 */
namespace yiisns\admin\widgets;

/**
 * Class Pjax
 *
 * @package yiisns\admin\widgets
 */
class Pjax extends \yiisns\apps\widgets\Pjax
{
    /**
     * Block container Pjax
     * 
     * @var bool
     */
    public $blockPjaxContainer = true;

    public function init()
    {
        $this->isBlock = $this->blockPjaxContainer;
        parent::init();
    }
}