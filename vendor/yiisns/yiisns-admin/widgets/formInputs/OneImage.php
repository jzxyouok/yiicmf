<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.03.2015
 */
namespace yiisns\admin\widgets\formInputs;

use yiisns\apps\Exception;
use yiisns\kernel\models\Publication;
use yiisns\admin\Module;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Application;
use yii\widgets\InputWidget;

/**
 * Class OneImage
 * @package yiisns\admin\widgets\formInputs
 */
class OneImage extends InputWidget
{
    public static $autoIdPrefix = 'inputImage';

    /**
     * @var bool
     */
    public $showPreview = true;

    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var string 
     */
    public $selectFileUrl = '';

    /**
     * @var null
     */
    public $filesModel = null;

    public function init()
    {
        parent::init();

        if (!$this->selectFileUrl)
        {
            $additionalData = [];

            $modelForFile = $this->model;

            if ($this->filesModel)
            {
                $modelForFile = $this->filesModel;
            }

            if ($modelForFile instanceof ActiveRecord && !$modelForFile->isNewRecord)
            {
                $additionalData = [
                    'className' => $modelForFile->className(),
                    'pk'        => $modelForFile->primaryKey,
                ];

            }

            Html::addCssClass($this->options, 'form-control');
            $additionalData['callbackEvent'] = $this->getCallbackEvent();

            $this->selectFileUrl = \yiisns\apps\helpers\UrlHelper::construct('admin/admin-tools/select-file', $additionalData)
                                        ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
                                        ->enableAdmin()
                                        ->toString();
        }
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        try
        {
            echo $this->render('one-image', [
                'widget' => $this,
            ]);

        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * @return string
     */
    public function getCallbackEvent()
    {
        return $this->id . '-select-file';
    }

    /**
     * @return string
     */
    public function getJsonOptions()
    {
        return Json::encode([
            'id'                        => $this->id,
            'callbackEvent'             => $this->getCallbackEvent(),
            'selectFileUrl'             => $this->selectFileUrl,
        ]);

    }
}