<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.04.2016
 */
namespace yiisns\apps\widgets\formInputs\ckeditor;

use yiisns\apps\Exception;
use yiisns\apps\helpers\UrlHelper;

use Yii;
use yii\ckeditor\CKEditorWidget;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Class Ckeditor
 * @package yiisns\kernel\widgets\formInputs\ckeditor
 */
class Ckeditor extends CKEditorWidget
{
    public $relatedModel;

    public function __construct($config = [])
    {
        if (\Yii::$app->admin->requestIsAdmin)
        {
            $config = ArrayHelper::merge(\Yii::$app->admin->getCkeditorOptions(), $config);
        }

        parent::__construct($config);
    }

    public function init()
    {
        $additionalData = [];
        if ($this->relatedModel && ($this->relatedModel instanceof ActiveRecord && !$this->relatedModel->isNewRecord))
        {
            $additionalData = [
                'className' => $this->relatedModel->className(),
                'pk'        => $this->relatedModel->primaryKey,
            ];
        }

        $this->clientOptions['filebrowserImageBrowseUrl'] = UrlHelper::construct('admin/admin-tools/select-file', $additionalData)
            ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
            ->enableAdmin()
            ->toString();

        parent::init();
    }
}