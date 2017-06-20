<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.03.2016
 */
namespace yiisns\admin\components\settings;

use yiisns\apps\base\Widget;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\base\Component;
use yiisns\kernel\base\AppCore;
use yiisns\admin\assets\AdminAsset;
use yiisns\admin\base\AdminDashboardWidget;
use yiisns\admin\components\Menu;
use yiisns\admin\components\UrlRule;
use yiisns\admin\dashboards\AboutSNSDashboard;
use yiisns\admin\dashboards\SNSInformDashboard;
use yiisns\admin\dashboards\ContentElementListDashboard;
use yiisns\admin\dashboards\DiscSpaceDashboard;
use yii\base\BootstrapInterface;
use yii\base\Theme;
use yii\helpers\ArrayHelper;
use yii\web\Application;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\ckeditor\CKEditorPresets;

/**
 *
 * @property [] $dasboardWidgets
 * @property [] $dasboardWidgetsLabels
 *
 * @property bool $requestIsAdmin
 * @property Menu $menu Class AdminSettings
 * @package yiisns\admin\components\settings
 */
class AdminSettings extends Component
{
    /**
     * The name and description of the component etc.
     *
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/kernel', 'Setting the admin panel')
        ]);
    }

    /**
     *
     * @var Additional styling admin
     */
    public $asset;

    /**
     *
     * @var array Components Desktops
     */
    public $dashboards = [];

    /**
     * Default pjax options
     *
     * @var array
     */
    public $pjax = [
        'timeout' => 30000
    ];

    /**
     * Control via the admin interface
     */
    public $enableCustomConfirm = AppCore::BOOL_Y;

    public $enableCustomPromt = AppCore::BOOL_Y;

    public $languageCode = 'zh-CN';

    public $enabledPjaxPagination = AppCore::BOOL_Y;

    public $pageSize = 10;

    public $pageSizeLimitMin = 1;

    public $pageSizeLimitMax = 500;

    public $pageParamName = 'page';

    public $ckeditorPreset = CKEditorPresets::EXTRA;

    public $ckeditorSkin = CKEditorPresets::SKIN_MOONO_COLOR;

    public $ckeditorHeight = 400;

    public $ckeditorCodeSnippetGeshi = AppCore::BOOL_N;

    public $ckeditorCodeSnippetTheme = 'monokai_sublime';

    public $blockedTime = 300;

    public $noImage = '';

    /**
     *
     * @return array
     */
    public function getDasboardWidgets()
    {
        $baseWidgets = [
            'Basic widgets' => [
                AboutSNSDashboard::className(), // 必须在这里添加 才会出现在挂件的列表中，系统内置的挂件
                SNSInformDashboard::className(),
                DiscSpaceDashboard::className()
            ]
            // ContentElementListDashboard::className(), //移动到扩展挂件
            
        ];
        
        $widgetsAll = ArrayHelper::merge($baseWidgets, $this->dashboards);
        $result = [];
        foreach ($widgetsAll as $label => $widgets) {
            if (is_array($widgets)) {
                $resultWidgets = [];
                foreach ($widgets as $key => $classWidget) {
                    if (class_exists($classWidget) && is_subclass_of($classWidget, AdminDashboardWidget::className())) {
                        $resultWidgets[$classWidget] = $classWidget;
                    }
                }
                
                $result[\Yii::t('yiisns/kernel', $label)] = $resultWidgets;
            }
        }
        
        return $result;
    }

    /**
     *
     * @return array
     */
    public function getDasboardWidgetsLabels()
    {
        $result = [];
        if ($this->dasboardWidgets) {
            foreach ($this->dasboardWidgets as $label => $widgets) {
                $resultWidgets = [];
                foreach ($widgets as $key => $widgetClassName) {
                    $resultWidgets[$widgetClassName] = (new $widgetClassName())->descriptor->name;
                }
                
                $result[$label] = $resultWidgets;
            }
        }
        
        return $result;
    }

    public function init()
    {
        parent::init();
        
        if ($this->requestIsAdmin) {
            if ($this->pjax) {
                \Yii::$container->set('yii\widgets\Pjax', $this->pjax);
            }
            if ($this->languageCode != null) {
                \Yii::$app->language = $this->languageCode;
            } else {
                \Yii::$app->language = 'zh-CN';
            }
            
            if (! $this->noImage) {
                $this->noImage = AdminAsset::getAssetUrl('images/no-photo.gif');
            }
        }
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['languageCode', 'pageParamName', 'enabledPjaxPagination'], 'string'],
            [['pageSize'], 'integer'],
            [['pageSizeLimitMin'], 'integer'],
            [['pageSizeLimitMax'], 'integer'],
            [['ckeditorCodeSnippetGeshi'], 'string'],
            [['ckeditorCodeSnippetTheme'], 'string'],
            [['enableCustomConfirm', 'enableCustomPromt', 'pageSize'], 'string'],
            [['ckeditorPreset', 'ckeditorSkin'], 'string'],
            [['ckeditorHeight'], 'integer'],
            [['blockedTime'], 'integer', 'min' => 300],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            // 'asset' => \Yii::t('yiisns/kernel', 'Additional css and js admin area'),
            'enableCustomConfirm' => \Yii::t('yiisns/kernel', 'Include stylized window confirmation (confirm)'),
            'enableCustomPromt' => \Yii::t('yiisns/kernel', 'Include stylized window question with one field (promt)'),
            'languageCode' => \Yii::t('yiisns/kernel', 'Interface language'),
            
            'pageParamName' => \Yii::t('yiisns/kernel', 'Interface language'),
            
