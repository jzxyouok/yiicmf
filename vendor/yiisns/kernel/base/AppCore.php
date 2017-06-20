<?php
namespace yiisns\kernel\base;

use yiisns\apps\helpers\FileHelper;
use yiisns\kernel\models\Lang;

use yiisns\kernel\relatedProperties\userPropertyTypes\UserPropertyTypeSelectFile;
use yiisns\kernel\relatedProperties\userPropertyTypes\UserPropertyTypeColor;
use yiisns\kernel\relatedProperties\userPropertyTypes\UserPropertyTypeComboText;
use yiisns\kernel\relatedProperties\userPropertyTypes\UserPropertyTypeDate;
use yiisns\kernel\relatedProperties\propertyTypes\PropertyTypeElement;
use yiisns\kernel\relatedProperties\propertyTypes\PropertyTypeTree;
use yiisns\kernel\relatedProperties\propertyTypes\PropertyTypeFile;
use yiisns\kernel\relatedProperties\propertyTypes\PropertyTypeList;
use yiisns\kernel\relatedProperties\propertyTypes\PropertyTypeText;
use yiisns\kernel\relatedProperties\propertyTypes\PropertyTypeNumber;

use yii\base\Component as YiiComponent;
use yii\helpers\ArrayHelper;
/**
 * @property PropertyType[] $relatedHandlers
 * @property array $relatedHandlersDataForSelect
 *
 */

class AppCore extends YiiComponent
{
    const BOOL_Y = 'Y';
    const BOOL_N = 'N';
    
    public function init()
    {
        if (\Yii::$app instanceof Application) {} else {
            $this->relatedHandlers = ArrayHelper::merge([
                PropertyTypeText::className() => [
                    'class' => PropertyTypeText::className()
                ],
                PropertyTypeNumber::className() => [
                    'class' => PropertyTypeNumber::className()
                ],
                PropertyTypeList::className() => [
                    'class' => PropertyTypeList::className()
                ],
                PropertyTypeFile::className() => [
                    'class' => PropertyTypeFile::className()
                ],
                PropertyTypeTree::className() => [
                    'class' => PropertyTypeTree::className()
                ],
                PropertyTypeElement::className() => [
                    'class' => PropertyTypeElement::className()
                ],
        
                UserPropertyTypeDate::className() => [
                    'class' => UserPropertyTypeDate::className()
                ],
                UserPropertyTypeComboText::className() => [
                    'class' => UserPropertyTypeComboText::className()
                ],
                UserPropertyTypeColor::className() => [
                    'class' => UserPropertyTypeColor::className()
                ],
                UserPropertyTypeSelectFile::className() => [
                    'class' => UserPropertyTypeSelectFile::className()
                ]
            ], $this->relatedHandlers);
        }
    }
    
    /**
     *
     * @return array
     */
    public function getRelatedHandlersDataForSelect()
    {
        $baseTypes = [];
        $userTypes = [];
        if ($this->relatedHandlers) {
            foreach ($this->relatedHandlers as $id => $handler) {
                if ($handler instanceof PropertyTypeText || $handler instanceof PropertyTypeNumber || $handler instanceof PropertyTypeList || $handler instanceof PropertyTypeFile || $handler instanceof PropertyTypeTree || $handler instanceof PropertyTypeElement) {
                    $baseTypes[$handler->id] = $handler->name;
                } else {
                    $userTypes[$handler->id] = $handler->name;
                }
            }
        }
    
        return [
            \Yii::t('yiisns/kernel', 'Base types') => $baseTypes,
            \Yii::t('yiisns/kernel', 'Custom types') => $userTypes
        ];
    }
    
    private $_relatedHandlers = [];
    
    /**
     *
     * @param array $handlers list of handlers
    */
    public function setRelatedHandlers(array $handlers)
    {
        $this->_relatedHandlers = $handlers;
    }
    
    /**
     *
     * @return PropertyType[] list of handlers.
     */
    public function getRelatedHandlers()
    {
        $handlers = [];
        foreach ($this->_relatedHandlers as $id => $handler) {
            $handlers[$id] = $this->getRelatedHandler($id);
        }
    
        return $handlers;
    }
    
