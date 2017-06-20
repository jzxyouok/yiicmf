<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.07.2016
 */
namespace yiisns\assetsAuto;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * @property array htmlCompressOptions
 *          
 * Class SettingsAssetsAutoCompress
 * @package yiisns\kernel\assetsAuto
 */
class SettingsAssetsAutoCompress extends \yiisns\kernel\base\Component
{
    /**
     *
     * @var bool 关闭编译机制
     */
    public $enabled = false;

    /**
     *
     * @var bool
     */
    public $jsCompress = true;

    /**
     *
     * @var bool 处理 js 时的注释
     */
    public $jsCompressFlaggedComments = true;

    /**
     *
     * @var bool
     */
    public $cssCompress = true;

    /**
     *
     * @var bool 启用 css 文件合并
     */
    public $cssFileCompile = true;

    /**
     *
     * @var bool 尝试获取将路径指定为远程文件的 css 文件
     */
    public $cssFileRemouteCompile = false;

    /**
     *
     * @var bool 在保存到文件之前启用 css 压缩和处理
     */
    public $cssFileCompress = false;

    /**
     *
     * @var bool 将 css 文件移到页面底部
     */
    public $cssFileBottom = false;

    /**
     *
     * @var bool 将 css 文件向下移动并用 js 加载它们
     */
    public $cssFileBottomLoadOnJs = false;

    /**
     *
     * @var bool 启用JS合并文件
     */
    public $jsFileCompile = true;

    /**
     *
     * @var bool 尝试获取路径指定的远程文件的js文件，将其写入自己的文件。
     */
    public $jsFileRemouteCompile = false;

    /**
     *
     * @var bool 保存文件前启用压缩和处理JS
     */
    public $jsFileCompress = true;

    /**
     *
     * @var bool 在处理JS时候去掉注释
     */
    public $jsFileCompressFlaggedComments = true;

    /**
     * Enable compression html
     * 
     * @var bool
     */
    public $htmlCompress = true;

    /**
     * Use more compact HTML compression algorithm
     * 
     * @var bool
     */
    public $htmlCompressExtra = false;

    /**
     * During HTML compression, cut out all html comments
     * 
     * @var bool
     */
    public $htmlCompressNoComments = true;

    /**
     * 可以指定组件的名称和说明
     * 
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/assets-auto', 'Compilation settings js and css')
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/forms/_form.php', [
            'form' => $form,
            'model' => $this
        ], $this);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'enabled'
                ],
                'boolean'
            ],
            [
                [
                    'jsCompress'
                ],
                'boolean'
            ],
            [
                [
                    'jsCompressFlaggedComments'
                ],
                'boolean'
            ],
            [
                [
                    'cssFileCompile'
                ],
                'boolean'
            ],
            [
                [
                    'cssFileRemouteCompile'
                ],
                'boolean'
            ],
            [
                [
                    'cssFileCompress'
                ],
                'boolean'
            ],
            [
                [
                    'jsFileCompile'
                ],
                'boolean'
            ],
            [
                [
                    'jsFileRemouteCompile'
                ],
                'boolean'
            ],
            [
                [
                    'jsFileCompress'
                ],
                'boolean'
            ],
            [
                [
                    'jsFileCompressFlaggedComments'
                ],
                'boolean'
            ],
            [
                [
                    'cssCompress'
                ],
                'boolean'
            ],
            [
                [
                    'cssFileBottom'
                ],
                'boolean'
            ],
            [
                [
                    'cssFileBottomLoadOnJs'
                ],
                'boolean'
            ],
            [
                [
                    'htmlCompress'
                ],
                'boolean'
            ],
            [
                [
                    'htmlCompressExtra'
                ],
                'boolean'
            ],
            [
                [
                    'htmlCompressNoComments'
                ],
                'boolean'
            ]
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'enabled' => \Yii::t('yiisns/assets-auto', 'On'),
            'jsCompress' => \Yii::t('yiisns/assets-auto', 'Compiling js in the html code'),
            'jsCompressFlaggedComments' => \Yii::t('yiisns/assets-auto', 'Clipping comments to (compiling JS in HTML code)'),
            'cssFileCompile' => \Yii::t('yiisns/assets-auto', 'Enable merging css files into one'),
            'cssFileRemouteCompile' => \Yii::t('yiisns/assets-auto', 'Try to download a file from a remote server'),
            'cssFileCompress' => \Yii::t('yiisns/assets-auto', 'Compress the resulting CSS file (delete comments, etc.)'),
            'jsFileCompile' => \Yii::t('yiisns/assets-auto', 'Enable .js file merging into one'),
            'jsFileRemouteCompile' => \Yii::t('yiisns/assets-auto', 'Try to download a file from a remote server'),
            'jsFileCompress' => \Yii::t('yiisns/assets-auto', 'Compress the resulting .js file (delete comments, etc.)'),
            'jsFileCompressFlaggedComments' => \Yii::t('yiisns/assets-auto', 'Trim comments'),
            'cssCompress' => \Yii::t('yiisns/assets-auto', 'Enable CSS compression frequent in HTML code'),
            'cssFileBottom' => \Yii::t('yiisns/assets-auto', 'Move CSS files down pages'),
            'cssFileBottomLoadOnJs' => \Yii::t('yiisns/assets-auto', 'Migrate CSS files down pages and load asynchronously using JS'),
            
            'htmlCompress' => \Yii::t('yiisns/assets-auto', 'Enable compression HTML'),
            'htmlCompressExtra' => \Yii::t('yiisns/assets-auto', 'Use more compact HTML compression algorithm'),
            'htmlCompressNoComments' => \Yii::t('yiisns/assets-auto', 'During HTML compression, cut out all html comments')
        ]);
    }

    /**
     *
     * @return array
     */
    public function getHtmlCompressOptions()
    {
        return [
            'extra' => (bool) $this->htmlCompressExtra,
            'no-comments' => (bool) $this->htmlCompressNoComments
        ];
    }
}