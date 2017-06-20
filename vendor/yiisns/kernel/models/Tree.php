<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.10.2016
 * @since 1.0.0
 */

namespace yiisns\kernel\models;

use yiisns\kernel\base\AppCore;
use yiisns\sx\filters\string\SeoPageName as FilterSeoPageName;
use Imagine\Image\ManipulatorInterface;
use yiisns\kernel\models\behaviors\traits\HasRelatedPropertiesTrait;
use yiisns\kernel\models\behaviors\traits\HasUrlTrait;
use yiisns\kernel\models\behaviors\traits\TreeBehaviorTrait;
use yiisns\kernel\models\behaviors\HasRelatedPropertiesBehavior;
use yiisns\kernel\models\behaviors\HasStorageFileBehavior;
use yiisns\kernel\models\behaviors\HasStorageFileMultiBehavior;
use yiisns\kernel\models\behaviors\HasTableCacheBehavior;
use yiisns\kernel\models\behaviors\ImplodeBehavior;

use yii\base\Event;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\AfterSaveEvent;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%tree}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $description_short
 * @property string $description_full
 * @property string $code
 * @property integer $pid
 * @property string $pids
 * @property integer $level
 * @property string $dir
 * @property integer $has_children
 * @property integer $priority
 * @property string $tree_type_id
 * @property integer $published_at
 * @property string $redirect
 * @property string $tree_menu_ids
 * @property string $active
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $site_code
 * @property string $description_short_type
 * @property string $description_full_type
 * @property integer $image_full_id
 * @property integer $image_id
 * @property integer $redirect_tree_id
 * @property integer $redirect_code
 * @property string $name_hidden
 *
 *
 * @property string $view_file
 *
 * @property string $absoluteUrl
 * @property string $url
 *
 * @property StorageFile $image
 * @property StorageFile $imageFull
 *
 * @property TreeFile[]  $treeFiles
 * @property TreeImage[] $treeImages
 * @property Tree        $redirectTree
 *
 * @property StorageFile[] $files
 * @property StorageFile[] $images
 *
 * @property ContentElement[]        $contentElements
 * @property ContentElementTree[]    $contentElementTrees
 * @property Site                    $site
 * @property Site                    $siteRelation
 * @property TreeType                $treeType
 * @property TreeProperty[]          $treeProperties
 *
 * @property Tree                       $parent
 * @property Tree[]                     $parents
 * @property Tree[]                     $children
 * @property Tree                       $root
 * @property Tree                       $prev
 * @property Tree                       $next
 * @property Tree                       $descendants
 */