    /**
     *
     * @param string $id service id.
     * @return PropertyType auth client instance.
     * @throws InvalidParamException on non existing client request.
     */
    public function getRelatedHandler($id)
    {
        if (! array_key_exists($id, $this->_relatedHandlers)) {
            throw new InvalidParamException("Unknown auth property type '{$id}'.");
        }
        if (! is_object($this->_relatedHandlers[$id])) {
            $this->_relatedHandlers[$id] = $this->createRelatedHandler($id, $this->_relatedHandlers[$id]);
        }
    
        return $this->_relatedHandlers[$id];
    }
    
    /**
     * Checks if client exists in the hub.
     *
     * @param string $id
     *            client id.
     * @return boolean whether client exist.
     */
    public function hasRelatedHandler($id)
    {
        return array_key_exists($id, $this->_relatedHandlers);
    }
    
    /**
     * Creates auth client instance from its array configuration.
     *
     * @param string $id auth client id.
     * @param array $config auth client instance configuration.
     * @return PropertyType auth client instance.
     */
    protected function createRelatedHandler($id, $config)
    {
        $config['id'] = $id;
    
        return \Yii::createObject($config);
    }
    
    /**
     * @return array
     */
    public function booleanFormat()
    {
        return [
            self::BOOL_Y => \Yii::t('yii', 'Yes', [], \Yii::$app->formatter->locale),
            self::BOOL_N => \Yii::t('yii', 'No', [], \Yii::$app->formatter->locale)
        ];
    }
    
    /**
     * @var array
     */
    public $tmpFolderScheme = [
        'runtime' => [
            '@application/runtime',
            '@console/runtime'
        ],
    
        'assets' => [
            '@application/web/assets'
        ]
    ];
    
    /**
     * @return bool
     */
    public function generateTmpConfig()
    {
        $configs = FileHelper::findExtensionsFiles([
            '/config/main.php'
        ]);
        $configs = array_unique(array_merge([
            \Yii::getAlias('@yiisns/apps/config/main.php')
        ], $configs));
    
        $result = [];
        foreach ($configs as $filePath) {
            $fileData = (array) include $filePath;
            $result = \yii\helpers\ArrayHelper::merge($result, $fileData);
        }
    
        if (! file_exists(dirname(TMP_CONFIG_FILE_EXTENSIONS))) {
            mkdir(dirname(TMP_CONFIG_FILE_EXTENSIONS), 0777, true);
        }
    
        $string = var_export($result, true);
        file_put_contents(TMP_CONFIG_FILE_EXTENSIONS, "<?php\n\nreturn $string;\n");
    
        // invalidate opcache of extensions.php if exists
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate(TMP_CONFIG_FILE_EXTENSIONS, true);
        }
    
        return file_exists(TMP_CONFIG_FILE_EXTENSIONS);
    }
    
    /**
     * @return bool
     */
    public function generateTmpConsoleConfig()
    {
        $configs = FileHelper::findExtensionsFiles([
            '/config/main-console.php'
        ]);
        $configs = array_unique(array_merge([
            \Yii::getAlias('@yiisns/apps/config/main-console.php')
        ], $configs));
    
        $result = [];
        foreach ($configs as $filePath) {
            $fileData = (array) include $filePath;
    
            $result = \yii\helpers\ArrayHelper::merge($result, $fileData);
        }
    
        if (! file_exists(dirname(TMP_CONSOLE_CONFIG_FILE_EXTENSIONS))) {
            mkdir(dirname(TMP_CONSOLE_CONFIG_FILE_EXTENSIONS), 0777, true);
        }
    
        $string = var_export($result, true);
        file_put_contents(TMP_CONSOLE_CONFIG_FILE_EXTENSIONS, "<?php\n\nreturn $string;\n");
    
        // invalidate opcache of extensions.php if exists
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate(TMP_CONSOLE_CONFIG_FILE_EXTENSIONS, true);
        }
    
        return file_exists(TMP_CONSOLE_CONFIG_FILE_EXTENSIONS);
    } 
    
    /**
     * @return array|null|\yii\db\ActiveRecord Interface language
     */
    public function getLanguage()
    {
        return Lang::find()->where(['code' => \Yii::$app->language])->one();
    }
}