<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 */
namespace yiisns\apps\components;

use yiisns\kernel\models\Site;
use yiisns\kernel\models\SiteDomain;
use yiisns\kernel\base\AppCore;

use yii\base\Component;
use yii\caching\TagDependency;
use yii\db\Exception;

/**
 *
 * @property Site $site
 * @package yiisns\apps\components
 */
class CurrentSite extends Component
{
    /**
     * @var Site
     */
    protected $_site = null;

    private $_serverName = null;

    /**
     * @return Site
     */
    public function getSite()
    {
        if ($this->_site === null) {
            if (\Yii::$app instanceof \yii\console\Application) {
                $this->_site = Site::find()->active()
                    ->andWhere([
                    'def' => AppCore::BOOL_Y
                ])
                    ->one();
            } else {
                $this->_serverName = \Yii::$app->getRequest()->getServerName();
                $dependencySiteDomain = new TagDependency([
                    'tags' => [
                        (new SiteDomain())->getTableCacheTag()
                    ]
                ]);
                
                $domain = SiteDomain::getDb()->cache(function ($db) {
                    return SiteDomain::find()->where([
                        'domain' => $this->_serverName
                    ])
                        ->one();
                }, null, $dependencySiteDomain);
                
                /**
                 *
                 * @var SiteDomain $domain
                 */
                if ($domain) {
                    $this->_site = $domain->site;
                } else {
                    
                    $this->_site = SiteDomain::getDb()->cache(function ($db) {
                        return Site::find()->active()
                            ->andWhere([
                            'def' => AppCore::BOOL_Y
                        ])
                            ->one();
                    }, null, new TagDependency([
                        'tags' => [
                            (new Site())->getTableCacheTag()
                        ]
                    ]));
                }
            }
        }
        
        return $this->_site;
    }

    /**
     * @param Site $site            
     * @return $this
     */
    public function set(Site $site)
    {
        $this->_site = $site;
        return $this;
    }
}