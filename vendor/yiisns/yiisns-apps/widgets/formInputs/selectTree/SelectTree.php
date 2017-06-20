<?php
/**
 * SelectTree
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 13.11.2016
 * @since 1.0.0
 */
namespace yiisns\apps\widgets\formInputs\selectTree;

use yiisns\apps\Exception;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Tree;
use yiisns\admin\Module;
use yiisns\admin\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use Yii;

/**
 * Class Widget
 * @package yiisns\kernel\widgets\formInputs\selectTree
 */
class SelectTree extends InputWidget
{
    /**
     * @var array the options for the Bootstrap File Input plugin. Default options have exporting enabled.
     * Please refer to the Bootstrap File Input plugin Web page for possible options.
     * @see http://plugins.krajee.com/file-input#options
     */
    public $clientOptions = [];


    public $attributeSingle     = 'tree_id';
    public $attributeMulti      = 'tree_ids';


    const MOD_COMBO     = 'combo';
    const MOD_SINGLE    = 'single';
    const MOD_MULTI     = 'multi';

    public $mode        = self::MOD_COMBO;


    /**
     * Берем поведения модели
     *
     */
    private function _initAndValidate()
    {
        if (!$this->hasModel())
        {
            throw new Exception(\Yii::t('yiisns/kernel',"This file is intended only for forms model"));
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        try
        {
            $this->_initAndValidate();

            $valueArray         = [];
            $trees              = [];
            $valueSingle        = "";

            $select = "";
            $singleInput = "";


            if (in_array($this->mode ,[self::MOD_COMBO, self::MOD_MULTI]))
            {
                $valueArray         = Html::getAttributeValue($this->model, $this->attribute);
                $select = Html::activeListBox($this->model, $this->attribute, ['16' => "16"], [
                    'multiple' => true,
                    'class' => 'sx-controll-element sx-multi',
                    'style' => 'display: none;'
                ]);
                $trees          = Tree::find()->where(['id' => $valueArray])->all();

            }

            if (in_array($this->mode ,[self::MOD_COMBO, self::MOD_SINGLE]))
            {
                $singleInput = Html::activeInput("hidden", $this->model, $this->attributeSingle, [
                    'class' => 'sx-single'
                ]);
                $valueSingle        = Html::getAttributeValue($this->model, $this->attributeSingle);
            }



            $src = UrlHelper::construct('/admin/admin-tools/tree')
                            ->set('mode', $this->mode)
                            ->setSystemParam(Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
                            ->setSystemParam(Module::SYSTEM_QUERY_NO_ACTIONS_MODEL, 'true')
                            ->enableAdmin()->toString();

            $id = "sx-id-" . md5(serialize([
                    $this->clientOptions, $this->mode, $this->attributeMulti, $this->attributeSingle
                ]));

            $selected = [];
            foreach ($trees as $tree)
            {
                $selected[] = $tree->id;
            }

            return $this->render('widget', [
                'widget'            => $this,
                'id'                => $id,
                'select'            => $select,
                'src'               => $src,
                'valueSingle'       => $valueSingle,
                'idSmartFrame'      => $id . "-smart-frame",
                'singleInput'       => $singleInput,
                'clientOptions'     => Json::encode(
                    [
                        'idSmartFrame'       => $id . "-smart-frame",
                        'src'       => $src,
                        'name'      => $id,
                        'id'        => $id,
                        'selected'  => $selected,
                        'valueSingle'  => $valueSingle
                    ]
                )

            ]);

            //$this->registerClientScript();

        } catch (Exception $e)
        {
            echo $e->getMessage();
        }

    }

    /**
     * Registers Bootstrap File Input plugin
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        Asset::register($view);
    }
}
