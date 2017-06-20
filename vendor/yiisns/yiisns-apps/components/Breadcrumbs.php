<?php
/**
 * Breadcrumbs
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.01.2016
 * @since 1.0.0
 */
namespace yiisns\apps\components;

use yiisns\kernel\models\Site;
use yiisns\kernel\models\StorageFile;
use yiisns\kernel\models\Tree;
use yiisns\kernel\models\TreeType;
use yiisns\kernel\models\User;

use yii\base\Component;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\web\View;

/**
 * 
 * @package yiisns\apps\components
 */
class Breadcrumbs extends Component
{
    /**
     *
     * @var array
     */
    public $parts = [];

    public function init()
    {
        parent::init();
    }

    /**
     *
     * @param array $data            
     * @return $this
     */
    public function append($data)
    {
        if (is_array($data)) {
            $this->parts[] = $data;
        } else 
            if (is_string($data)) {
                $this->parts[] = [
                    'name' => $data
                ];
            }
        
        return $this;
    }

    /**
     *
     * @param Tree $tree            
     * @return $this
     */
    public function setPartsByTree(Tree $tree)
    {
        $parents = $tree->parents;
        $parents[] = $tree;
        
        foreach ($parents as $tree) {
            $this->append([
                'name' => $tree->name,
                'url' => $tree->url,
                'data' => [
                    'model' => $tree
                ]
            ]);
        }
        
        return $this;
    }

    public function createBase($baseData = [])
    {
        if (! $baseData) {
            $baseData = [
                'name' => \Yii::t('yiisns/apps', 'Home'),
                'url' => '/'
            ];
        }
        
        $this->parts = [];
        
        $this->append($baseData);
        
        return $this;
    }
}