<?php
/**
 * Base Controller
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 04.24.2017
 * @since 1.0.0
 */
namespace yiisns\kernel\base;

use yii\web\Application;
use yii\web\Controller as YiiWebController;
use yii\base\ViewNotFoundException;
use yii\helpers\ArrayHelper;

class Controller extends YiiWebController
{
    public function render($view, $params = [])
    {
        if ($this->module instanceof Application) {
            //echo 'Module as Application'; die;
            return parent::render($view, $params);
        } else if (strpos($view, '/') && strpos($view, '@app/views') === false) {
            //echo 'Views without @app/views/'; die;
            return parent::render($view, $params);
        } else {
            //echo 'App View'; die;
            $viewDir = '@app/views/modules/' . $this->module->id . '/' . $this->id;
            $viewApp = $viewDir . '/' . $view;
            if (isset(\Yii::$app->view->theme->pathMap['@app/views'])) {
                $tempPaths = [];
                foreach (\Yii::$app->view->theme->pathMap['@app/views'] as $path) {
                    $tempPaths[] = $path . '/modules/' .$this->module->id . '/' . $this->id;
                }
                $tempPaths[] = $this->viewPath;
                //print_r($this->viewPath);die;
                \Yii::$app->view->theme->pathMap = ArrayHelper::merge(\Yii::$app->view->theme->pathMap, [
                    $viewDir => $tempPaths
                ]);
                //print_r($viewDir);die;
                //print_r(\Yii::$app->view->theme->pathMap);die;
            }
            return parent::render($viewApp, $params);
        }
    }
}