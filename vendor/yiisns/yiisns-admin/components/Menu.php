<?php
/**
 * Create Menu
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 10.11.2016
 * @since 1.0.0
 */
namespace yiisns\admin\components;

use yiisns\admin\helpers\AdminMenuItem;
use yiisns\admin\helpers\MenuItem;

use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class Menu
 * 
 * @package yiisns\admin\components
 */
class Menu extends Component
{
    public $groups = [
        /*
         * Example
        'admin' =>
        [
            'label'     => '',
            'priority'  => 0,

            'items' =>
            [
                [
                    'label'     => '',
                    'url'       => ['admin/gii'],
                ],

                [
                    'label'     => '',
                    'url'       => ['admin/clear'],
                ],
                [
                    'label'     => '',
                    'url'       => ['admin/db'],
                ],
            ]
        ]*/
    ];

    public $isLoaded = false;

    public function getData()
    {
        \Yii::beginProfile('admin-menu');
        
        if ($this->isLoaded) {
            return (array) $this->groups;
        }

        $paths[] = \Yii::getAlias('@common/config/admin/menu.php');
        $paths[] = \Yii::getAlias('@application/config/admin/menu.php');
        
        foreach (\Yii::$app->extensions as $code => $data) {
            if ($data['alias']) {
                foreach ($data['alias'] as $code => $path) {
                    $adminMenuFile = $path . '/config/admin/menu.php';
                    if (file_exists($adminMenuFile)) {
                        $menuGroups = (array) include_once $adminMenuFile;
                        $this->groups = ArrayHelper::merge($this->groups, $menuGroups);
                    }
                }
            }
        }
        
        foreach ($paths as $path) {
            if (file_exists($path)) {
                $menuGroups = (array) include_once $path;
                $this->groups = ArrayHelper::merge($this->groups, $menuGroups);
            }
        }
        
        ArrayHelper::multisort($this->groups, 'priority');
        
        $this->isLoaded = true;
        
        \Yii::endProfile('admin-menu');
        
        return (array) $this->groups;
    }

    /**
     *
     * @return AdminMenuItem[]
     */
    public function getItems()
    {
        $result = [];
        
        if ($data = $this->getData()) {
            $result = AdminMenuItem::createItems($data);
            ArrayHelper::multisort($result, 'priority');
        }
        
        return $result;
    }
}