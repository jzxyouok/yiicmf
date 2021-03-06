<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016 YiiSNS
 * @date 19.05.2016
 */
namespace yiisns\admin\helpers;

use yiisns\admin\assets\AdminAsset;

use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class AdminMenuItem
 * 
 * @package yiisns\admin\helpers
 */
class AdminMenuItem extends Component
{
    /**
     *
     * @var bool on/off
     */
    public $enabled = true;

    public $label = 'Name is not specified';

    /**
     *
     * @var array|string|null Pictures path
     */
    public $img = [
        '\yiisns\admin\assets\AdminAsset',
        'images/icons/posteditem.png'
    ];

    /**
     *
     * @var array|string|null
     */
    public $url = null;

    /**
     *
     * @var AdminMenuItem[]
     */
    public $items = [];

    /**
     *
     * @var string
     */
    public $code = '';

    /**
     *
     * @var int
     */
    public $priority = 100;

    /**
     *
     * @var null
     */
    public $activeCallback = null;

    /**
     *
     * @var AdminMenuItem|null
     */
    public $parent = null;

    /**
     *
     * @var null
     */
    public $accessCallback = null;

    public function init()
    {
        parent::init();
        $this->items = static::createItems($this->items, $this);
    }

    /**
     *
     * @return bool
     */
    public function isActive()
    {
        if ($this->items) {
            foreach ($this->items as $item) {
                if ($item->isActive()) {
                    return true;
                }
            }
        }
        
        if ($this->activeCallback && is_callable($this->activeCallback)) {
            $callback = $this->activeCallback;
            return (bool) $callback($this);
        }
        
        if (is_array($this->url)) {
            if (strpos('-' . \Yii::$app->controller->route . '/', $this->url[0] . '/')) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Show whether
     *
     * @return bool
     */
    public function isAllowShow()
    {
        if ($this->enabled === true && $this->isPermissionCan()) {
            if ($this->items) {
                foreach ($this->items as $item) {
                    if ($item->isAllowShow()) {
                        return true;
                    }
                }
                
                return false;
            } else {
                return true;
            }
        }
        
        return false;
    }

    /**
     * 
     * @return bool
     */
    public function isPermissionCan()
    {
        if (is_array($this->url)) {
            $controller = null;
            
            try {
                /**
                 *
                 * @var $controller \yii\web\Controller
                 */
                list ($controller, $route) = \Yii::$app->createController($this->url[0]);
            } catch (\Exception $e) {}
            
            if (! $controller) {
                return true;
            }
            
            if ($permission = \Yii::$app->authManager->getPermission($controller->permissionName)) {
                if (\Yii::$app->user->can($permission->name)) {
                    return $this->_accessCallback();
                } else {
                    return false;
                }
            } else {
                return $this->_accessCallback();
            }
        }
        
        return $this->_accessCallback();
    }

    /**
     *
     * @return bool
     */
    protected function _accessCallback()
    {
        if ($this->accessCallback && is_callable($this->accessCallback)) {
            $callback = $this->accessCallback;
            return (bool) $callback();
        }
        
        return true;
    }

    /**
     * 
     * @return string
     */
    public function getUrl()
    {
        if ($this->url === null) {
            return '';
        }
        if (is_array($this->url)) {
            return \Yii::$app->getModule('admin')->createUrl($this->url);
        }
        if (is_string($this->url)) {
            return (string) $this->img;
        }
        
        return '';
    }

    /**
     * 
     * @return string
     */
    public function getImgUrl()
    {
        if ($this->img === null) {
            return '';
        }
        if (is_array($this->img)) {
            list ($assetClassName, $localPath) = $this->img;
            return (string) \Yii::$app->getAssetManager()->getAssetUrl(\Yii::$app->assetManager->getBundle($assetClassName), $localPath);
        }
        if (is_string($this->img)) {
            return (string) $this->img;
        }
        
        return '';
    }

    static public function createItems($data = [], $parent = false)
    {
        $result = [];
        
        foreach ($data as $key => $value) {
            if ($value instanceof AdminMenuItem) {
                $result[] = $value;
            } else 
                if (is_callable($value)) {
                    $data = $value();
                    if (is_array($data)) {
                        $result = ArrayHelper::merge($result, $data);
                    }
                } else 
                    if (is_array($value)) {
                        $itemData = (array) $value;
                        
                        if (! $itemData) {
                            continue;
                        }
                        
                        if (is_string($key)) {
                            $itemData['code'] = $key;
                        } else {
                            if ($parent === null) {
                                $itemData['code'] = 'sx-auto-block-' . $key;
                            } else {
                                $itemData['code'] = $parent->code . '-' . $key;
                            }
                        }
                        
                        if ($parent) {
                            if ($parent instanceof AdminMenuItem) {
                                $itemData['parent'] = $parent;
                            }
                        }
                        
                        $result[] = new static($itemData);
                    }
        }
        ArrayHelper::multisort($result, 'priority'); // 根据priority对items进行排序
        return $result;
    }
}