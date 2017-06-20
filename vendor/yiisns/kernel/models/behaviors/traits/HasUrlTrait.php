<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.05.2016
 */
namespace yiisns\kernel\models\behaviors\traits;

use yiisns\kernel\models\ContentElementTree;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *
 * @method string getAbsoluteUrl()
 * @method string getUrl()
 *        
 * @property string absoluteUrl
 * @property string url
 */
trait HasUrlTrait
{
    /**
     *
     * @return string
     */
    public function getAbsoluteUrl()
    {
        return $this->url;
    }

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return '';
    }
}