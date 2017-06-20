<?php
namespace yiisns\kernel\models;

/**
 * This is the model class for table "{{%dashboard}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property integer $user_id
 * @property integer $priority
 * @property string $columns
 * @property string $columns_settings
 *
 * @property User $user
 * @property DashboardWidget[] $dashboardWidgets
 */
class Dashboard extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dashboard}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'created_by',
                    'updated_by',
                    'created_at',
                    'updated_at',
                    'user_id',
                    'priority',
                    'columns'
                ],
                'integer'
            ],
            [
                [
                    'name'
                ],
                'required'
            ],
            [
                [
                    'columns_settings'
                ],
                'string'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 255
            ],
            
            [
                [
                    'priority'
                ],
                'default',
                'value' => 100
            ],
            [
                [
                    'columns'
                ],
                'default',
                'value' => 1
            ],
            [
                [
                    'columns'
                ],
                'integer',
                'max' => 6,
                'min' => 1
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'created_by' => \Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => \Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'name' => \Yii::t('yiisns/kernel', 'Name'),
            'user_id' => \Yii::t('yiisns/kernel', 'User ID'),
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
            'columns' => \Yii::t('yiisns/kernel', 'Number of columns'),
            'columns_settings' => \Yii::t('yiisns/kernel', 'Columns Settings')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), [
            'id' => 'user_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDashboardWidgets()
    {
        return $this->hasMany(DashboardWidget::className(), [
            'dashboard_id' => 'id'
        ]);
    }
}