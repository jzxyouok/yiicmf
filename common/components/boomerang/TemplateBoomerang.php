<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.10.2016
 */
namespace common\components\boomerang;

use application\assets\BoomerangThemeAsset;
use yiisns\kernel\base\Component;
use yiisns\kernel\base\AppCore;

use Yii;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 *
 * @var string $bodyCssClasses
 *   
 * Class TemplateBoomerang
 * @package common\components\unify
 */
class TemplateBoomerang extends Component
{
    /**
     *
     * @return array
     */
    static public function themes()
    {
        return [
            'blue' => 'blue',
            'violet' => 'violet',
            'orange' => 'orange',
            'red' => 'red',
            'green' => 'green',
            'yellow' => 'yellow'
        ];
    }

    /**
     * Name and description of the component
     * 
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => 'Boomerang template options'
        ]);
    }

    /**
     *
     * @var string
     */
    public $themeColor = 'green';

    /**
     *
     * @var string
     */
    public $boxedBgImage = '/img/bg.png';

    public $boxedBgCss = 'repeat';

    /**
     *
     * @var string
     */
    public $boxedLayout = AppCore::BOOL_Y;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'themeColor'
                ],
                'string'
            ],
            [
                [
                    'boxedBgImage'
                ],
                'string'
            ],
            [
                [
                    'boxedLayout'
                ],
                'string'
            ],
            [
                [
                    'boxedBgCss'
                ],
                'string'
            ]
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'themeColor' => 'Color scheme',
            'boxedBgImage' => 'Background image',
            'boxedLayout' => 'Fixed template',
            'boxedBgCss' => 'Css style for background'
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo $form->fieldSet(\Yii::t('app', 'Main'));
        
        echo $form->fieldSelect($this, 'themeColor', static::themes(), [
            'allowDeselect' => true
        ]);
        
        echo $form->fieldRadioListBoolean($this, 'boxedLayout');
        
        echo $form->field($this, 'boxedBgImage')->widget(\yiisns\admin\widgets\formInputs\OneImage::className());
        echo $form->field($this, 'boxedBgCss')
            ->textInput()
            ->hint('repeat or fixed center center');
        
        echo $form->fieldSetEnd();
    }

    /**
     *
     * @return $this
     */
    public function initTheme()
    {
        if ($this->themeColor) {
            if (in_array($this->themeColor, array_keys(self::themes()))) {
                \Yii::$app->view->registerCssFile(BoomerangThemeAsset::getAssetUrl('css/global-style-' . $this->themeColor . '.css'), [
                    'depends' => [
                        'application\assets\BoomerangThemeAsset'
                    ]
                ]);
            }
        }
        
        if ($this->boxedBgImage) {
            \Yii::$app->view->registerCss(<<<CSS
            body
            {
                background: url('{$this->boxedBgImage}') {$this->boxedBgCss};
            }
CSS
);
        }     
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getBodyCssClasses()
    {
        if ($this->boxedLayout == AppCore::BOOL_Y) {
            return 'body-boxed';
        }      
        return '';
    }
}