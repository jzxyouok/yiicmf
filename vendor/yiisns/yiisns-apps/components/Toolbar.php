<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.03.2016
 */
namespace yiisns\apps\components;

use yiisns\kernel\base\AppCore;
use yiisns\apps\actions\ViewModelAction;
use yiisns\apps\assets\ToolbarAsset;
use yiisns\apps\assets\ToolbarFancyboxAsset;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\ComponentSettings;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\User;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\rbac\SnsManager;

use yii\base\BootstrapInterface;
use yii\base\ViewEvent;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * Class Toolbar
 * 
 * @package yiisns\apps\components
 */
class Toolbar extends \yiisns\kernel\base\Component implements BootstrapInterface
{
    /**
     * 
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/kernel', 'ToolBar Settings'),
        ]);
    }

    /**
     *
     * @var array the list of IPs that are allowed to access this module.
     *      Each array element represents a single IP filter which can be either an IP address
     *      or an address with wildcard (e.g. 192.168.0.*) to represent a network segment.
     *      The default value is `['127.0.0.1', '::1']`, which means the module can only be accessed
     *      by localhost.
     */
    public $allowedIPs = ['*'];

    public $infoblocks = [];

    public $editWidgets = AppCore::BOOL_N;

    public $editViewFiles = AppCore::BOOL_N;

    public $isOpen = AppCore::BOOL_N;

    public $enabled = 1;

    public $enableFancyboxWindow = 0;

