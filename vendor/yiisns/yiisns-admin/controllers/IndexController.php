<?php
/**
 * Admin
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\Dashboard;
use yiisns\kernel\models\DashboardWidget;
use yiisns\admin\actions\AdminAction;
use yiisns\rbac\SnsManager;

use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * Class IndexController
 *
 * @package yiisns\admin\controllers
 */
class IndexController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Desktop');
        parent::init();
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'indexverbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'dashboard-save' => [
                        'post',
                        'get'
                    ]
                ]
            ]
        ]);
    }

    /**
     *
     * @return string
     */
    public function getPermissionName()
    {
        return SnsManager::PERMISSION_ADMIN_ACCESS;
    }

    /**
     *
     * @return string
     */
    public function actionIndex()
    {
        $dashboard = null;
        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = Dashboard::findOne($pk);
        }
        
        if (! $dashboard) {
            $dashboard = Dashboard::find()->orderBy([
                'priority' => SORT_ASC
            ])->one();
            
            if (! $dashboard) {
                $dashboard = new Dashboard();   // Create Dashboard
                $dashboard->name = 'Default Dashboard';
                
                if (! $dashboard->save()) {
                    throw new NotFoundHttpException(\Yii::t('yiisns/kernel', 'Dashboard not found'));
                }
            }
        }
        
        return $this->redirect(UrlHelper::construct([
            '/admin/index/dashboard',
            'pk' => $dashboard->id
        ])->enableAdmin()->toString());
    }

    public function actionDashboard()
    {
        $dashboard = null;
        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = Dashboard::findOne($pk);
        }
        
        if (! $dashboard) {
            throw new NotFoundHttpException(\Yii::t('yiisns/kernel', 'Dashboard not found'));
        }
        
        $this->layout = '@yiisns/admin/views/layouts/main-empty';
        
        return $this->render($this->action->id, [
            'dashboard' => $dashboard
        ]);
    }

    public function actionDashboardValidate()
    {
        $rr = new RequestResponse();
        $dashboard = null;
        
        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = Dashboard::findOne($pk);
        }
        
        if (! $dashboard) {
            $rr->message = \Yii::t('yiisns/kernel', 'Dashboard not found');
            $rr->success = false;
        }
        
        if ($rr->isRequestAjaxPost()) {
            return $rr->ajaxValidateForm($dashboard);
        }
        
        return $rr;
    }

    public function actionDashboardRemove()
    {
        $rr = new RequestResponse();
        $rr->success = false;
        /**
         *
         * @var $dashboard Dashboard
         */
        $dashboard = null;
        
        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = Dashboard::findOne($pk);
        }
        
        if (! $dashboard) {
            $rr->message = \Yii::t('yiisns/kernel', 'Dashboard not found');
            $rr->success = false;
        }
        
        try {
            $dashboard->delete();
            $rr->redirect = UrlHelper::construct([
                '/admin/index'
            ])->enableAdmin()->toString();
            $rr->success = true;
        } catch (\Exception $e) {
            $rr->message = $e->getMessage();
            $rr->success = false;
        }
        
        return $rr;
    }

    public function actionDashboardSave()
    {
        $rr = new RequestResponse();
        $rr->success = false;
        
        /**
         *
         * @var $dashboard Dashboard
         */
        $dashboard = null;
        
        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = Dashboard::findOne($pk);
        }
        
        if (! $dashboard) {
            $rr->message = \Yii::t('yiisns/kernel', 'Dashboard not found');
            $rr->success = false;
        }
        
        if ($rr->isRequestAjaxPost()) {
            if ($dashboard->load(\Yii::$app->request->post()) && $dashboard->save()) {
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/kernel', 'Save success');
            } else {  
                $rr->message = \Yii::t('yiisns/kernel', 'Cancle');
            }
        }
        
        return $rr;
    }

    public function actionDashboardWidgetCreateValidate()
    {
        $rr = new RequestResponse();
        $dashboardWidget = new DashboardWidget();
        
        if ($rr->isRequestAjaxPost()) {
            return $rr->ajaxValidateForm($dashboardWidget);
        }
        
        return $rr;
    }

    public function actionDashboardWidgetCreateSave()
    {
        $rr = new RequestResponse();
        $dashboardWidget = new DashboardWidget();
        
        if ($rr->isRequestAjaxPost()) {
            if ($dashboardWidget->load(\Yii::$app->request->post()) && $dashboardWidget->save()) {
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/kernel', 'Save success');
            } else {
                $rr->message = \Yii::t('yiisns/kernel', 'Cancle');
            }
        }
        
        return $rr;
    }

    public function actionDashboardCreateValidate()
    {
        $rr = new RequestResponse();
        $dashboard = new Dashboard();
        
        if ($rr->isRequestAjaxPost()) {
            return $rr->ajaxValidateForm($dashboard);
        }
        
        return $rr;
    }

    public function actionDashboardCreateSave()
    {
        $rr = new RequestResponse();
        $dashboard = new Dashboard();
        
        if ($rr->isRequestAjaxPost()) {
            if ($dashboard->load(\Yii::$app->request->post()) && $dashboard->save()) {
                $rr->success = true;
                $rr->message = 'Save';
                $rr->redirect = UrlHelper::construct([
                    '/admin/index/dashboard',
                    'pk' => $dashboard->id
                ])->enableAdmin()->toString();
            } else {
                $rr->message = 'Cancle';
            }
        }
        
        return $rr;
    }

    public function actionWidgetPrioritySave()
    {
        $rr = new RequestResponse();
        $rr->success = false;
        
        /**
         *
         * @var $dashboard Dashboard
         */
        $dashboard = null;
        
        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = Dashboard::findOne($pk);
        }
        
        if (! $dashboard) {
            $rr->message = \Yii::t('yiisns/kernel', 'Dashboard not found');
            $rr->success = false;
        }
        
        $widgets = $dashboard->dashboardWidgets;
        $widgets = ArrayHelper::map($dashboard->dashboardWidgets, 'id', function ($model) {
            return $model;
        });
        
        if ($rr->isRequestAjaxPost()) {
            if ($data = \Yii::$app->request->post()) {
                foreach ($data as $columnId => $widgetIds) {
                    if ($widgetIds) {
                        $priority = 100;
                        foreach ($widgetIds as $widgetId) {
                            if (isset($widgets[$widgetId])) {
                                /**
                                 *
                                 * @var $widget DashboardWidget
                                 */
                                $widget = $widgets[$widgetId];
                                $widget->dashboard_column = $columnId;
                                $widget->priority = $priority;
                                $widget->save();
                                
                                $priority = $priority + 100;
                                
                                unset($widgets[$widgetId]);
                            }
                        }
                    }
                }
                
                if ($widgets) {
                    foreach ($widgets as $widget) {
                        $widget->dashboard_column = $columnId;
                        $widget->priority = $priority;
                        $widget->save();
                        
                        $priority = $priority + 100;
                    }
                }
            }
        }
        
        $rr->success = true;
        
        return $rr;
    }

    public function actionEditDashboardWidget()
    {
        $rr = new RequestResponse();
        $rr->success = false;
        
        /**
         *
         * @var $dashboardWidget DashboardWidget
         */
        $dashboardWidget = null;
        
        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboardWidget = DashboardWidget::findOne($pk);
        }
        
        // print_r($dashboardWidget->toArray());die;
        
        if (\Yii::$app->request->isAjax && ! \Yii::$app->request->isPjax) {
            return $rr->ajaxValidateForm($dashboardWidget->widget);
        }
        
        if (\Yii::$app->request->isPjax && \Yii::$app->request->post()) {
            if (! $dashboardWidget) {
                $rr->message = \Yii::t('yiisns/kernel', "Widget not found");
                $rr->success = false;
            }
            
            if ($dashboardWidget->widget->load(\Yii::$app->request->post())) {
                $data = \Yii::$app->request->post($dashboardWidget->widget->formName());
                $dashboardWidget->component_settings = $data;
                if ($dashboardWidget->save()) {
                    \Yii::$app->session->setFlash('success', 'Saved');
                } else {
                    \Yii::$app->session->setFlash('success', 'Errors');
                }
            }
        }
        
        if (! $dashboardWidget) {
            throw new NotFoundHttpException(\Yii::t('yiisns/kernel', 'Widget not found'));
        }
        
        return $this->render($this->action->id, [
            'model' => $dashboardWidget
        ]);
    }

    public function actionWidgetRemove()
    {
        $rr = new RequestResponse();
        $rr->success = false;
        
        /**
         *
         * @var $dashboardWidget DashboardWidget
         */
        $dashboardWidget = null;
        
        if ($pk = \Yii::$app->request->post('id')) {
            $dashboardWidget = DashboardWidget::findOne($pk);
        }
        
        if (! $dashboardWidget) {
            $rr->message = \Yii::t('yiisns/kernel', 'Widget not found');
            $rr->success = false;
        }
        
        if ($dashboardWidget->delete()) {
            $rr->success = true;
        }     
        return $rr;
    }
}