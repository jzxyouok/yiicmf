<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.05.2016
 */

namespace yiisns\kernel\models;

use Imagine\Image\ManipulatorInterface;
use yiisns\apps\base\Widget;
use yiisns\kernel\base\AppCore;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\behaviors\HasRelatedPropertiesBehavior;
use yiisns\kernel\models\behaviors\HasStorageFileBehavior;
use yiisns\kernel\models\behaviors\HasStorageFileMultiBehavior;
use yiisns\kernel\models\behaviors\HasTreesBehavior;
use yiisns\kernel\models\behaviors\SeoPageNameBehavior;
use yiisns\kernel\models\behaviors\TimestampPublishedBehavior;
use yiisns\kernel\models\behaviors\traits\HasRelatedPropertiesTrait;
use yiisns\kernel\models\behaviors\traits\HasTreesTrait;
use yiisns\kernel\models\behaviors\traits\HasUrlTrait;
use yiisns\kernel\relatedProperties\models\RelatedElementModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\ErrorHandler;

/**
 * This is the model class for table "{{%content_element}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published_at
 * @property integer $published_to
 * @property integer $priority
 * @property string $active
 * @property string $name
 * @property string $code
 * @property string $description_short
 * @property string $description_full
 * @property integer $content_id
 * @property integer $image_id
 * @property integer $image_full_id
 * @property integer $tree_id
 * @property integer $show_counter
 * @property integer $show_counter_start
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property integer $parent_content_element_id version > 2.4.8
 *
 *
 * @property string $permissionName
 *
 * @property string $description_short_type
 * @property string $description_full_type
 *
 * @property string $absoluteUrl
 * @property string $url
 *
 * @property Content $Content
 * @property Tree $tree

 * @property ContentElementProperty[]    $relatedElementProperties
 * @property ContentProperty[]           $relatedProperties
 * @property ContentElementTree[]        $contentElementTrees
 * @property ContentElementProperty[]    $contentElementProperties
 * @property ContentProperty[]           $contentProperties
 *
 * @property StorageFile $image
 * @property StorageFile $fullImage
 *
 * @property ContentElementFile[] $contentElementFiles
 * @property ContentElementImage[] $contentElementImages
 *
 * @property StorageFile[] $files
 * @property StorageFile[] $images
 *
 * @property ContentElement $parentContentElement
 * @property ContentElement[] $childrenContentElements
 *
 * @property ContentElement2cmsUser[] $contentElement2cmsUsers
 * @property User[] $usersToFavorites
 *
 */