class Tree extends Core
{
    use HasRelatedPropertiesTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tree}}';
    }

    const PRIORITY_STEP = 100;
    const PIDS_DELIMETR = '/';


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return ArrayHelper::merge(parent::behaviors(), [

            HasStorageFileBehavior::className() =>
            [
                'class'     => HasStorageFileBehavior::className(),
                'fields'    => ['image_id', 'image_full_id']
            ],

            HasStorageFileMultiBehavior::className() =>
            [
                'class'         => HasStorageFileMultiBehavior::className(),
                'relations'     => ['images', 'files']
            ],

            ImplodeBehavior::className() =>
            [
                'class' => ImplodeBehavior::className(),
                'fields' =>  [
                    "tree_menu_ids"
                ]
            ],

            'implode_tree' =>
            [
                'class' => ImplodeBehavior::className(),
                'fields' =>  ['pids'],
                'delimetr' => self::PIDS_DELIMETR,
            ],

            HasRelatedPropertiesBehavior::className() =>
            [
                'class' => HasRelatedPropertiesBehavior::className(),
                'relatedElementPropertyClassName'   => TreeProperty::className(),
                'relatedPropertyClassName'          => TreeTypeProperty::className(),
            ],
        ]);
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeSaveTree']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'beforeSaveTree']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'afterUpdateTree']);
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'beforeDeleteTree']);
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'afterDeleteTree']);
    }


    /**
     * @var if you have children you must first remove them all.
     * @param Event $event
     * @throws \Exception
     */
    public function beforeDeleteTree(Event $event)
    {
        if ($this->children)
        {
            foreach ($this->children as $childNode)
            {
                $childNode->delete();
            }
        }
    }

    /**
     * @param Event $event
     */
    public function afterDeleteTree(Event $event)
    {
        if ($this->parent)
        {
            $this->parent->processNormalize();
        }
    }

    /**
     * @param AfterSaveEvent $event
     */
    public function afterUpdateTree(AfterSaveEvent $event)
    {
        if ($event->changedAttributes)
        {
            if (isset($event->changedAttributes['code']))
            {
                $event->sender->processNormalize();
            }
        }
    }

    /**
     * @param $event
     */
    public function beforeSaveTree($event)
    {
        if (!$this->site_code)
        {
            if ($this->parent)
            {
                $this->site_code = $this->parent->site_code;
            }
        }

        if (!$this->tree_type_id)
        {
            if ($this->parent && $this->parent->treeType)
            {
                if ($this->parent->treeType->defaultChildrenTreeType)
                {
                    $this->tree_type_id = $this->parent->treeType->defaultChildrenTreeType->id;
                } else
                {
                    $this->tree_type_id = $this->parent->tree_type_id;
                }
            }
        }

        if (!$this->name)
        {
            $this->generateName();
        }

        if (!$this->code)
        {
            $this->generateCode();
        }
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
            'published_at' => \Yii::t('yiisns/kernel', 'Published At'),
            'published_to' => \Yii::t('yiisns/kernel', 'Published To'),
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
            'active' => \Yii::t('yiisns/kernel', 'Active'),
            'name' => \Yii::t('yiisns/kernel', 'Name'),
            'tree_type_id' => \Yii::t('yiisns/kernel', 'Type'),
            'redirect' => \Yii::t('yiisns/kernel', 'Redirect'),
            'tree_menu_ids' => \Yii::t('yiisns/kernel', 'Menu Positions'),
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
            'code' => \Yii::t('yiisns/kernel', 'Code'),
            'active' => \Yii::t('yiisns/kernel', 'Active'),
            'meta_title' => \Yii::t('yiisns/kernel', 'Meta Title'),
            'meta_keywords' => \Yii::t('yiisns/kernel', 'Meta Keywords'),
            'meta_description' => \Yii::t('yiisns/kernel', 'Meta Description'),
            'description_short' => \Yii::t('yiisns/kernel', 'Description Short'),
            'description_full' => \Yii::t('yiisns/kernel', 'Description Full'),
            'description_short_type' => \Yii::t('yiisns/kernel', 'Description Short Type'),
            'description_full_type' => \Yii::t('yiisns/kernel', 'Description Full Type'),
            'image_id' => \Yii::t('yiisns/kernel', 'Main Image (announcement)'),
            'image_full_id' => \Yii::t('yiisns/kernel', 'Main Image'),
            'images' => \Yii::t('yiisns/kernel', 'Images'),
            'files' => \Yii::t('yiisns/kernel', 'Files'),
            'redirect_tree_id' => \Yii::t('yiisns/kernel', 'Redirect Section'),
            'redirect_code' => \Yii::t('yiisns/kernel', 'Redirect Code'),
            'name_hidden' => \Yii::t('yiisns/kernel', 'Hidden Name'),
            'view_file' => \Yii::t('yiisns/kernel', 'Template'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['description_short', 'description_full'], 'string'],
            ['active', 'default', 'value' => AppCore::BOOL_Y],
            [['redirect_code'], 'default', 'value' => 301],
            [['redirect_code'], 'in', 'range' => [301, 302]],
            [['redirect'], 'string'],
            [['name_hidden'], 'string'],
            [['priority', 'tree_type_id', 'image_id', 'image_full_id', 'redirect_tree_id', 'redirect_code'], 'integer'],
            [['tree_menu_ids'], 'safe'],
            [['code'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 255],
            [['meta_title', 'meta_description', 'meta_keywords'], 'string'],
            [['meta_title'], 'string', 'max' => 500],
            [['site_code'], 'string', 'max' => 15],
            [['pid', 'code'], 'unique', 'targetAttribute' => ['pid', 'code'], 'message' => \Yii::t('yiisns/kernel', 'For this subsection of the code is already in use.')],
            [['pid', 'code'], 'unique', 'targetAttribute' => ['pid', 'code'], 'message' => \Yii::t('yiisns/kernel', 'The combination of Code and Pid has already been taken.')],
            ['description_short_type', 'string'],
            ['description_full_type', 'string'],
            ['description_short_type', 'default', 'value' => "text"],
            ['description_full_type', 'default', 'value' => "text"],
            ['view_file', 'string', 'max' => 128],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRedirectTree()
    {
        return $this->hasOne(Tree::className(), ['id' => 'redirect_tree_id']);
    }

    /**
     * @return ActiveQuery
     */
	static public function findRoots()
	{
		return static::find()->where(['level' => 0])->orderBy(['priority' => SORT_ASC]);
	}

    /**
     * @return string
     */
    public function getUrl($scheme = false, $params = [])
    {
        if ($params)
        {
            $params = ArrayHelper::merge(['/apps/tree/view', 'model' => $this], $params);
        } else
        {
            $params = ['/apps/tree/view', 'model' => $this];
        }

        return Url::to(['/apps/tree/view', 'model' => $this], $scheme);
    }

    /**
     * @return string
     */
    public function getAbsoluteUrl($params = [])
    {
        return $this->getUrl(true, $params);
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        //return $this->hasOne(Site::className(), ['code' => 'site_code']);
        return Site::getByCode($this->site_code);
    }

    /**
     * @return ActiveQuery
     */
    public function getSiteRelation()
    {
        return $this->hasOne(Site::className(), ['code' => 'site_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentElements()
    {
        return $this->hasMany(ContentElement::className(), ['tree_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentElementTrees()
    {
        return $this->hasMany(ContentElementTree::className(), ['tree_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeProperties()
    {
        return $this->hasMany(TreeProperty::className(), ['element_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeType()
    {
        return $this->hasOne(TreeType::className(), ['id' => 'tree_type_id']);
    }


    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    /*public function getRelatedProperties()
    {
        return $this->treeType->treeTypeProperties;
    }*/

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getRelatedProperties()
    {
        return $this->hasMany(TreeTypeProperty::className(), ['tree_type_id' => 'id'])
                    ->via('treeType')->orderBy(['priority' => SORT_ASC]);
        //return $this->content->contentProperties;
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
    public function getImages()
    {
        return $this->hasMany(StorageFile::className(), ['id' => 'storage_file_id'])
            ->via('treeImages');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(StorageFile::className(), ['id' => 'storage_file_id'])
            ->via('treeFiles');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeFiles()
    {
        return $this->hasMany(TreeFile::className(), ['tree_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeImages()
    {
        return $this->hasMany(TreeImage::className(), ['tree_id' => 'id']);
    }

    /**
     * @param null $depth
     * @return array
     */
    public function getParentsIds($depth = null)
    {
        return (array) $this->pids;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(static::className(), ['id' => 'pid']);
    }

    /**
     *
     * To get root of a node:
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoot()
    {
        $tableName = $this->tableName();
        $id = $this->getParentsIds();
        if ($id && is_array($id))
        {
            $id = $id[0];
        }

        $query = $this->find()
            ->andWhere(["{$tableName}.[[" . $this->primaryKey()[0] . "]]" => $id]);

        $query->multiple = false;
        return $query;
    }

    /**
     * @param int|null $depth
     * @return \yii\db\ActiveQuery
     * @throws Exception
     */
    public function getParents($depth = null)
    {
        $tableName = $this->tableName();
        $ids = $this->getParentsIds($depth);
        $query = $this->find()
            ->andWhere(["{$tableName}.[[" . $this->primaryKey()[0] . "]]" => $ids]);
        $query->multiple = true;
        return $query;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        $result = $this->hasMany($this->className(), ['pid' => 'id']);
        $result->orderBy(['priority' => SORT_ASC]);

        return $result;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescendants()
    {
        $pidsAll = implode('/', $this->pids) . '/' . $this->id . '/%';

        $expression = new Expression("`pids` LIKE '{$pidsAll}'");

        $query = static::find()
            ->andWhere([
                'or',
                $expression,
                ['pid' => $this->id],
            ])
            ->orderBy([
                "level"     => SORT_ASC,
                "priority"  => SORT_ASC
            ]);

        //$query->primaryModel = $this;
        $query->multiple = true;

        return $query;
    }


    /**
     * @return \yii\db\ActiveQuery
     * @throws NotSupportedException
     */
    public function getPrev()
    {
        $tableName = $this->tableName();
        $query = $this->find()
            ->andWhere([
                'and',
                ["{$tableName}.[[pid]]" => $this->pid],
                ['<', "{$tableName}.[[priority]]", $this->priority],
            ])
            ->orderBy(["{$tableName}.[[priority]]" => SORT_ASC])
            ->limit(1);
        $query->multiple = false;
        return $query;
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws NotSupportedException
     */
    public function getNext()
    {
        $tableName = $this->tableName();
        $query = $this->find()
            ->andWhere([
                'and',
                ["{$tableName}.[[pid]]" => $this->pid],
                ['>', "{$tableName}.[[priority]]", $this->priority],
            ])
            ->orderBy(["{$tableName}.[[priority]]" => SORT_ASC])
            ->limit(1);
        $query->multiple = false;
        return $query;
    }

    /**
     * @return $this
     */
    public function generateName()
    {
        $lastTree = $this->find()->orderBy(['id' => SORT_DESC])->one();
        $this->setAttribute('name', 'pk-' . $lastTree->primaryKey);

        return $this;
    }

    /**
     * @return $this
     */
    public function generateCode()
    {
        if ($this->isRoot())
        {
            $this->setAttribute("code", null);
        } else
        {
            $filter = new FilterSeoPageName();
            $filter->maxLength = \Yii::$app->appSettings->tree_max_code_length;

            $this->code = $filter->filter($this->name);

            $matches = [];
            if (preg_match('/(?<id>\d+)\-(?<code>\S+)$/i', $this->code, $matches))
            {
                $this->code = 's' . $this->code;
            }

            if (!$this->isValidCode())
            {
                $this->code = $filter->filter($this->code . '-' . substr(md5(uniqid() . time()), 0, 4));

                if (!$this->isValidCode())
                {
                    $this->generateCode();
                }
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    protected function isValidCode()
    {
        $parent = $this->parent;
        if (!$parent)
        {
            return true;
        }

        $find   = $parent->getChildren()
            ->where([
                'code' => $this->code,
                'pid' => $this->pid
            ]);

        if (!$this->isNewRecord)
        {
            $find->andWhere([
                '!=', 'id', $this->id
            ]);
        }

        if ($find->one())
        {
            return false;
        }

        return true;
    }

    /**
     *
     * update all the tree below, and the element.
     * if you find all рутов tree and use this method in case of breakdown tree repair itself.
     * right all dir, pids and so on.
     *
     * @return $this
     */
    public function processNormalize()
    {
        if ($this->isNewRecord)
        {
            return $this;
        }

        if (!$this->pid)
        {
            $this->setAttribute('dir', null);
            $this->save(false);
        }
        else
        {
            $this->setAttributesForFutureParent($this->parent);
            $this->save(false);
        }

        if ($this->children)
        {
            $this->save(false);

            foreach ($this->children as $childModel)
            {
                $childModel->processNormalize();
            }
        }

        return $this;
    }


    /**
     * the parent of this node attributes if there will be a new parent, read and 
     * update the necessary data at
     * @param Tree $parent
     * @return $this
     */
    public function setAttributesForFutureParent(Tree $parent)
    {
        if ($parent->isNewRecord)
        {
            throw new Exception('');
        }

        if ($this->id == $parent->id)
        {
            throw new Exception('');
        }

        $newPids     = $parent->pids;
        $newPids[]   = $parent->primaryKey;

        $this->setAttribute('level', ($parent->level + 1));
        $this->setAttribute('pid', $parent->primaryKey);
        $this->setAttribute('pids', $newPids);


        if (!$this->name)
        {
            $this->generateName();
        }

        if (!$this->code)
        {
            $this->generateCode();
        }

        if ($parent->dir)
        {
            $this->setAttribute("dir", $parent->dir . Tree::PIDS_DELIMETR . $this->code);
        } else
        {
            $this->setAttribute("dir", $this->code);
        }

        return $this;
    }


    /**
     *
     * @param Tree $target
     * @return Tree
     * @throws Exception
     * @throws \yiisns\sx\validate\Exception
     */
    public function processCreateNode(Tree $target)
    {
        if ($this->isNewRecord)
        {
            throw new Exception('');
        }
        if (!$target->isNewRecord)
        {
            throw new Exception('');
        }

        $target->setAttributesForFutureParent($this);
        if (!$target->save(false))
        {
            throw new Exception(\Yii::t('yiisns/kernel', 'Failed to create the child element:  ') . Json::encode($target->attributes));
        }

        $this->save(false);

        return $target;
    }


    /**
     * 
     * @param Tree $target
     * @return $this
     * @throws Exception
     * @throws \yiisns\sx\validate\Exception
     */
    public function processAddNode(Tree $target)
    {
        if ($this->isNewRecord)
        {
            throw new Exception('For starters, you need to keep');
        }

        if ($this->id == $target->id)
        {
            throw new Exception('It must be different');
        }

        if ($target->isNewRecord)
        {
            $this->processCreateNode($target);
            return $this;
        }
        else
        {
            $target->setAttributesForFutureParent($this);
            if (!$target->save(false))
            {
                throw new Exception(\Yii::t('yiisns/kernel', 'Unable to move: ') . Json::encode($target->attributes));
            }

            $this->processNormalize();
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return (bool) ($this->level == 0);
    }

    /**
     * @return ActiveQuery
     */
	/*public function findChildrensAll()
	{
        $pidString = implode('/', $this->pids) . "/" . $this->primaryKey;

		return $this->find()
            ->andWhere(['like', 'pids', $pidString . '%', false])
            ->orderBy(["priority" => SORT_ASC]);
	}*/
}