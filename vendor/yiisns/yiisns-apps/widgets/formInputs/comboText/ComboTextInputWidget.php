<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.06.2016
 */
namespace yiisns\apps\widgets\formInputs\comboText;

use yiisns\apps\Exception;
use yiisns\apps\helpers\UrlHelper;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\ckeditor\CKEditorPresets;
use yii\widget\codemirror\CodemirrorWidget;

/**
 * Class ComboTextInputWidget
 * @package yiisns\apps\widgets\formInputs\comboText
 */
class ComboTextInputWidget extends InputWidget
{
    const CONTROLL_TEXT     = 'text';
    const CONTROLL_EDITOR   = 'editor';
    const CONTROLL_HTML     = 'html';

    static public function editors()
    {
        return [
            self::CONTROLL_TEXT          => \Yii::t('yiisns/kernel', 'Text'),
            self::CONTROLL_EDITOR        => \Yii::t('yiisns/kernel', 'Visual Editor'),
            self::CONTROLL_HTML          => 'HTML',
        ];
    }

    public $defaultEditor = 'text';

    public $defaultOptions = [
        'class' => 'form-control',
        'rows'  => '20',
    ];

    public $clientOptions = [];

    public $modelAttributeSaveType = '';


    /**
     * @var array
     */
    public $ckeditorOptions = [];

    /**
     * @var array
     */
    public $codemirrorOptions = [];

    /**
     * @var \yiisns\apps\widgets\formInputs\ckeditor\Ckeditor
     */
    public $ckeditor = null;

    /**
     * @var CodemirrorWidget
     */
    public $codemirror = null;

    public function init()
    {
        parent::init();

        if (!array_key_exists('id', $this->clientOptions))
        {
            $this->clientOptions['id'] = $this->id;
        }
    }

    /**
	 * @inheritdoc
	 */
	public function run()
	{
        $this->options = ArrayHelper::merge($this->defaultOptions, $this->options);

        if ($this->hasModel())
        {
            if (!array_key_exists('id', $this->options))
            {
                $this->clientOptions['inputId'] = Html::getInputId($model, $attribute);
            } else
            {
                $this->clientOptions['inputId'] = $this->options['id'];
            }

			$textarea = Html::activeTextarea($this->model, $this->attribute, $this->options);
		} else
        {
            echo Html::textarea($this->name, $this->value, $this->options);
            return;
		}

        $this->registerPlugin();

        echo $this->render('combo-text', [
            'widget'    => $this,
            'textarea'  => $textarea
        ]);
	}

    /**
	 * Registers CKEditor plugin
	 */
	protected function registerPlugin()
	{
		$view = $this->getView();

        $this->ckeditor = new \yiisns\apps\widgets\formInputs\ckeditor\Ckeditor(ArrayHelper::merge([
            'model'         => $this->model,
            'attribute'     => $this->attribute,
            'relatedModel'  => $this->model,
        ], $this->ckeditorOptions));

        $this->codemirror = new CodemirrorWidget(ArrayHelper::merge([
            'model'         => $this->model,
            'attribute'     => $this->attribute,

            'preset'    => 'htmlmixed',
            'assets'    =>
            [
                \yii\widget\codemirror\CodemirrorAsset::THEME_NIGHT
            ],
            'clientOptions'   =>
            [
                'theme' => 'night'
            ],

        ], $this->codemirrorOptions));

        $this->ckeditor->registerAssets();
        $this->codemirror->registerAssets();

        $this->clientOptions['ckeditor']    = $this->ckeditor->clientOptions;
        $this->clientOptions['codemirror']  = $this->codemirror->clientOptions;

        ComboTextInputWidgetAsset::register($this->view);
	}
}