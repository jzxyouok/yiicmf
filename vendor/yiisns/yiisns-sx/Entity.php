<?php
/**
 * Entity
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 29.10.2016
 * @since 1.0.0
 */
namespace yiisns\sx;
/**
 * Class Entity
 * @package yiisns\sx
 */
class Entity
{
    use traits\Entity;

    public function __construct($data = [])
    {
        $this->_data = $data;
        $this->_init();
    }

    protected function _init()
    {}

    /**
     *
     * @param array $array
     * @return array
     */
    static public function createEntityList(array $array = [])
    {
        $entitys = [];

        foreach($array as $row)
        {
            if (is_array($row))
            {
                $entitys[] = new static($row);
            } else if ($row instanceof static)
            {
                $entitys[] = new static($row->toArray());
            }
        }

        return $entitys;
    }
}