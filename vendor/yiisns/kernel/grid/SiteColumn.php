<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 01.09.2016
 */
namespace yiisns\kernel\grid;

use yiisns\kernel\models\Site;
use yii\db\ActiveRecord;
use yii\grid\DataColumn;

/**
 * Class SiteColumn
 * @package yiisns\kernel\grid
 */
class SiteColumn extends DataColumn
{
    public $attribute = 'site_code';

    public function init()
    {
        parent::init();

        if (!$this->filter)
        {
            $this->filter = \yii\helpers\ArrayHelper::map(
                \yiisns\kernel\models\Site::find()->all(),
                'code',
                'name'
            );
        }
    }
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($model->site && $model->site instanceof Site)
        {
            $site = $model->site;
        }
        else
        {

        }

        if ($site)
        {
            return $site->name;
        }

        return null;
    }
}