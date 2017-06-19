A Javascript plugin for cross-browser Ajax file uploading. Supports multiple file uploading with progress bars.
===============================================================================================================
Javascript plugin for cross-browser Ajax file uploading with progress bar support. Works in all major browsers, including IE7+, Chrome, Firefox, Safari, and Opera. No dependencies - use it with or without jQuery.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).
Full api https://www.lpology.com/code/ajaxuploader/docs.php
Either run

```
php composer.phar require --prefer-dist yii/yii2-widget-simpleajaxloader "*"
```

or add

```
"yii/yii2-widget-simpleajaxloader": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by :

```
<?php
namespace bla\bla;

use yii\widget\simpleajaxuploader\Widget;

echo Widget::widget({
      "clientOptions" =>
      [
          "name" => ""
      ]
 });
?>
```