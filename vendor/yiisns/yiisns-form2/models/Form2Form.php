<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
namespace yiisns\form2\models;

use yiisns\kernel\models\behaviors\ImplodeBehavior;
use yiisns\kernel\models\Core;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\validators\EmailValidator;

/**
 * This is the model class for table "{{%form2_form}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $description
 * @property string $code
 * @property string $emails
 * @property string $phones
 * @property string $user_ids
 *
 * @property array $emailsAsArray
 *
 * @property Form2FormSend[] $form2FormSends
 * @property Form2FormProperty[] $form2FormProperties
 */
class Form2Form extends Core
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form2_form}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['emails', 'phones', 'user_ids'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 32],
            [['code'], 'unique'],

            [['emails'], function($attribute)
            {
                if ($this->emailsAsArray)
                {
                    foreach ($this->emailsAsArray as $email)
                    {
                        $validator = new EmailValidator();

                        if (!$validator->validate($email, $error))
                        {
                            $this->addError($attribute, $email . ' — ' . \Yii::t('yiisns/form2', 'Incorrect email address'));
                            return false;
                        }
                    }
                }

            }],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => \Yii::t('yiisns/form2', 'ID'),
            'created_by' => \Yii::t('yiisns/form2', 'Created By'),
            'updated_by' => \Yii::t('yiisns/form2', 'Updated By'),
            'created_at' => \Yii::t('yiisns/form2', 'Created At'),
            'updated_at' => \Yii::t('yiisns/form2', 'Updated At'),
            'name' => \Yii::t('yiisns/form2', 'Name'),
            'description' => \Yii::t('yiisns/form2', 'Description'),
            'code' => \Yii::t('yiisns/form2', 'Code'),
            'emails' => \Yii::t('yiisns/form2', 'Email addresses'),
            'phones' => \Yii::t('yiisns/form2', 'Telephones'),
            'user_ids' => \Yii::t('yiisns/form2', 'User Ids'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm2FormSends()
    {
        return $this->hasMany(Form2FormSend::className(), ['form_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm2FormProperties()
    {
        return $this->hasMany(Form2FormProperty::className(), ['form_id' => 'id'])->orderBy(['priority' => SORT_ASC]);
    }


    /**
     * @return array
     */
    public function getEmailsAsArray()
    {
        $emailsAll = [];
        if ($this->emails)
        {
            $emails = explode(",", $this->emails);

            foreach ($emails as $email)
            {
                $emailsAll[] = trim($email);
            }
        }

        return $emailsAll;
    }

    /**
     * @return Form2FormSend
     */
    public function createModelFormSend()
    {
        if ($this->isNewRecord)
        {
            throw new InvalidParamException;
        }

        $form2Send = new \yiisns\form2\models\Form2FormSend([
            'form_id' => (int) $this->id
        ]);

        $rpm = $form2Send->relatedPropertiesModel;
        $rpm->loadDefaultValues();

        return $form2Send;
    }
}