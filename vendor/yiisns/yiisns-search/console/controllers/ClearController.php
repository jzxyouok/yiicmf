<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
namespace yiisns\search\console\controllers;

use yiisns\search\models\SearchPhrase;
use yii\console\Controller;

/**
 * Remove old searches
 * 
 * @package yiisns\kernel\console\controllers
 */
class ClearController extends Controller
{

    public $defaultAction = 'phrase';

    /**
     * Remove old searches
     */
    public function actionPhrase()
    {
        $this->stdout('phraseLiveTime: ' . \Yii::$app->search->phraseLiveTime . "\n");
        
        if (\Yii::$app->search->phraseLiveTime) {
            $deleted = SearchPhrase::deleteAll([
                '<=',
                'created_at',
                \Yii::$app->formatter->asTimestamp(time()) - (int) \Yii::$app->search->phraseLiveTime
            ]);
            
            $message = \Yii::t('yiisns/search', 'Removing searches') . " :" . $deleted;
            \Yii::info($message, 'yiisns/search');
            $this->stdout("\t" . $message . "\n");
        }
    }
}