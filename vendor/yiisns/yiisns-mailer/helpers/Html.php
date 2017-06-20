<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.03.2016
 */
namespace yiisns\mail\helpers;

use yii\helpers\ArrayHelper;
/**
 * Class Html
 * @package yiisns\mail\helpers
 */
class Html extends \yii\helpers\Html
{
    /**
     * Generates a start tag.
     * @param string $name the tag name
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated start tag
     * @see endTag()
     * @see tag()
     */
    public static function beginTag($name, $options = [])
    {
        static::addCssStyle($options, ArrayHelper::getValue(\Yii::$app->mailer->tagStyles, $name, ''));
        return parent::beginTag($name, $options);
    }
}