CKEditor Widget for Yii2
========================

Renders a [CKEditor WYSIWYG text editor plugin](http://www.ckeditor.com) widget.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "yii/yii2-ckeditor" "*"
```
or add

```json
"yii/yii2-ckeditor" : "*"
```

to the require section of your application's `composer.json` file.

Skins & Plugins
---------------

This widget works with default's `dev-full/stable` branch of CKEditor, with a set of plugins and skins. If you wish to
configure a different skins or plugins that the one proposed, you will have to download them separately and configure
the widget's `clientOptions` attribute accordingly.


Usage
-----
The library comes with two widgets: `CKEditor` and `CKEditorInline`. One is for classic edition and the other for inline
editing respectively.

Using a model with a basic preset:

```

use yii\ckeditor\CKEditorWidget;
use yii\ckeditor\CKEditorPresets;

<?= $form->field($model, 'text')->widget(CKEditorWidget::className(), [
	'preset' => CKEditorPresets::BASIC
]) ?>
```

```
<?= $form->field($model, 'text')->widget(CKEditorWidget::className(), [
	'options' => ['rows' => 6],
	'preset' => CKEditorPresets::FULL
]) ?>
```

```
<?= $form->field($model, 'description_short')->widget(
	\yiisns\kernel\widgets\formInputs\ckeditor\Ckeditor::className(),
	[
		'preset' => \yii\ckeditor\CKEditorPresets::CLEAN,
		'clientOptions' =>
		[
			'height' => 200,
			'extraPlugins'    	=> 'ckwebspeech,sourcedialog,codemirror,ajax,codesnippet,xml,widget,lineutils,dialog,dialogui',
			'toolbarGroups' => [
				['name' => 'undo'],
				['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
				['name' => 'colors'],
				['name' => 'links', 'groups' => ['links']],
				['name' => 'others','groups' => ['others', 'about']],
			],
			'removeButtons' => 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe',
			'removePlugins' => 'elementspath',
			'resize_enabled' => true
		]
	]
); 
?>
```