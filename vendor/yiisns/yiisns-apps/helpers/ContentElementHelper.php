<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 13.08.2016
 */
namespace yiisns\apps\helpers;

use yiisns\kernel\models\ContentElement;
use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class ContentElementHelper
 * @package yiisns\apps\helpers
 */
abstract class ContentElementHelper extends Component
{
    /**
     * @var array
     */
    static public $instances = [];

    /**
     * @var ContentElement
     */
    public $model;

    /**
     * @param ContentElement $model
     * @param $data
     */
    public function __construct($model, $data = [])
    {
        $data['model'] = $model;
        static::$instances[$model->id] = $this;

        parent::__construct($data);
    }

    /**
     * @param ContentElement $model
     * @param array $data
     * @return static
     */
    static public function instance($model, $data = [])
    {
        if ($package = ArrayHelper::getValue(static::$instances, $model->id))
        {
            return $package;
        }

        return new static($model, $data);
    }
}