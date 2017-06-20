<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.03.2016
 */
namespace yiisns\kernel\query;

use yiisns\kernel\base\AppCore;

use yii\db\ActiveQuery as BaseActiveQuery;

/**
 * Class ActiveQuery
 * 
 * @package yiisns\kernel\query
 */
class ActiveQuery extends BaseActiveQuery
{
    public function active($state = true)
    {
        return $this->andWhere([
            'active' => ($state == true ? AppCore::BOOL_Y : AppCore::BOOL_N)
        ]);
    }

    public function def($state = true)
    {
        return $this->andWhere([
            'def' => ($state == true ? AppCore::BOOL_Y : AppCore::BOOL_N)
        ]);
    }
}