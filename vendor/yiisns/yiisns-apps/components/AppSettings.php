<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 */
namespace yiisns\apps\components;

use yiisns\apps\assets\AppAsset;
use yiisns\apps\helpers\ComposerHelper;
use yiisns\apps\helpers\FileHelper;
use yiisns\kernel\models\Site;
use yiisns\kernel\models\Tree;
use yiisns\kernel\models\TreeType;
use yiisns\rbac\SnsManager;

use Yii;
use yii\base\Component;
use yii\base\Event;
use yii\base\InvalidParamException;
use yii\base\Theme;
use yii\console\Application;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\validators\EmailValidator;
use yii\web\UploadedFile;
use yii\web\UserEvent;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 *
 * @property Site $site
 * @property Tree $currentTree
 * @property Lang[] $languages
 *
 * @package yiisns\kernel\components
 */
class AppSettings extends \yiisns\kernel\base\Component
{
    /**
     *
     * @var string E-Mail
     */
    public $adminEmail = 'admin@yiisns.cn';

    /**
     *
     * @var string
     */
    public $appName;

    /**
     *
     * @var string
     */
    public $noImageUrl;

    /**
     *
     * @var int
     */
    public $passwordResetTokenExpire = 3600;

    /**
     *
     * @var int
     */
    public $tree_max_code_length = 64;

    /**
     *
     * @var int
     */
    public $element_max_code_length = 128;

    /**
     *
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/kernel', 'YiiSNS Settings'),
            'version' => ArrayHelper::getValue(\Yii::$app->extensions, 'yiisns/kernel.version')
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/form/_form.php', [
            'form' => $form,
            'model' => $this
        ], $this);
    }

    /**
     *
     * @var array
     */
    public $registerRoles = [
        SnsManager::ROLE_USER,
        SnsManager::ROLE_APPROVED
    ];

    /**
     *
     * @return Site
     */
    public function getSite()
    {
        return \Yii::$app->currentSite->site;
    }

    public function init()
    {
        parent::init();
        
        if (! $this->appName) {
            $this->appName = \Yii::$app->name;
        } else {
            \Yii::$app->name = $this->appName;
        }
        
        //if (\Yii::$app instanceof Application) {
        
        //}
        //else {
        if (! $this->noImageUrl) {
            $this->noImageUrl = AppAsset::getAssetUrl('img/image-not-found.jpg');
        }
        
        \Yii::$app->view->on(View::EVENT_BEGIN_PAGE, function (Event $e) {
            if (! \Yii::$app->request->isAjax && ! \Yii::$app->request->isPjax) {
                \Yii::$app->response->getHeaders()
                    ->setDefault('X-Powered-YiiSNS', $this->descriptor->name . " {$this->descriptor->homepage}");
                
                /**
                 *
                 * @var $view View
                 */
                $view = $e->sender;
                if (! isset($view->metaTags['generator'])) {
                    $view->registerMetaTag([
                        'name' => 'generator',
                        'content' => $this->descriptor->name . " — {$this->descriptor->homepage}"
                    ], 'generator');
                }
                
                if (! isset($view->metaTags['author'])) {
                    $view->registerMetaTag([
                        'name' => 'author',
                        'content' => 'YiiSNS Team'
                    ], 'author');
                }
            }
        });
        
        \Yii::$app->user->on(\yii\web\User::EVENT_AFTER_LOGIN, function (UserEvent $e) {
            $e->identity->logged_at = \Yii::$app->formatter->asTimestamp(time());
            $e->identity->save(false);
            
            if (\Yii::$app->admin->requestIsAdmin) {
                \Yii::$app->user->identity->updateLastAdminActivity();
            }
        });
        //}
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['adminEmail', 'noImageUrl', 'appName'], 'string'],
            [['adminEmail'], 'email'],
            [['adminEmail'], 'email'],
            [['passwordResetTokenExpire'], 'integer', 'min' => 300],
            [['registerRoles'], 'safe'],
            [['tree_max_code_length'], 'integer'],
            [['element_max_code_length'], 'integer']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'adminEmail' => \Yii::t('yiisns/kernel', 'AdminEmail'),
            'noImageUrl' => \Yii::t('yiisns/kernel', 'NoImageUrl'),
            'appName' => \Yii::t('yiisns/kernel', 'AppName'),
            'passwordResetTokenExpire' => \Yii::t('yiisns/kernel', 'PasswordResetTokenExpire'),
            'registerRoles' => \Yii::t('yiisns/kernel', 'Roles Settings'),
            'tree_max_code_length' => \Yii::t('yiisns/kernel', 'Tree_max_code_length'),
            'element_max_code_length' => \Yii::t('yiisns/kernel', 'Element_max_code_length')
        ]);
    }

    /**
     * 返回应用程序的LOGO
     *
     * @return string
     */
    public function logo()
    {
        return '';
    }

    /**
     *
     * @var Tree
     */
    protected $_tree = null;

    /**
     *
     * @param Tree $tree            
     * @return $this
     */
    public function setCurrentTree(Tree $tree)
    {
        $this->_tree = $tree;
        return $this;
    }

    /**
     *
     * @return Tree
     */
    public function getCurrentTree()
    {
        return $this->_tree;
    }
}