<?php
/**
 * AdminSiteController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 16.11.2016
 * @since 1.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\models\SiteDomain;
use yiisns\admin\controllers\AdminModelEditorController;

/**
 * Class AdminSiteController
 * @package yiisns\admin\controllers
 */
class AdminSiteDomainController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                   = 'Managing Domains';
        $this->modelShowAttribute      = 'domain';
        $this->modelClassName          = SiteDomain::className();

        parent::init();
    }
}