<?php
/**
 * ImagingController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 11.12.2016
 * @since 1.0.0
 */
namespace yiisns\apps\controllers;

use yiisns\apps\components\Imaging;
use yiisns\apps\components\imaging\Filter;
use yiisns\apps\Exception;
use yiisns\sx\Dir;
use yiisns\sx\File;

use Yii;
use yiisns\kernel\models\StorageFile;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;


/**
 * Class ImagingController
 * @package yiisns\apps\controllers
 */
class ImagingController extends Controller
{
    /**
     * Lists all StorageFile models.
     * @return mixed
     */
    public function actionProcess()
    {
        ini_set('memory_limit', '512M');

        $imaging                        = \Yii::$app->imaging;
        if (!$imaging)
        {
            throw new \yii\base\Exception('Component Imaging not found');
        }

        $newFileSrc                     = \Yii::$app->request->getPathInfo();
        $extension                      = Imaging::getExtension($newFileSrc);

        if (!$extension)
        {
            throw new \yii\base\Exception('Extension not found: ' . $newFileSrc);
        }


        if (!$imaging->isAllowExtension($extension))
        {
            throw new \yii\base\Exception("Extension '{$extension}' not supported in Imaging component");
        }


        $newFile                        = File::object($newFileSrc);
        $strposFilter                   = strpos($newFileSrc, '/' . Imaging::THUMBNAIL_PREFIX);
        if (!$strposFilter)
        {
            throw new \ErrorException('This is not a filter thumbnail: '. $newFileSrc);
        }

        $originalFileSrc                = substr($newFileSrc, 0, $strposFilter) . "." . $newFile->getExtension();

        $webRoot = \Yii::getAlias('@webroot');

        $originalFileRoot           = $webRoot . DIRECTORY_SEPARATOR . $originalFileSrc;
        $newFileRoot                = $webRoot . DIRECTORY_SEPARATOR . $newFileSrc;
        $newFileRootDefault         = $webRoot . DIRECTORY_SEPARATOR . str_replace($newFile->getBaseName(), Imaging::DEFAULT_THUMBNAIL_FILENAME . "." . $extension, $newFileSrc);

        $originalFile       = new File($originalFileRoot);

        if (!$originalFile->isExist())
        {
            throw new \ErrorException('The original file is not found: ' . $newFileSrc);
        }

        $filterSting = substr($newFileSrc, ($strposFilter + strlen(DIRECTORY_SEPARATOR . Imaging::THUMBNAIL_PREFIX) ), strlen($newFileSrc));
        $filterCode = explode("/", $filterSting);
        $filterCode = $filterCode[0];

        if ($params = \Yii::$app->request->get())
        {
            $pramsCheckArray = explode(DIRECTORY_SEPARATOR, $filterSting);
            if (count($pramsCheckArray) < 3)
            {
                throw new \yii\base\Exception("the control line not found: " . $newFileSrc);
            }

            $string = $imaging->getParamsCheckString($params);
            if ($pramsCheckArray[1] != $string)
            {
                throw new \yii\base\Exception("Parameters invalid: " . $newFileSrc);
            }
        }

        $filterClass = str_replace("-", "\\", $filterCode);


        if (!class_exists($filterClass))
        {
            throw new \ErrorException("Filter class is not created: " . $newFileSrc);
        }

        /**
         * @var Filter $filter
         */
        $filter = new $filterClass((array) $params);
        if (!is_subclass_of($filter, Filter::className()))
        {
            throw new \ErrorException("No child filter class: " . $newFileSrc);
        }

        try
        {
                $filter
                    ->setOriginalRootFilePath($originalFileRoot)
                    ->setNewRootFilePath($newFileRootDefault)
                    ->save()
                ;

            if (PHP_OS === 'Windows')
            {
                if ($newFileRoot != $newFileRootDefault)
                {
                    copy($newFileRootDefault, $newFileRoot);
                }
            }
            else
            {
                if ($newFileRoot != $newFileRootDefault)
                {
                    symlink($newFileRootDefault, $newFileRoot);
                }
            }

            $url = \Yii::$app->request->getUrl() . ($params ?
                    ""//"?" . http_build_query($params) . '&sx-refresh'
                    : '?sx-refresh');

            /*Header("HTTP/1.0 200 OK");
            Image::getImagine()->open($newFileRootDefault)->show('png');
            return '';*/

            return \Yii::$app->response->redirect($url, 302);

        } catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}