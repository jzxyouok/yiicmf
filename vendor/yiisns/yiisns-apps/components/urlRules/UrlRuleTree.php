<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.05.2016
 */
namespace yiisns\apps\components\urlRules;

use yiisns\kernel\models\Tree;
use \yii\base\InvalidConfigException;
use yii\caching\TagDependency;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class UrlRuleTree
 *
 * @package yiisns\kernel\components\urlRules
 */
class UrlRuleTree extends \yii\web\UrlRule
{

    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public static $models = [];

    /**
     *
     * @param \yii\web\UrlManager $manager            
     * @param string $route            
     * @param array $params            
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        if ($route == 'apps/tree/view') {
            $defaultParams = $params;
            
            // the parameters are the model tree, if the model is not found just stop
            $tree = $this->_getCreateUrlTree($params);
            if (! $tree) {
                return false;
            }
            
            if ($tree->redirect) {
                if (strpos($tree->redirect, '://') !== false) {
                    return $tree->redirect;
                } else {
                    $url = trim($tree->redirect, '/');
                    
                    if ($tree->site) {
                        if ($tree->site->server_name) {
                            return $tree->site->url . '/' . $url;
                        } else {
                            return $url;
                        }
                    } else {
                        return $url;
                    }
                }
            }
            
            if ($tree->redirect_tree_id) {
                if ($tree->redirectTree->id != $tree->id) {
                    $paramsNew = ArrayHelper::merge($defaultParams, [
                        'model' => $tree->redirectTree
                    ]);
                    $url = $this->createUrl($manager, $route, $paramsNew);
                    return $url;
                }
            }
            
            // standard charge section dir
            if ($tree->dir) {
                $url = $tree->dir;
            } else {
                $url = "";
            }
            
            if (strpos($url, '//') !== false) {
                
                $url = preg_replace('#/+#', '/', $url);
            }
            
            /**
             *
             * @see parent::createUrl()
             */
            if ($url !== '') {
                $url .= ($this->suffix === null ? $manager->suffix : $this->suffix);
            }
            
            /**
             *
             * @see parent::createUrl()
             */
            if (! empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '?' . $query;
            }
            
            // section attached to the site, the site may be different from that to which we are right now
            if ($tree->site) {
                // TODO:: add check this website. in case of a match the return of a local path
                if ($tree->site->server_name) {
                    return $tree->site->url . '/' . $url;
                }
            }
            return $url;
        }
        return false;
    }

    /**
     *
     * @param $params
     * @return null|Tree
     */
    protected function _getCreateUrlTree(&$params)
    {
        $id = (int) ArrayHelper::getValue($params, 'id');
        $treeModel = ArrayHelper::getValue($params, 'model');
        
        $dir = ArrayHelper::getValue($params, 'dir');
        $site_code = ArrayHelper::getValue($params, 'site_code');
        
        ArrayHelper::remove($params, 'id');
        ArrayHelper::remove($params, 'model');
        
        ArrayHelper::remove($params, 'dir');
        ArrayHelper::remove($params, 'site_code');
        
        if ($treeModel && $treeModel instanceof Tree) {
            $tree = $treeModel;
            self::$models[$treeModel->id] = $treeModel;
            
            return $tree;
        }
        
        if ($id) {
            $tree = ArrayHelper::getValue(self::$models, $id);
            
            if ($tree) {
                return $tree;
            } else {
                $tree = Tree::findOne([
                    'id' => $id
                ]);
                self::$models[$id] = $tree;
                return $tree;
            }
        }
        
        if ($dir) {
            if (! $site_code && \Yii::$app->appSettings && \Yii::$app->appSettings->site) {
                $site_code = \Yii::$app->appSettings->site->code;
            }
            
            $tree = Tree::findOne([
                'dir' => $dir,
                'site_code' => $site_code
            ]);
            
            if ($tree) {
                self::$models[$id] = $tree;
                return $tree;
            }
        }
        
        return null;
    }

    /**
     *
     * @param \yii\web\UrlManager $manager            
     * @param \yii\web\Request $request            
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        if ($this->mode === self::CREATION_ONLY) {
            return false;
        }
        
        if (! empty($this->verb) && ! in_array($request->getMethod(), $this->verb, true)) {
            return false;
        }
        
        $pathInfo = $request->getPathInfo();
        
        //var_dump($pathInfo);
        //var_dump($pathInfo);
        //var_dump($this->host);
        //var_dump($request->getHostInfo());     //print http://www.example.com
        
        if ($this->host !== null) {
            $pathInfo = strtolower($request->getHostInfo()) . ($pathInfo === '' ? '' : '/' . $pathInfo);
        }
        
        $params = $request->getQueryParams();
        $suffix = (string) ($this->suffix === null ? $manager->suffix : $this->suffix);
        $treeNode = null;
        
        $originalDir = $pathInfo;
        if ($suffix) {
            $originalDir = substr($pathInfo, 0, (strlen($pathInfo) - strlen($suffix)));
        }
        /*
         * @see \yiisns\kernel\models\behaviors\traits\HasTableCacheBehavior getTableCacheTag
         */
        $dependency = new TagDependency([
            'tags' => [
                (new Tree())->getTableCacheTag()
            ]
        ]);
        
        if (! $pathInfo) {
            $treeNode = Tree::getDb()->cache(function ($db) {
                return Tree::find()->where([
                    "site_code" => \Yii::$app->appSettings->site->code,
                    "level" => 0
                ])
                    ->one();
            }, null, $dependency);
        } else {
            $treeNode = Tree::find()->where([
                "dir" => $originalDir,
                "site_code" => \Yii::$app->appSettings->site->code
            ])->one();
        }
        
        //var_dump($treeNode['id']);
        
        if ($treeNode) {
            \Yii::$app->appSettings->setCurrentTree($treeNode);
            $route = 'apps/tree/view';    // 可以在配置文件中配置
            $params['id'] = $treeNode->id;    
            return [
                $route,
                $params
            ];
        } else {
            return false;
        }
    }
}