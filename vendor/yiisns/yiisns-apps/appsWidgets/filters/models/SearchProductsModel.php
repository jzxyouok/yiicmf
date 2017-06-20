<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
namespace yiisns\apps\appsWidgets\filters\models;

use yiisns\apps\base\Widget;
use yiisns\apps\base\WidgetRenderable;
use yiisns\kernel\base\AppCore;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\ContentElementTree;
use yiisns\kernel\models\Search;
use yiisns\kernel\models\Tree;

use yii\base\InvalidParamException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class SearchProductsModel
 * @package yiisns\apps\appsWidgets\filters\models
 */
class SearchProductsModel extends Model
{
    public $image;

    public function rules()
    {
        return [
            [['image'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' =>  \Yii::t('yiisns/kernel', 'With photo'),
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function search(ActiveDataProvider $dataProvider)
    {
        $query = $dataProvider->query;

        if ($this->image == AppCore::BOOL_Y)
        {
            $query->andWhere([
                'or',
                ['!=', 'content_element.image_id', null],
                ['!=', 'content_element.image_id', ''],
            ]);
        } else if ($this->image == AppCore::BOOL_N)
        {
            $query->andWhere([
                'or',
                ['content_element.image_id' => null],
                ['content_element.image_id' => ''],
            ]);
        }
        return $dataProvider;
    }
}