<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.09.2016
 */
namespace yiisns\admin\widgets;

use yiisns\admin\components\UrlRule;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Class UserLastActivityWidget
 * 
 * @package yiisns\admin\widgets
 */
class UserLastActivityWidget extends Widget
{
    /**
     * Runs the widget.
     */
    public function run()
    {
        $userLastActivity = \yii\helpers\Json::encode($this->getOptions());
        
        $this->view->registerJs(<<<JS
        new sx.classes.UserLastActivity({$userLastActivity});
JS
);
    }

    public function getOptions()
    {
        return [
            'blockedAfterTime' => (\Yii::$app->admin->blockedTime - \Yii::$app->user->identity->lastAdminActivityAgo),
            'startTime' => \Yii::$app->formatter->asTimestamp(time()),
            'leftTimeInfo' => 30,
            'isGuest' => (bool) \Yii::$app->user->isGuest,
            'ajaxLeftTimeInfo' => 300,
            'interval' => 5,
            'backendGetUser' => Url::to([
                '/admin/admin-tools/admin-last-activity',
                UrlRule::ADMIN_PARAM_NAME => UrlRule::ADMIN_PARAM_VALUE
            ])
        ];
    }
}