class ContentElement extends RelatedElementModel
{
    use HasRelatedPropertiesTrait;
    use HasTreesTrait;
    use HasUrlTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_element}}';
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_DELETE, [$this, '_beforeDeleteE']);
        $this->on(self::EVENT_AFTER_DELETE, [$this, '_afterDeleteE']);
    }

    public function _beforeDeleteE($e)
    {
        //TODO: Upgrade this
        if ($this->childrenContentElements)
        {
            foreach ($this->childrenContentElements as $childrenElement)
            {
                $childrenElement->delete();
            }
        }
    }

    public function _afterDeleteE($e)
    {
        if ($permission = \Yii::$app->authManager->getPermission($this->permissionName))
        {
            \Yii::$app->authManager->remove($permission);
        }
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampPublishedBehavior::className() => TimestampPublishedBehavior::className(),

            HasStorageFileBehavior::className() =>
            [
                'class'     => HasStorageFileBehavior::className(),
                'fields'    => ['image_id', 'image_full_id']
            ],
            HasStorageFileMultiBehavior::className() =>
            [
                'class'     => HasStorageFileMultiBehavior::className(),
                'relations'    => ['images', 'files']
            ],

            HasRelatedPropertiesBehavior::className() =>
            [
                'class'                             => HasRelatedPropertiesBehavior::className(),
                'relatedElementPropertyClassName'   => ContentElementProperty::className(),
                'relatedPropertyClassName'          => ContentProperty::className(),
            ],

            HasTreesBehavior::className() =>
            [
                'class'                             => HasTreesBehavior::className(),
            ],

            SeoPageNameBehavior::className() =>
            [
                'class'                             => SeoPageNameBehavior::className(),
                'generatedAttribute'                => 'code',
                'maxLength'                         => \Yii::$app->appSettings->element_max_code_length,
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('yiisns/kernel', 'ID'),
            'created_by' => Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => Yii::t('yiisns/kernel', 'Updated At'),
            'published_at' => Yii::t('yiisns/kernel', 'Published At'),
            'published_to' => Yii::t('yiisns/kernel', 'Published To'),
            'priority' => Yii::t('yiisns/kernel', 'Priority'),
            'active' => Yii::t('yiisns/kernel', 'Active'),
            'name' => Yii::t('yiisns/kernel', 'Name'),
            'code' => Yii::t('yiisns/kernel', 'Code'),
            'description_short' => Yii::t('yiisns/kernel', 'Description Short'),
            'description_full' => Yii::t('yiisns/kernel', 'Description Full'),
            'content_id' => Yii::t('yiisns/kernel', 'Content'),
            'tree_id' => Yii::t('yiisns/kernel', 'The main section'),
            'show_counter' => Yii::t('yiisns/kernel', 'Show Counter'),
            'show_counter_start' => Yii::t('yiisns/kernel', 'Show Counter Start'),
            'meta_title' => Yii::t('yiisns/kernel', 'Meta Title'),
            'meta_keywords' => Yii::t('yiisns/kernel', 'Meta Keywords'),
            'meta_description' => Yii::t('yiisns/kernel', 'Meta Description'),
            'description_short_type' => Yii::t('yiisns/kernel', 'Description Short Type'),
            'description_full_type' => Yii::t('yiisns/kernel', 'Description Full Type'),
            'image_id' => Yii::t('yiisns/kernel', 'Main Image (announcement)'),
            'image_full_id' => Yii::t('yiisns/kernel', 'Main Image'),

            'images' => Yii::t('yiisns/kernel', 'Images'),
            'files' => Yii::t('yiisns/kernel', 'Files'),
            'treeIds' => Yii::t('yiisns/kernel', 'Additional sections'),
            'parent_content_element_id' => Yii::t('yiisns/kernel', 'Parent element'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'treeIds' => Yii::t('yiisns/kernel', 'You can specify some additional sections that will show your records.'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'published_at', 'published_to', 'priority', 'content_id', 'tree_id', 'show_counter', 'show_counter_start'], 'integer'],
            [['name'], 'required'],
            [['description_short', 'description_full'], 'string'],
            [['active'], 'string', 'max' => 1],
            [['name', 'code'], 'string', 'max' => 255],
            [['content_id', 'code'], 'unique', 'targetAttribute' => ['content_id', 'code'], 'message' => \Yii::t('yiisns/kernel','For the content of this code is already in use.')],
            [['tree_id', 'code'], 'unique', 'targetAttribute' => ['tree_id', 'code'], 'message' => \Yii::t('yiisns/kernel','For this section of the code is already in use.')],
            [['treeIds'], 'safe'],
            ['priority', 'default', 'value' => 500],
            ['active', 'default', 'value' => AppCore::BOOL_Y],
            [['meta_title', 'meta_description', 'meta_keywords'], 'string'],
            [['meta_title'], 'string', 'max' => 500],

            ['description_short_type', 'string'],
            ['description_full_type', 'string'],
            ['description_short_type', 'default', 'value' => "text"],
            ['description_full_type', 'default', 'value' => "text"],
            ['tree_id', 'default', 'value' => function()
            {
                if ($this->content->defaultTree)
                {
                    return $this->content->defaultTree->id;
                }
            }],

            [['image_id', 'image_full_id'], 'safe'],

            ['parent_content_element_id', 'integer'],
            ['parent_content_element_id', 'validateParentContentElement'],
            ['parent_content_element_id', 'required', 'when' => function(ContentElement $model) {

                if ($model->content && $model->content->parentContent)
                {
                    return (bool) ($model->content->parent_content_is_required == "Y");
                }

                return false;
            }, 'whenClient' => "function (attribute, value) {
                return $('#content-parent_content_is_required').val() == 'Y';
            }"]

        ]);
    }

    /*public function fields()
    {
        return array_merge(parent::fields(), [
            'url'           => 'url',
            'absoluteUrl'   => 'absoluteUrl',
        ]);
    }*/

    /*public function extraFields()
    {
        return array_merge(parent::extraFields(), [
            'relatedPropertiesModel' => 'relatedPropertiesModel',
        ]);
    }*/

    /**
     *
     * @param $attribute
     * @return bool
     */
    public function validateParentContentElement($attribute)
    {
        if (!$this->content)
        {
            return false;
        }

        if (!$this->content->parentContent)
        {
            return false;
        }

        if ($this->$attribute)
        {
            $contentElement = static::findOne($this->$attribute);
            if ($contentElement->content->id != $this->content->parentContent->id)
            {
                $this->addError($attribute, \Yii::t('yiisns/kernel', 'The parent must be a content element: «{contentName}».',['contentName' => $this->content->parentContent->name]));
            }
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTree()
    {
        return $this->hasOne(Tree::className(), ['id' => 'tree_id']);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedProperties()
    {
        return $this->hasMany(ContentProperty::className(), ['content_id' => 'id'])
                    ->via('content')->orderBy(['priority' => SORT_ASC]);
        //return $this->content->contentProperties;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentElementTrees()
    {
        return $this->hasMany(ContentElementTree::className(), ['element_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentElementProperties()
    {
        return $this->hasMany(ContentElementProperty::className(), ['element_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentProperties()
    {
        return $this->hasMany(ContentProperty::className(), ['id' => 'property_id'])
                    ->via('contentElementProperties');
    }

    /**
     * @return string
     */
    public function getUrl($scheme = false, $params = [])
    {
        if ($params)
        {
            $params = ArrayHelper::merge(['/apps/content-element/view', 'model' => $this], $params);
        } else
        {
            $params = ['/apps/content-element/view', 'model' => $this];
        }

        return Url::to($params, $scheme);
    }

    /**
     * @return string
     */
    public function getAbsoluteUrl($scheme = false, $params = [])
    {
        return $this->getUrl(true, $params);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(StorageFile::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFullImage()
    {
        return $this->hasOne(StorageFile::className(), ['id' => 'image_full_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentElementFiles()
    {
        return $this->hasMany(ContentElementFile::className(), ['content_element_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentElementImages()
    {
        return $this->hasMany(ContentElementImage::className(), ['content_element_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(StorageFile::className(), ['id' => 'storage_file_id'])
            ->via('contentElementImages');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(StorageFile::className(), ['id' => 'storage_file_id'])
            ->via('contentElementFiles');
    }

    /**
     * @return string
     */
    public function getPermissionName()
    {
        return 'apps/content-element__' . $this->id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentContentElement()
    {
        return $this->hasOne(static::className(), ['id' => 'parent_content_element_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildrenContentElements()
    {
        return $this->hasMany(static::className(), ['parent_content_element_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentElement2cmsUsers()
    {
        return $this->hasMany(ContentElement2cmsUser::className(), ['content_element_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersToFavorites()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->via('contentElement2cmsUsers');
    }
}