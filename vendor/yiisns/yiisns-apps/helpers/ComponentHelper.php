<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.03.2016
 */
namespace yiisns\apps\helpers;

use yii\base\Behavior;
use yii\base\Component;

/**
 * Class ComponentHelper
 * @package yiisns\apps\helpers
 */
class ComponentHelper extends Component
{
    /**
     *
     * @param Component $component
     * @param $behavior
     * @return bool
     */
    static public function hasBehavior($component, $behavior)
    {
        if ($behavior instanceof Behavior)
        {
            $behavior = (string) $behavior->className();
        } else if (is_string($behavior))
        {
            $behavior = (string) $behavior;
        }

        if (!method_exists($component, 'getBehaviors'))
        {
            return false;
        }

        $hasBehaviors = $component->getBehaviors();

        foreach ($hasBehaviors as $hasBehavior)
        {
            if ($hasBehavior instanceof $behavior)
            {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * @param Component $component
     * @param array $behaviors
     * @return bool
     */
    static public function hasBehaviorsOr(Component $component, $behaviors = [])
    {
        foreach ($behaviors as $behavior)
        {
            if (static::hasBehavior($component, $behavior))
            {
                return true;
            }
        }

        return false;
    }
}