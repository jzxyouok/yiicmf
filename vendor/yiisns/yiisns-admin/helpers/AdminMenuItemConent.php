<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.05.2016
 */

namespace yiisns\admin\helpers;

use yiisns\kernel\models\Content;
use yiisns\admin\assets\AdminAsset;

use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class AdminMenuItem
 * @package yiisns\admin\helpers
 */
class AdminMenuItemConent extends AdminMenuItem
{
    /**
     * @return bool
     */
    public function isActive()
    {
        /*if (!parent::isActive())
        {
            return false;
        }*/

        if (is_array($this->url))
        {
            if ($content_id = ArrayHelper::getValue($this->url, 'content_id'))
            {
                if ($content_id == \Yii::$app->request->get("content_id") && \Yii::$app->controller->uniqueId == $this->url[0])
                {
                    return true;
                }
            }
        } else
        {
            return parent::isActive();
        }

        return false;
    }


    /**
     * privileges allowed
     * @return bool
     */
    public function isPermissionCan()
    {
        if (is_array($this->url))
        {
            $controller = null;

            try
            {
                /**
                 * @var $controller \yii\web\Controller
                 */
                list($controller, $route) = \Yii::$app->createController($this->url[0]);
            } catch (\Exception $e)
            {}


            if (!$controller)
            {
                return true;
            }


            if ($content_id = ArrayHelper::getValue($this->url, 'content_id'))
            {
                $controller->content = Content::findOne($content_id);
            }

            if ($permission = \Yii::$app->authManager->getPermission($controller->permissionName))
            {
                if (\Yii::$app->user->can($permission->name))
                {
                    return $this->_accessCallback();
                } else
                {
                    return false;
                }
            } else
            {
                return $this->_accessCallback();
            }
        }

        return $this->_accessCallback();
    }
}