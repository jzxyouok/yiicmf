<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.06.2016
 */
namespace yii\ckeditor;

use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * Class CKEditorPresets
 * @package yii\ckeditor
 */
class CKEditorPresets extends Object
{
    const CLEAN     = 'clean';
    const BASIC     = 'basic';
    const STANDART  = 'standart';
    const FULL      = 'full';
    const EXTRA     = 'extra';

    const SKIN_MOONO                = 'moono';
    const SKIN_KAMA                 = 'kama';
    const SKIN_MOONO_BLUE           = 'moono_blue';
    const SKIN_MOONO_COLOR          = 'moonocolor';
    const SKIN_OFFICE_2013          = 'office2013';
    const SKIN_BOOTSTRAPCK          = 'bootstrapck';
    const SKIN_MOONO_DARK           = 'moono-dark';

    /**
     * Доступные скины
     * @return array
     */
    static public function skins()
    {
        return [
            self::SKIN_MOONO                => 'Moono',
            self::SKIN_KAMA                 => 'Kama',
            self::SKIN_MOONO_BLUE           => 'Moono blue',
            self::SKIN_MOONO_COLOR          => 'Moono Color',
            self::SKIN_OFFICE_2013          => 'Office 2013',
            self::SKIN_BOOTSTRAPCK          => 'BootstrapCK4',
            self::SKIN_MOONO_DARK           => 'Moono Dark',
        ];
    }

    /**
     * Available Preinstalls
     * @return array
     */
    static public function allowPresets()
    {
        return [
            self::BASIC     => 'Basic Tool Kit',
            self::STANDART  => 'Standard Toolset',
            self::FULL      => 'Full set of tools',
            self::EXTRA     => 'Full Set +',
        ];
    }

    /**
     * @var array All possible preinstalls
     */
    static public $presets =
    [
        self::CLEAN =>
        [],

        self::BASIC =>
        [
            'height' => 200,
            'extraPlugins'    	=> 'ckwebspeech,sourcedialog,codemirror,ajax,codesnippet,xml,widget,lineutils,dialog,dialogui',
            'toolbarGroups' => [
                ['name' => 'undo'],
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                ['name' => 'colors'],
                ['name' => 'links', 'groups' => ['links', 'insert']],
                ['name' => 'others','groups' => ['others', 'about']],
            ],
            'removeButtons' => 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe',
            'removePlugins' => 'elementspath',
            'resize_enabled' => false
        ],

        self::STANDART =>
        [
            'height' => 300,
            'extraPlugins'    	=> 'ckwebspeech,sourcedialog,codemirror,ajax,codesnippet,xml,widget,lineutils,dialog,dialogui',
            'toolbarGroups' => [
                ['name' => 'clipboard', 'groups' => ['mode','undo', 'selection', 'clipboard','doctools']],
                ['name' => 'editing', 'groups' => ['tools', 'about']],
                '/',
                ['name' => 'paragraph', 'groups' => ['templates', 'list', 'indent', 'align']],
                ['name' => 'insert'],
                '/',
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                ['name' => 'colors'],
                ['name' => 'links'],
                ['name' => 'others'],
            ],
            'removeButtons' => 'Smiley,Iframe'
        ],

        self::FULL =>
        [
            'height'            => 400,
            //'skin'              => 'moonocolor',
            'allowedContent'    => true,
            'extraPlugins'    	=> 'ckwebspeech,sourcedialog,codemirror,ajax,codesnippet,xml,widget,lineutils,dialog,dialogui',
            //'extraPlugins'    	=> 'youtube',
            //'indentClasses'     => ['ul-grey', 'ul-red', 'text-red', 'ul-content-red', 'circle', 'style-none', 'decimal', 'paragraph-portfolio-top', 'ul-portfolio-top', 'url-portfolio-top', 'text-grey'],
            'toolbar' => [
                ['name' => 'document', 'groups' => ['mode', 'document', 'doctools'], 'items' => ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']],
                ['name' => 'clipboard', 'groups' => ['clipboard', 'undo'], 'items' => ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']],
                ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker'], 'items' => ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']],
                ['name' => 'forms', 'items' => ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']],
                '/',
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup'], 'items' => ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']],
                ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi'], 'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']],
                ['name' => 'links', 'items' => ['Link', 'Unlink', 'Anchor']],
                ['name' => 'insert', 'items' => ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']],
                '/',
                ['name' => 'styles', 'items' => ['Styles', 'Format', 'Font', 'FontSize']],
                ['name' => 'colors', 'items' => ['TextColor', 'BGColor']],
                ['name' => 'tools', 'items' => ['Maximize', 'ShowBlocks']],
                ['name' => 'others', 'items' => ['-']],
                ['name' => 'about', 'items' => ['About']],
            ],
            'toolbarGroups' => [
                ['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
                ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
                ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker']],
                ['name' => 'forms'],
                '/',
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi']],
                ['name' => 'links'],
                ['name' => 'insert'],
                '/',
                ['name' => 'styles'],
                ['name' => 'colors'],
                ['name' => 'tools'],
                ['name' => 'others'],
                ['name' => 'about'],
            ],
            'removeButtons' => 'Smiley',
        ],

        self::EXTRA =>
        [
            'height'            => 400,
            //'skin'              => 'moonocolor',
            'allowedContent'    => true,
            'extraPlugins'    	=> 'ckwebspeech,youtube,doksoft_stat,sourcedialog,codemirror,ajax,codesnippet,xml,widget,lineutils,dialog,dialogui',
            //'indentClasses'     => ['ul-grey', 'ul-red', 'text-red', 'ul-content-red', 'circle', 'style-none', 'decimal', 'paragraph-portfolio-top', 'ul-portfolio-top', 'url-portfolio-top', 'text-grey'],
            'toolbar' => [
                ['name' => 'document', 'groups' => ['mode', 'document', 'doctools'], 'items' => ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']],
                ['name' => 'clipboard', 'groups' => ['clipboard', 'undo'], 'items' => ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']],
                ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker'], 'items' => ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']],
                ['name' => 'forms', 'items' => ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']],
                '/',
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup'], 'items' => ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']],
                ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi'], 'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']],
                ['name' => 'links', 'items' => ['Link', 'Unlink', 'Anchor']],
                ['name' => 'insert', 'items' => ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']],
                '/',
                ['name' => 'styles', 'items' => ['Styles', 'Format', 'Font', 'FontSize']],
                ['name' => 'colors', 'items' => ['TextColor', 'BGColor']],
                ['name' => 'tools', 'items' => ['Maximize', 'ShowBlocks']],
                ['name' => 'others', 'items' => ['-']],
                ['name' => 'about', 'items' => ['About']],
                ['name' => 'extra', 'items' => ['Youtube', /*'pbckcode',*/ 'CodeSnippet']],
                ['name' => 'ckwebspeech', 'items' => ['webSpeechEnabled', 'webSpeechSettings']],
            ],
            'toolbarGroups' => [
                ['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
                ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
                ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker']],
                ['name' => 'forms'],
                '/',
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi']],
                ['name' => 'links'],
                ['name' => 'insert'],
                '/',
                ['name' => 'styles'],
                ['name' => 'colors'],
                ['name' => 'tools'],
                ['name' => 'others'],
                ['name' => 'about'],
                ['name' => 'extra'],
                ['name' => 'ckwebspeech'],
            ],
        ],

    ];

    /**
     * Get settings by name
     *
     * @param string $name
     * @return array
     */
    static public function getPresets($name = self::FULL)
    {
        if ($presets = ArrayHelper::getValue(self::$presets, $name))
        {
            return (array) $presets;
        }

        return [];
    }
}