    public $infoblockEditBorderColor = '#1cff00';

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'editWidgets',
                    'editViewFiles',
                    'infoblockEditBorderColor',
                    'isOpen'
                ],
                'string'
            ],
            [
                [
                    'enabled',
                    'enableFancyboxWindow'
                ],
                'integer'
            ]
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'enabled' => \Yii::t('yiisns/kernel', 'Active control panel'),
            'editWidgets' => \Yii::t('yiisns/kernel', 'Edite widgets'),
            'editViewFiles' => \Yii::t('yiisns/kernel', 'Edit View Files'),
            'isOpen' => \Yii::t('yiisns/kernel', 'IsOpen'),
            'enableFancyboxWindow' => \Yii::t('yiisns/kernel', 'FancyboxWindow'),
            'infoblockEditBorderColor' => \Yii::t('yiisns/kernel', 'EditBorderColor')
        ]);
    }

    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'enabled' => \Yii::t('yiisns/kernel', 'Disabled for all users'),
            'isOpen' => \Yii::t('yiisns/kernel', 'Opened or closed by default'),
            'enableFancyboxWindow' => \Yii::t('yiisns/kernel', 'Dialog boxes will be more beautiful, but it may spoil the layout'),
            'infoblockEditBorderColor' => \Yii::t('yiisns/kernel', 'The color of the border around the frame in edit mode'),
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo $form->fieldSet(\Yii::t('yiisns/kernel', 'Main Settings'));
        
        echo $form->field($this, 'enabled')->checkbox();
        echo $form->fieldCheckboxBoolean($this, 'isOpen');
        echo $form->field($this, 'enableFancyboxWindow')->widget(\yii\widget\chosen\Chosen::className(), [
            'items' => \Yii::$app->formatter->booleanFormat
        ]);
        echo $form->fieldRadioListBoolean($this, 'editWidgets');
        echo $form->fieldRadioListBoolean($this, 'editViewFiles');
        echo $form->field($this, 'infoblockEditBorderColor')->widget(\yiisns\apps\widgets\ColorInput::className());
        echo $form->fieldSetEnd();
        
        echo $form->fieldSet(\Yii::t('yiisns/kernel', 'Access Settings'));
        echo \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
            'permissionName' => \yiisns\rbac\SnsManager::PERMISSION_CONTROLL_PANEL,
            'label' => \Yii::t('yiisns/kernel', 'Access Settings')
        ]);
        echo $form->fieldSetEnd();
    }

    public $viewFiles = [];

    public function init()
    {
        parent::init();
        
        \Yii::$app->view->on(View::EVENT_AFTER_RENDER, function (ViewEvent $e) {
            if (\Yii::$app->controller instanceof AdminController) {
                return false;
            }
            
            if (\Yii::$app->toolbar->editViewFiles == AppCore::BOOL_Y && \Yii::$app->toolbar->enabled && \Yii::$app->user->can(SnsManager::PERMISSION_EDIT_VIEW_FILES)) {
                $id = 'sx-view-render-md5' . md5($e->viewFile);
                if (in_array($id, $this->viewFiles)) {
                    return;
                }
                
                $this->viewFiles[$id] = $id;
                
                $e->sender->registerJs(<<<JS
new sx.classes.toolbar.EditViewBlock({'id' : '{$id}'});
JS
);
                $e->output = Html::tag('div', $e->output, [
                    'class' => 'skeeks-cms-toolbar-edit-view-block',
                    'id' => $id,
                    'title' => 'Double click the window settings',
                    'data' => [
                        'id' => $id,
                        'config-url' => UrlHelper::construct([
                            '/admin/admin-tools/view-file-edit',
                            "root-file" => $e->viewFile
                        ])->enableAdmin()
                            ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
                            ->toString()
                    ]
                ]);
            }
        });
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // delay attaching event handler to the view component after it is fully configured
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use($app) {
            $app->getView()
                ->on(View::EVENT_END_BODY, [
                $this,
                'renderToolbar'
            ]);
        });
    }

    public $inited = false;

    public function initEnabled()
    {
        if ($this->inited) {
            return;
        }
        
        if (! $this->enabled) {
            return;
        }
        
        if (\Yii::$app->user->isGuest) {
            $this->enabled = false;
            return;
        }
        
        if (! $this->checkAccess() || \Yii::$app->getRequest()->getIsAjax()) {
            $this->enabled = false;
            return;
        }
    }

    /**
     *
     * @var string
     */
    public $editUrl = '';

    /**
     * Renders mini-toolbar at the end of page body.
     *
     * @param \yii\base\Event $event            
     */
    public function renderToolbar($event)
    {
        $this->initEnabled();
        
        if (! $this->enabled) {
            return;
        }
        
        $urlUserEdit = UrlHelper::construct('admin/admin-profile/update')->enableAdmin()->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true');
        
        $clientOptions = [
            'infoblockSettings' => [
                'border' => [
                    'color' => $this->infoblockEditBorderColor
                ]
            ],
            'container-id' => 'yiisns-toolbar',
            'container-min-id' => 'yiisns-toolbar-min',
            'isOpen' => (bool) ($this->isOpen == AppCore::BOOL_Y),
            'backend-url-triggerEditWidgets' => UrlHelper::construct('apps/toolbar/trigger-edit-widgets')->enableAdmin()->toString(),
            'backend-url-triggerEditViewFiles' => UrlHelper::construct('apps/toolbar/trigger-edit-view-files')->enableAdmin()->toString(),
            'backend-url-triggerIsOpen' => UrlHelper::construct('apps/toolbar/trigger-is-open')->enableAdmin()->toString()
        ];
        
        /* @var $view View */
        $view = $event->sender;
        ToolbarAsset::register($view);
        
        if ($this->enableFancyboxWindow) {
            ToolbarFancyboxAsset::register($view);
        }
        
        echo $view->render('@yiisns/apps/views/toolbar', [
            'clientOptions' => $clientOptions,
            'editUrl' => $this->editUrl,
            'urlUserEdit' => $urlUserEdit,
            'urlSettings' => UrlHelper::construct('admin/admin-settings')->enableAdmin()
                ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
        ]);
    }

    /**
     * Checks if current user is allowed to access the module
     * 
     * @return boolean if access is granted
     */
    protected function checkAccess()
    {
        if (\Yii::$app->user->can(SnsManager::PERMISSION_CONTROLL_PANEL)) {
            if (! \Yii::$app->admin->requestIsAdmin && (! \Yii::$app->controller instanceof AdminController) && ! in_array(\Yii::$app->controller->module->id, [
                'debug',
                'gii'
            ])) {
                return true;
            }
        }
        return false;
    }
}