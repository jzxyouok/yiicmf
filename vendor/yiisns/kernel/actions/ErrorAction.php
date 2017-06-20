<?php
/**
 * ErrorAction
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 04.11.2016
 * @since 1.0.0.0
 */
namespace yiisns\kernel\actions;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\rbac\SnsManager;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Response;

/**
 * Class ErrorAction
 * 
 * @package yiisns\kernel\actions
 */
class ErrorAction extends \yii\web\ErrorAction
{
    /**
     * Runs the action
     *
     * @return string result content
     */
    public function run()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }
        
        if ($exception instanceof \HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = $this->defaultName ?  : Yii::t('yii', 'Error');
        }
        
        if ($code) {
            $name .= " (#$code)";
        }
        
        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?  : Yii::t('yii', 'An internal server error occurred.');
        }
        
        if (Yii::$app->getRequest()->getIsAjax()) {
            $rr = new RequestResponse();
            
            $rr->success = false;
            $rr->message = "$name: $message";
            
            return (array) $rr;
        } else {
            
            //var_dump(\Yii::$app->getModule('admin'));die;
            
            if (\Yii::$app->getModule('admin')->checkAccess() && \Yii::$app->admin->requestIsAdmin) {
                if (\Yii::$app->user->can(SnsManager::PERMISSION_ADMIN_ACCESS)) {
                    $this->controller->layout = \Yii::$app->getModule('admin')->layout;
                    return $this->controller->render('@yiisns/admin/views/error/error', [
                        'message' => nl2br(Html::encode($message))
                    ]);
                } else {
                    $this->controller->layout = '@yiisns/admin/views/layouts/unauthorized';
                    
                    return $this->controller->render('@yiisns/admin/views/error/unauthorized-403', [
                        'message' => nl2br(Html::encode($message))
                    ]);
                }
            } else {
                // All requests are to our backend
                // TODO::Add image processing
                $info = pathinfo(\Yii::$app->request->pathInfo);
                if ($extension = ArrayHelper::getValue($info, 'extension')) {
                    $extension = \yiisns\apps\helpers\StringHelper::strtolower($extension);
                    if (in_array($extension, [
                        'js',
                        'css'
                    ])) {
                        \Yii::$app->response->format = Response::FORMAT_RAW;
                        if ($extension == 'js') {
                            \Yii::$app->response->headers->set('Content-Type', 'application/javascript');
                        }
                        if ($extension == 'css') {
                            \Yii::$app->response->headers->set('Content-Type', 'text/css');
                        }
                        
                        $url = \Yii::$app->request->absoluteUrl;
                        return "/* File: '{$url}' not found */";
                    }
                }
                
                return $this->controller->render($this->view ?  : $this->id, [
                    'name' => $name,
                    'message' => $message,
                    'exception' => $exception
                ]);
            }
        }
    }
}