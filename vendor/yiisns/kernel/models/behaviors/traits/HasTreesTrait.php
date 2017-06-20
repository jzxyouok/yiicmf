<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.05.2016
 */
namespace yiisns\kernel\models\behaviors\traits;

use yiisns\kernel\models\ContentElementTree;
use yiisns\kernel\models\Tree;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *
 * @method ActiveQuery getElementTrees()
 * @method ActiveQuery getTrees()
 * @method int[] getTreeIds()
 *        
 * @property ContentElementTree[] $elementTrees
 * @property int[] $treeIds
 * @property Tree[] $trees
 */
trait HasTreesTrait
{
}