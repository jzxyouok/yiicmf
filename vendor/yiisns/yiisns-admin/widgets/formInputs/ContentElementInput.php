<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.03.2016
 */
namespace yiisns\admin\widgets\formInputs;

use yiisns\kernel\models\ContentElement;
use yii\base\Exception;

/**
 * @property $contentElement ContentElement
 *
 * Class ContentElementInput
 * @package yiisns\admin\widgets\formInputs
 */
class ContentElementInput extends SelectModelDialogInput
{
    /**
     * @var string
     */
    public $baseRoute = 'admin/admin-tools/select-element';

    /**
     * @var string
     */
    public $viewFile  = 'content-element-input';

    /**
     * @return ContentElement
     */
    public function getModelData()
    {
        if ($this->model && $this->model->{$this->attribute})
        {
            $id = $this->model->{$this->attribute};
            return ContentElement::findOne($id);
        }
    }
}