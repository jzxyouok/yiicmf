<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.11.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models;

use Yii;
use yii\helpers\ArrayHelper;
use yiisns\kernel\base\AppCore;
use yiisns\kernel\validators\CodeValidator;

/**
 * This is the model class for table "{{%content}}".
 *
 * @property string $name
 * @property string $code
 * @property string $active
 * @property integer $priority
 * @property string $description
 * @property string $content_type
 * @property string $index_for_search
 * @property string $tree_chooser
 * @property string $list_mode
 * @property string $name_meny
 * @property string $name_one
 * @property integer $default_tree_id
 * @property string $is_allow_change_tree
 * @property integer $root_tree_id
 * @property string $viewFile
 * @property string $access_check_element
 * @property string $meta_title_template
 * @property string $meta_description_template
 * @property string $meta_keywords_template
 * @property integer $parent_content_id
 * @property string $visible
 * @property string $parent_content_on_delete
 * @property string $parent_content_is_required
 * @property string $adminPermissionName
 * @property Tree $rootTree
 * @property Tree $defaultTree
 * @property ContentType $contentType
 * @property ContentElement[] $contentElements
 * @property ContentProperty[] $contentProperties
 * @property Content $parentContent
 * @property Content[] $childrenContents
 * 
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Content extends Core
{
    const CASCADE = 'CASCADE';

    const RESTRICT = 'RESTRICT';

    const SET_NULL = 'SET_NULL';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content}}';
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'created_by' => \Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => \Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'name' => \Yii::t('yiisns/kernel', 'Name'),
            'code' => \Yii::t('yiisns/kernel', 'Code'),
            'active' => \Yii::t('yiisns/kernel', 'Active'),
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
            'description' => \Yii::t('yiisns/kernel', 'Description'),
            'content_type' => \Yii::t('yiisns/kernel', 'Content Type'),
            'index_for_search' => \Yii::t('yiisns/kernel', 'To index for search module'),
            'tree_chooser' => \Yii::t('yiisns/kernel', 'The Interface Binding Element to Sections'),
            'list_mode' => \Yii::t('yiisns/kernel', 'View Mode Sections And Elements'),
            'name_meny' => \Yii::t('yiisns/kernel', 'The Name Of The Elements (Plural)'),
            'name_one' => \Yii::t('yiisns/kernel', 'The Name One Element'),
            'default_tree_id' => \Yii::t('yiisns/kernel', 'Default Section'),
            'is_allow_change_tree' => \Yii::t('yiisns/kernel', 'Is Allow Change Default Section'),
            'root_tree_id' => \Yii::t('yiisns/kernel', 'Root Section'),
            'viewFile' => \Yii::t('yiisns/kernel', 'Template'),
            'meta_title_template' => \Yii::t('yiisns/kernel', 'Meta Title Template'),
            'meta_description_template' => \Yii::t('yiisns/kernel', 'Meta Description Template'),
            'meta_keywords_template' => \Yii::t('yiisns/kernel', 'Meta Keywords Template'),
            'access_check_element' => \Yii::t('yiisns/kernel', 'Enable access control for element'),
            'parent_content_id' => \Yii::t('yiisns/kernel', 'Parent content'),
            'visible' => \Yii::t('yiisns/kernel', 'Show in menu'),
            'parent_content_on_delete' => \Yii::t('yiisns/kernel', 'At the time of removal of the parent element'),
            'parent_content_is_required' => \Yii::t('yiisns/kernel', 'Parent element is required to be filled')
        ]);
    }
    
    /**
     *
     * @return array
     */
    static public function getOnDeleteOptions()
    {
        return [
            self::CASCADE => "CASCADE (" . \Yii::t('yiisns/kernel', 'Remove all items of that content') . ")",
            self::RESTRICT => "RESTRICT (" . \Yii::t('yiisns/kernel', 'Deny delete parent is not removed, these elements') . ")",
            self::SET_NULL => "SET NULL (" . \Yii::t('yiisns/kernel', 'Remove the connection to a remote parent') . ")"
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'priority', 'default_tree_id', 'root_tree_id' ], 'integer'],
            [['name', 'content_type'], 'required'],
            [['description'], 'string'],
            [['meta_title_template'], 'string'],
            [['meta_description_template'], 'string'],
            [['meta_keywords_template'], 'string'],
            [['name', 'viewFile'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 50],
            [['code' ], 'unique'],
            [['access_check_element'], 'string'],
            [['code' ], CodeValidator::className()],
            [['active', 'index_for_search', 'tree_chooser', 'list_mode', 'is_allow_change_tree'], 'string', 'max' => 1],
            [['content_type'], 'string', 'max' => 32],
            [['name_meny', 'name_one'], 'string', 'max' => 100],
            ['priority', 'default', 'value' => 500],
            ['active', 'default', 'value' => AppCore::BOOL_Y],
            ['is_allow_change_tree', 'default', 'value' => AppCore::BOOL_Y],
            ['access_check_element', 'default','value' => AppCore::BOOL_N],
            ['name_meny', 'default', 'value' => \Yii::t('yiisns/kernel', 'Elements')],
            ['name_one', 'default','value' => \Yii::t('yiisns/kernel', 'Element')],
            ['visible', 'default', 'value' => AppCore::BOOL_Y],
            ['parent_content_is_required', 'default', 'value' => AppCore::BOOL_Y],
            ['parent_content_on_delete', 'default', 'value' => self::CASCADE],
            ['parent_content_id', 'integer'],
            ['code', 'default', 'value' => function ($model, $attribute) {
                    return 'auto_' . md5(rand(1, 10) . time());
                }
            ]
        ]);
    }

    protected static $_selectData = [];

    /**
     *
     * @param bool|false $refetch            
     * @return array
     */
    static public function getDataForSelect($refetch = false, $contentQueryCallback = null)
    {
        if ($refetch === false && static::$_selectData) {
            return static::$_selectData;
        }
        
        static::$_selectData = [];
        
        if ($appContentTypes = ContentType::find()->orderBy('priority ASC')->all()) {
            /**
             *
             * @var $appContentType ContentType
             */
            foreach ($appContentTypes as $appContentType) {
                $query = $appContentType->getContents();
                if ($contentQueryCallback && is_callable($contentQueryCallback)) {
                    $contentQueryCallback($query);
                }
                
                static::$_selectData[$appContentType->name] = ArrayHelper::map($query->all(), 'id', 'name');
            }
        }
        
        return static::$_selectData;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRootTree()
    {
        return $this->hasOne(Tree::className(), [
            'id' => 'root_tree_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultTree()
    {
        return $this->hasOne(Tree::className(), [
            'id' => 'default_tree_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentType()
    {
        return $this->hasOne(ContentType::className(), [
            'code' => 'content_type'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentElements()
    {
        return $this->hasMany(ContentElement::className(), [
            'content_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentProperties()
    {
        return $this->hasMany(ContentProperty::className(), [
            'content_id' => 'id'
        ])->orderBy([
            'priority' => SORT_ASC
        ]);
    }

    /**
     *
     * @return string
     */
    public function getAdminPermissionName()
    {
        return 'admin/admin-content-element__' . $this->id;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentContent()
    {
        return $this->hasOne(Content::className(), [
            'id' => 'parent_content_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildrenContents()
    {
        return $this->hasMany(Content::className(), [
            'parent_content_id' => 'id'
        ]);
    }

    /**
     *
     * @return ContentElement
     */
    public function createElement()
    {
        return new ContentElement([
            'content_id' => $this->id
        ]);
    }
}