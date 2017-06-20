<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
namespace yiisns\seo\controllers;

use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\Tree;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class SitemapController
 *
 * @package yiisns\kernel\seo\controllers
 */
class SitemapController extends Controller
{
    /**
     *
     * @return string
     */
    public function actionOnRequest()
    {
        ini_set('memory_limit', '512M');
        
        $trees = Tree::find()->where([
            'site_code' => \Yii::$app->appSettings->site->code
        ])
            ->orderBy([
            'level' => SORT_ASC,
            'priority' => SORT_ASC
        ])
            ->all();
        
        if ($trees) {
            foreach ($trees as $tree) {
                if (! $tree->redirect && ! $tree->redirect_tree_id) {
                    $result[] = [
                        'loc' => $tree->absoluteUrl,
                        'lastmod' => $this->_lastMod($tree)
                    ];
                }
            }
        }
        
        $elements = ContentElement::find()->joinWith('tree')
            ->andWhere([
            Tree::tableName() . '.site_code' => \Yii::$app->appSettings->site->code
        ])
            ->orderBy([
            'updated_at' => SORT_DESC,
            'priority' => SORT_ASC
        ])
            ->all();
        
        if ($elements) {
            /**
             *
             * @var ContentElement $model
             */
            foreach ($elements as $model) {
                $result[] = [
                    'loc' => $model->absoluteUrl,
                    'lastmod' => $this->_lastMod($model)
                ];
            }
        }
        
        $result[] = [
            'loc' => Url::to([
                ''
            ], true)
        ];
        
        \Yii::$app->response->format = Response::FORMAT_XML;
        $this->layout = false;
        
        \Yii::$app->response->content = $this->render($this->action->id, [
            'data' => $result
        ]);
        
        return;
    }

    /**
     *
     * @param Tree $model            
     * @return string
     */
    private function _lastMod($model)
    {
        $string = '2016-01-01T21:14:41+01:00';
        $string = date('Y-m-d', $model->updated_at) . 'T' . date('H:i:s+04:00', $model->updated_at);
        
        return $string;
    }

    /**
     *
     * @param Tree $model            
     * @return string
     */
    private function _calculatePriority($model)
    {
        $priority = '0.4';
        if ($model->level == 0) {
            $priority = '1.0';
        } else 
            if ($model->level == 1) {
                $priority = '0.8';
            } else 
                if ($model->level == 2) {
                    $priority = '0.7';
                } else 
                    if ($model->level == 3) {
                        $priority = '0.6';
                    } else 
                        if ($model->level == 4) {
                            $priority = '0.5';
                        }
        
        return $priority;
    }
}