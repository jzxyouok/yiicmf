<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.05.2016
 */
namespace yiisns\kernel\models\searchs;

use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\ContentElementTree;
use yiisns\kernel\models\User;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class UserSearch extends User
{
    public $created_at_from;

    public $created_at_to;

    public $updated_at_from;

    public $updated_at_to;

    public $auth_at_from;

    public $auth_at_to;

    public $has_image;

    public $q;

    public $role;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                'section',
                'integer'
            ],
            [
                'created_at_from',
                'integer'
            ],
            [
                'created_at_to',
                'integer'
            ],
            [
                'updated_at_from',
                'integer'
            ],
            [
                'updated_at_to',
                'integer'
            ],
            [
                'auth_at_from',
                'integer'
            ],
            [
                'auth_at_to',
                'integer'
            ],
            [
                'has_image',
                'integer'
            ],
            [
                'q',
                'string'
            ],
            [
                'role',
                'string'
            ]
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            
            'created_at_from' => \Yii::t('yiisns/kernel', 'Created date (from)'),
            'created_at_to' => \Yii::t('yiisns/kernel', 'Created (up to)'),
            
            'updated_at_from' => \Yii::t('yiisns/kernel', 'Updated time (from)'),
            'updated_at_to' => \Yii::t('yiisns/kernel', 'Updated time (up to)'),
            
            'auth_at_from' => \Yii::t('yiisns/kernel', 'The last authorization (up from)'),
            'auth_at_to' => \Yii::t('yiisns/kernel', 'The last authorization (up to)'),
            
            'has_image' => \Yii::t('yiisns/kernel', 'Image'),
            
            'q' => \Yii::t('yiisns/kernel', 'Search'),
            'role' => \Yii::t('yiisns/kernel', 'Role')
        ]);
    }

    public function search($params)
    {
        $tableName = $this->tableName();
        
        $activeDataProvider = new ActiveDataProvider([
            'query' => static::find()
        ]);
        
        if (! ($this->load($params))) {
            return $activeDataProvider;
        }
        /**
         *
         * @var $query ActiveQuery
         */
        $query = $activeDataProvider->query;
        
        // Standart
        if ($columns = $this->getTableSchema()->columns) {
            /**
             *
             * @var \yii\db\ColumnSchema $column
             */
            foreach ($columns as $column) {
                if ($column->phpType == 'integer') {
                    $query->andFilterWhere([
                        $this->tableName() . '.' . $column->name => $this->{$column->name}
                    ]);
                } else 
                    if ($column->phpType == 'string') {
                        $query->andFilterWhere([
                            'like',
                            $this->tableName() . '.' . $column->name,
                            $this->{$column->name}
                        ]);
                    }
            }
        }
        
        if ($this->created_at_from) {
            $query->andFilterWhere([
                '>=',
                $this->tableName() . '.created_at',
                \Yii::$app->formatter->asTimestamp(strtotime($this->created_at_from))
            ]);
        }
        
        if ($this->created_at_to) {
            $query->andFilterWhere([
                '<=',
                $this->tableName() . '.created_at',
                \Yii::$app->formatter->asTimestamp(strtotime($this->created_at_to))
            ]);
        }
        
        if ($this->updated_at_from) {
            $query->andFilterWhere([
                '>=',
                $this->tableName() . '.updated_at',
                \Yii::$app->formatter->asTimestamp(strtotime($this->updated_at_from))
            ]);
        }
        
        if ($this->updated_at_to) {
            $query->andFilterWhere([
                '<=',
                $this->tableName() . '.created_at',
                \Yii::$app->formatter->asTimestamp(strtotime($this->updated_at_to))
            ]);
        }
        
        if ($this->auth_at_from) {
            $query->andFilterWhere([
                '>=',
                $this->tableName() . '.logged_at',
                \Yii::$app->formatter->asTimestamp(strtotime($this->auth_at_from))
            ]);
        }
        
        if ($this->auth_at_to) {
            $query->andFilterWhere([
                '<=',
                $this->tableName() . '.logged_at',
                \Yii::$app->formatter->asTimestamp(strtotime($this->auth_at_to))
            ]);
        }
        
        if ($this->has_image) {
            $query->andFilterWhere([
                '>',
                $this->tableName() . '.image_id',
                0
            ]);
        }
        
        if ($this->q) {
            $query->andFilterWhere([
                'or',
                [
                    'like',
                    $this->tableName() . '.name',
                    $this->q
                ],
                [
                    'like',
                    $this->tableName() . '.email',
                    $this->q
                ],
                [
                    'like',
                    $this->tableName() . '.phone',
                    $this->q
                ],
                [
                    'like',
                    $this->tableName() . '.username',
                    $this->q
                ]
            ]);
        }
        
        if ($this->role) {
            $query->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id');
            
            $query->andFilterWhere([
                'auth_assignment.item_name' => $this->role
            ]);
        }
        
        return $activeDataProvider;
    }

    /**
     * Returns the list of attribute names.
     * By default, this method returns all public non-static properties of the class.
     * You may override this method to change the default behavior.
     * 
     * @return array list of attribute names.
     */
    public function attributes()
    {
        $class = new \ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (! $property->isStatic()) {
                $names[] = $property->getName();
            }
        }
        
        return ArrayHelper::merge(parent::attributes(), $names);
    }
}