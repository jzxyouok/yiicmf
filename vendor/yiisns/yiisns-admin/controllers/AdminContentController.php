<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Content;
use yiisns\admin\controllers\AdminModelEditorController;

/**
 * Class AdminContentTypeController
 * @package yiisns\admin\controllers
 */
class AdminContentController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                    = \Yii::t('yiisns/kernel', 'Content Management');
        $this->modelShowAttribute      = 'name';
        $this->modelClassName          = Content::className();

        parent::init();
    }

    /**
     * @return string
     */
    public function getIndexUrl()
    {
        $contentTypePk = null;

        if ($this->model)
        {
            if ($contentType = $this->model->contentType)
            {
                $contentTypePk = $contentType->id;
            }
        }

        return UrlHelper::construct(['admin/admin-content-type/update', 'pk' => $contentTypePk])->enableAdmin()->toString();
    }
}