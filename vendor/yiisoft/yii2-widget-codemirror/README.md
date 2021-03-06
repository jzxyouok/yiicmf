Codemirror widget for Yii2 framework
=================

## Description

CodeMirror is a versatile text editor implemented in JavaScript for the browser. It is specialized for editing code, and comes with a number of language modes and addons that implement more advanced editing functionality.
For more information please visit [CodeMirror](http://codemirror.net/) 

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). 

To install, either run

```
$ php composer.phar require yii/yii2-widget-codemirror "*"
```
or add

```
"yii/yii2-widget-codemirror": "*"
```

to the ```require``` section of your `composer.json` file.

## Usage

```php
use yii\widget\codemirror\CodemirrorWidget;

$form->field($model, 'code')->widget(
    CodemirrorWidget::className(),
    [
        'preset'=>'php',
        'options'=>['rows' => 20],
    ]
);
```

You can use ready-made presets, or create your own. To do this, specify the folder to your presets.

```php
use yii\widget\codemirror\CodemirrorWidget;

$form->field($model, 'code')->widget(
    CodemirrorWidget::className(),
    [
        'presetDir'=>'/path_to_your_presets',
        'preset'=>'sql',
    ]
);
```

In general, you can customize the widget directly specifying its properties.

```php
use yii\widget\codemirror\CodemirrorWidget;
use yii\widget\codemirror\CodemirrorAsset;

$form->field($model, 'code')->widget(
    CodemirrorWidget::className(),
    [
        'assets'=>[
            CodemirrorAsset::MODE_CLIKE,
            CodemirrorAsset::KEYMAP_EMACS,
            CodemirrorAsset::ADDON_EDIT_MATCHBRACKETS,
            CodemirrorAsset::ADDON_COMMENT,
            CodemirrorAsset::ADDON_DIALOG,
            CodemirrorAsset::ADDON_SEARCHCURSOR,
            CodemirrorAsset::ADDON_SEARCH,
        ],
        'settings'=>[
            'lineNumbers' => true,
            'mode' => 'text/x-csrc',
            'keyMap' => 'emacs'
        ],
    ]
);
```

## License

**conquer/codemirror** is released under the MIT License. See the bundled `LICENSE.md` for details.
