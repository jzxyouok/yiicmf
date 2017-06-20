<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.03.2016
 */
namespace yiisns\admin\widgets\formInputs;

use yiisns\apps\Exception;

use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\Publication;
use yiisns\admin\Module;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Application;
use yii\widgets\InputWidget;

/**
 * @property $modelData
 *
 * Class SelectModelDialogInput
 * @package yiisns\admin\widgets\formInputs
 */
class SelectModelDialogInput extends InputWidget
{
    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var string
     */
    public $selectUrl = '';

    /**
     * @var string
     */
    public $baseRoute;

    /**
     * @var boolean whether to show deselect button on single select
     */
    public $allowDeselect = true;

    /**
     * @var bool
     */
    public $closeWindow = true;


    public $viewFile  = 'select-model-dialog-input';


    public function init()
    {
        parent::init();

        if (!$this->selectUrl)
        {
            $additionalData = [];
            $additionalData['callbackEvent'] = $this->getCallbackEvent();

            $this->selectUrl = \yiisns\apps\helpers\UrlHelper::construct($this->baseRoute, $additionalData)
                                ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
                                ->enableAdmin()
                                ->toString();
        }

    }

    /**
     * @return null|static
     */
    public function getModelData()
    {
        if ($id = $this->model->{$this->attribute})
        {
            return [
                'id' => $id
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        try
        {
            echo $this->render($this->viewFile, [
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
        return $this->id . '-select-dialog';
    }

    /**
     * @return string
     */
    public function getJsonOptions()
    {
        return Json::encode([
            'id'                        => $this->id,
            'callbackEvent'             => $this->getCallbackEvent(),
            'selectUrl'                 => $this->selectUrl,
            'closeWindow'               => (int) $this->closeWindow,
        ]);
    }
}