<?php
/**
 * can get attached to the sections through the intermediate table
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.05.2016
 */

namespace yiisns\kernel\models\behaviors;

use yii\base\Behavior;
use yii\db\ActiveQuery;
use yii\db\AfterSaveEvent;
use yii\db\BaseActiveRecord;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\ErrorHandler;

/**
 * @property ActiveRecord $owner
 *
 * Class HasTreesBehavior
 * @package yiisns\kernel\models\behaviors
 */
class HasTreesBehavior extends Behavior
{
    public $_tree_ids = null;

    /**
     * @var string
     */
    public $elementTreesClassName = '\yiisns\kernel\models\ContentElementTree';

    /**
     * @var string
     */
    public $treesClassName = '\yiisns\kernel\models\Tree';

    /**
     * @var string
     */
    public $attributeElementName = 'element_id';

    /**
     * @var string
     */
    public $attributeTreeName = 'tree_id';

    /**
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_UPDATE    => 'afterSaveTree',
            BaseActiveRecord::EVENT_AFTER_INSERT    => 'afterSaveTree',
        ];
    }

    /**
     * @param AfterSaveEvent $event
     */
    public function afterSaveTree($event)
    {
        if ($this->owner->_tree_ids === null)
        {
            return $this;
        }

        $oldIds = (array) ArrayHelper::map($this->owner->elementTrees, $this->attributeTreeName, $this->attributeTreeName);
        $newIds = (array) $this->owner->treeIds;

        $writeIds = [];
        $deleteIds = [];

        if (!$oldIds)
        {
            $writeIds = $newIds;
        } else
        {
            foreach ($oldIds as $oldId)
            {
                if (in_array($oldId, $newIds))
                {

                } else
                {
                    $deleteIds[] = $oldId;
                }
            }

            foreach ($newIds as $newId)
            {
                if (in_array($newId, $oldIds))
                {

                } else
                {
                    $writeIds[] = $newId;
                }
            }
        }

        if ($deleteIds)
        {
            $elementTrees  = $this->owner->getElementTrees()->andWhere([
                $this->attributeTreeName => $deleteIds
            ])->limit(count($deleteIds))->all();

            foreach ($elementTrees as $elementTree)
            {
                $elementTree->delete();
            }
        }

        if ($writeIds)
        {
            $className = $this->elementTreesClassName;

            foreach ($writeIds as $treeId)
            {
                if ($treeId)
                {
                    $elementTree = new $className([
                        $this->attributeElementName    => $this->owner->id,
                        $this->attributeTreeName       => $treeId,
                    ]);

                    $elementTree->save(false);
                }
            }
        }
        $this->owner->_tree_ids = null;
    }


    /**
     * @return int[]
     */
    public function getTreeIds()
    {
        if ($this->owner->_tree_ids === null)
        {
            $this->owner->_tree_ids = [];

            if ($this->owner->elementTrees)
            {
                $this->_tree_ids = (array) ArrayHelper::map($this->owner->elementTrees, $this->attributeTreeName, $this->attributeTreeName);
            }

            return $this->_tree_ids;
        }

        return (array) $this->_tree_ids;
    }

    /**
     * @param $ids
     * @return $this
     */
    public function setTreeIds($ids)
    {
        $this->owner->_tree_ids = $ids;
        return $this;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementTrees()
    {
        $className = $this->elementTreesClassName;
        return $this->owner->hasMany($className::className(), [$this->attributeElementName => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrees()
    {
        $className      = $this->elementTreesClassName;
        $treesClassName = $this->treesClassName;

        return $this->owner->hasMany($treesClassName::className(), ['id' => 'tree_id'])
                ->via('elementTrees');
    }
}