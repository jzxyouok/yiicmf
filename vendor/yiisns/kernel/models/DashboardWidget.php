<?php
namespace yiisns\kernel\models;

use yiisns\apps\base\Widget;
use yiisns\kernel\models\behaviors\SerializeBehavior;
use yiisns\admin\base\AdminDashboardWidget;

use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%dashboard_widget}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $dashboard_id
 * @property integer $priority
 * @property string $component
 * @property string $component_settings
 * @property string $dashboard_column
 *
 *
 * @property string $name
 *
 * @property Dashboard $dashboard
 *
 * @property AdminDashboardWidget $widget
 */
class DashboardWidget extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dashboard_widget}}';
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            SerializeBehavior::className() => [
                'class' => SerializeBehavior::className(),
                'fields' => [
                    'component_settings'
                ]
            ]
        ]);
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
                    'dashboard_id',
                    'priority'
                ],
                'integer'
            ],
            [
                [
                    'dashboard_id',
                    'component'
                ],
                'required'
            ],
            [
                [
                    'component_settings'
                ],
                'safe'
            ],
            [
                [
                    'component'
                ],
                'string',
                'max' => 255
            ],
            
            [
                [
                    'dashboard_column'
                ],
                'integer',
                'max' => 6,
                'min' => 1
            ],
            [
                [
                    'dashboard_column'
                ],
                'default',
                'value' => 1
            ],
            [
                [
                    'priority'
                ],
                'default',
                'value' => 50
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
            'dashboard_id' => \Yii::t('yiisns/kernel', 'Dashboard ID'),
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
            'component' => \Yii::t('yiisns/kernel', 'Component'),
            'component_settings' => \Yii::t('yiisns/kernel', 'Component Settings'),
            'dashboard_column' => \Yii::t('yiisns/kernel', 'Dashboard_column')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDashboard()
    {
        return $this->hasOne(Dashboard::className(), [
            'id' => 'dashboard_id'
        ]);
    }

    /**
     *
     * @return AdminDashboardWidget
     * @throws \yii\base\InvalidConfigException
     */
    public function getWidget()
    {
        if ($this->component) {
            if (class_exists($this->component)) {
                /**
                 *
                 * @var $component AdminDashboardWidget
                 */
                $component = \Yii::createObject($this->component);
                $component->load($this->component_settings, '');
                
                return $component;
            }
        }
        
        return null;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        if ($this->widget) {
            if ($this->widget->getAttributes(['name'])) {
                return (string) $this->widget->name;
            }
        }
        
        return '';
    }
}