<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.05.2016
 */
namespace yiisns\kernel\models;

use yiisns\kernel\validators\CodeValidator;

/**
 * This is the model class for table "{{%tree_type}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $code
 * @property string $active
 * @property integer $priority
 * @property string $description
 * @property string $index_for_search
 * @property string $name_meny
 * @property string $name_one
 * @property string $viewFile
 * @property integer $default_children_tree_type
 * @property Tree[] $trees
 * @property TreeTypeProperty[] $treeTypeProperties
 * @property TreeType $defaultChildrenTreeType
 */
class TreeType extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tree_type}}';
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
            'index_for_search' => \Yii::t('yiisns/kernel', 'To index for search module'),
            'name_meny' => \Yii::t('yiisns/kernel', 'Name Meny'),
            'name_one' => \Yii::t('yiisns/kernel', 'Name One'),
            'viewFile' => \Yii::t('yiisns/kernel', 'Template'),
            'default_children_tree_type' => \Yii::t('yiisns/kernel', 'Type of child partitions by default'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'priority', 'default_children_tree_type'], 'integer'],
            [['name', 'code'], 'required'],
            [['description'], 'string'],
            [['name', 'viewFile'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 50],
            [['active', 'index_for_search'], 'string', 'max' => 1],
            [['name_meny', 'name_one'], 'string', 'max' => 100],
            [['code'], 'unique',],
            [['code'], CodeValidator::className(),],
            ['priority', 'default', 'value' => 500],
            ['active', 'default', 'value' => 'Y'],
            ['name_meny', 'default', 'value' => \Yii::t('yiisns/kernel', 'Sections')],
            ['name_one', 'default', 'value' => \Yii::t('yiisns/kernel', 'Section')],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrees()
    {
        return $this->hasMany(Tree::className(), ['tree_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeTypeProperties()
    {
        return $this->hasMany(TreeTypeProperty::className(), ['tree_type_id' => 'id'])->orderBy(['priority' => SORT_ASC]);;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultChildrenTreeType()
    {
        return $this->hasOne(TreeType::className(), ['id' => 'default_children_tree_type']);
    }
}