            'enabledPjaxPagination' => \Yii::t('yiisns/kernel', 'Turning ajax navigation'),
            'pageParamName' => \Yii::t('yiisns/kernel', 'Parameter name pages, pagination'),
            'pageSize' => \Yii::t('yiisns/kernel', 'Number of records on one page'),
            'pageSizeLimitMin' => \Yii::t('yiisns/kernel', 'The maximum number of records per page'),
            'pageSizeLimitMax' => \Yii::t('yiisns/kernel', 'The minimum number of records per page'),
            
            'ckeditorPreset' => \Yii::t('yiisns/kernel', 'Instruments'),
            'ckeditorSkin' => \Yii::t('yiisns/kernel', 'Theme of formalization'),
            'ckeditorHeight' => \Yii::t('yiisns/kernel', 'Height'),
            'ckeditorCodeSnippetGeshi' => \Yii::t('yiisns/kernel', 'Use code highlighting') . ' (Code Snippets Using GeSHi)',
            'ckeditorCodeSnippetTheme' => \Yii::t('yiisns/kernel', 'Theme of {theme} code', [
                'theme' => 'hightlight'
            ]),
            
            'blockedTime' => \Yii::t('yiisns/kernel', 'Time through which block user')
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/_form.php', [
            'form' => $form,
            'model' => $this
        ], $this);
    }

    /**
     *
     * @param View|null $view            
     */
    public function initJs(View $view = null)
    {
        $options = [
            'BlockerImageLoader' => AdminAsset::getAssetUrl('images/loaders/circulare-blue-24_24.GIF'),
            'disableCetainLink' => false,
            'globalAjaxLoader' => true,
            'menu' => []
        ];
        
        $options = \yii\helpers\Json::encode($options);
        
        \Yii::$app->view->registerJs(<<<JS
        (function(sx, $, _)
        {
            /**
            * @type {Admin}
            */
            sx.App = new sx.classes.Admin($options);

        })(sx, sx.$, sx._);
JS
);
    }

    /**
     *
     * @param View $view            
     * @return $this
     */
    public function registerAsset(View $view)
    {
        if ($this->asset) {
            if (class_exists($this->asset)) {
                $className = $this->asset;
                $className::register($view);
            }
        }
        
        if ($this->enableCustomPromt == AppCore::BOOL_Y) {
            $file = AdminAsset::getAssetUrl('js/classes/modal/Promt.js');
            // $file = \Yii::$app->assetManager->getAssetUrl(AdminAsset::register($view), 'js/classes/modal/Promt.js');
            \Yii::$app->view->registerJsFile($file, [
                'depends' => [
                    AdminAsset::className()
                ]
            ]);
        }
        
        if ($this->enableCustomConfirm == AppCore::BOOL_Y) {
            $file = AdminAsset::getAssetUrl('js/classes/modal/Confirm.js');
            // $file = \Yii::$app->assetManager->getAssetUrl(AdminAsset::register($view), 'js/classes/modal/Confirm.js');
            \Yii::$app->view->registerJsFile($file, [
                'depends' => [
                    AdminAsset::className()
                ]
            ]);
        }
        return $this;
    }

    /**
     * layout
     * 
     * @return bool
     */
    public function isEmptyLayout()
    {
        if (UrlHelper::constructCurrent()->getSystem(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT)) {
            return true;
        }
        
        return false;
    }

    /**
     *
     * @return array
     */
    public function getCkeditorOptions()
    {
        $clientOptions = [
            'height' => $this->ckeditorHeight,
            'skin' => $this->ckeditorSkin,
            'codeSnippet_theme' => $this->ckeditorCodeSnippetTheme
        ];
        
        if ($this->ckeditorCodeSnippetGeshi == AppCore::BOOL_Y) {
            $clientOptions['codeSnippetGeshi_url'] = '../lib/colorize.php';
            
            $preset = CKEditorPresets::getPresets($this->ckeditorPreset);
            $extraplugins = ArrayHelper::getValue($preset, 'extraPlugins', '');
            
            if ($extraplugins) {
                $extraplugins = explode(',', $extraplugins);
            }
            
            $extraplugins = array_merge($extraplugins, [
                'codesnippetgeshi'
            ]);
            $extraplugins = array_unique($extraplugins);
            
            $clientOptions['extraPlugins'] = implode(',', $extraplugins);
        }
        
        return [
            'preset' => $this->ckeditorPreset,
            'clientOptions' => $clientOptions
        ];
    }

    protected $_requestIsAdmin = null;

    /**
     *
     * @return bool
     */
    public function getRequestIsAdmin()
    {
        if ($this->_requestIsAdmin !== null) {
            return $this->_requestIsAdmin;
        }
        
        if (\Yii::$app->urlManager->rules) {
            foreach (\Yii::$app->urlManager->rules as $rule) {
                if ($rule instanceof UrlRule) {
                    $urlRuleAdmin = $rule;
                    
                    $request = \Yii::$app->request;
                    $pathInfo = $request->getPathInfo();
                    $params = $request->getQueryParams();
                    $firstPrefix = substr($pathInfo, 0, strlen($urlRuleAdmin->adminPrefix));
                    
                    if ($firstPrefix == $urlRuleAdmin->adminPrefix) {
                        $this->_requestIsAdmin = true;
                        return $this->_requestIsAdmin;
                    }
                }
            }
        }
        
        $this->_requestIsAdmin = false;
        return $this->_requestIsAdmin;
    }

    /**
     *
     * @var null|\yiisns\admin\components\Menu
     */
    protected $_menu = null;

    /**
     *
     * @return null|\yiisns\admin\components\Menu
     * @throws \yii\base\InvalidConfigException
     */
    public function getMenu()
    {
        if (! $this->_menu) {
            $this->_menu = \Yii::createObject([
                'class' => 'yiisns\admin\components\Menu'
            ]);
        }
        
        return $this->_menu;
    }
}