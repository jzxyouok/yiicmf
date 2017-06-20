<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\admin\actions;

use yiisns\apps\helpers\UrlHelper;

use yiisns\admin\components\UrlRule;
use yiisns\admin\widgets\ControllerActions;
use yiisns\admin\controllers\AdminController;
use yii\base\InvalidParamException;
use yii\helpers\Inflector;
use yii\web\Application;
use yii\web\ViewAction;

/**
 *
 * @property UrlHelper $url
 * @property AdminController $controller Class AdminViewAction
 * @package yiisns\admin\actions
 */
class AdminAction extends ViewAction
{
    use AdminActionTrait;

    /**
     *
     * @var string Default prefix empty
     */
    public $viewPrefix = '';

    /**
     *
     * @var array
     */
    public $viewParams = [];

    /**
     *
     * @var
     *
     */
    public $viewName = null;

    /**
     *
     * @var
     */
    public $callback;

    public function init()
    {
        // Name is not specified, show something
        if (! $this->name) {
            $this->name = Inflector::humanize($this->id);
        }
        
        if (! $this->controller instanceof AdminController) {
            throw new InvalidParamException(\Yii::t('yiisns/admin', 'This action is designed to work with the controller: ') . AdminController::className());
        }
        
        $this->defaultView = $this->id;
        
        if ($this->viewName) {
            $this->defaultView = $this->viewName;
        }
        parent::init();
    }

    /**
     *
     * @return mixed|string
     * @throws InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        if ($this->callback) {
            return $this->runCallback();
        }
        
        return parent::run();
    }

    public function runCallback()
    {
        if ($this->callback) {
            if (! is_callable($this->callback)) {
                throw new InvalidConfigException('"' . get_class($this) . '::callback" ' . \Yii::t('yiisns/admin', 'Should be a valid callback'));
            }
            
            return call_user_func($this->callback, $this);
        }
    }

    /**
     * Renders a view
     *
     * @param string $viewName view name
     * @return string result of the rendering
     */
    protected function render($viewName)
    {
        $this->viewParams = array_merge($this->viewParams, [
            'action' => $this
        ]);
        
        return $this->controller->render($viewName, (array) $this->viewParams);
    }

    /**
     *
     * @return UrlHelper
     */
    public function getUrl()
    {
        if ($this->controller->module instanceof Application) {
            $route = $this->controller->id . '/' . $this->id;
        } else {
            $route = $this->controller->module->id . '/' . $this->controller->id . '/' . $this->id;
        }
        
        $url = UrlHelper::constructCurrent()->setRoute($route)
            ->enableAdmin()
            ->setCurrentRef();
        
        return $url;
    }

    /**
     *
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }
}