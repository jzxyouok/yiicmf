<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.03.2016
 */
namespace yiisns\search;

use yiisns\apps\assets\ToolbarAsset;
use yiisns\apps\assets\ToolbarFancyboxAsset;
use yiisns\kernel\base\AppCore;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Content;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\ContentElementProperty;
use yiisns\kernel\models\ContentProperty;
use yiisns\search\models\SearchPhrase;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\rbac\SnsManager;
use yii\base\BootstrapInterface;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\View;

use \Yii;
use yii\widgets\ActiveForm;

/**
 * @property string searchQuery
 *
 * Class SearchComponent
 * @package yiisns\kernel\search
 */
class SearchComponent extends \yiisns\kernel\base\Component
{
    /**
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/search', 'Searching'),
        ]);
    }

    public $searchElementContentIds = [];

    public $searchElementFields =
    [
        'description_full',
        'description_short',
        'name',
    ];
    public $enabledElementProperties              = 'Y';
    public $enabledElementPropertiesSearchable    = 'Y';

    public $searchQueryParamName = 'q';

    public $phraseLiveTime = 0;


    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['searchQueryParamName'], 'string'],
            [['enabledElementProperties'], 'string'],
            [['enabledElementPropertiesSearchable'], 'string'],
            [['phraseLiveTime'], 'integer'],
            [['searchElementFields'], 'safe'],
            [['searchElementContentIds'], 'safe'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'searchQueryParamName'                  => \Yii::t('yiisns/search', 'Setting the search query in the address bar'),
            'searchElementFields'                   => \Yii::t('yiisns/search', 'The main elements of a set of fields on which to search'),
            'enabledElementProperties'              => \Yii::t('yiisns/search', 'Search among items of additional fields'),
            'enabledElementPropertiesSearchable'    => \Yii::t('yiisns/search', 'Consider the setting of additional fields in the search for him'),
            'searchElementContentIds'               => \Yii::t('yiisns/search', 'Search for content items of the following types'),
            'phraseLiveTime'                        => \Yii::t('yiisns/search', 'Time storage searches'),
        ]);
    }

    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'searchQueryParamName'              => \Yii::t('yiisns/search', 'Parameter name for the address bar'),
            'phraseLiveTime'                    => \Yii::t('yiisns/search', 'If you specify 0, the searches will not be deleted ever'),
            'enabledElementProperties'          => \Yii::t('yiisns/search', 'Including this option, the search begins to take into account the additional elements of the field'),
            'enabledElementPropertiesSearchable'=> \Yii::t('yiisns/search', 'Each additional feature is its customization. This option will include a search not for any additional properties, but only with the option "Property values are involved in the search for"'),
        ]);
    }


    public function renderConfigForm(ActiveForm $form)
    {
        echo $form->fieldSet(\Yii::t('yiisns/search', 'Main'));

            echo $form->field($this, 'searchQueryParamName');
            echo $form->fieldInputInt($this, 'phraseLiveTime');

        echo $form->fieldSetEnd();


        echo $form->fieldSet(\Yii::t('yiisns/search', 'Finding Items'));

            echo $form->fieldSelectMulti($this, 'searchElementContentIds', Content::getDataForSelect() );
            echo $form->fieldSelectMulti($this, 'searchElementFields', (new \yiisns\kernel\models\ContentElement())->attributeLabels() );
            echo $form->fieldRadioListBoolean($this, 'enabledElementProperties');
            echo $form->fieldRadioListBoolean($this, 'enabledElementPropertiesSearchable');

        echo $form->fieldSetEnd();

        echo $form->fieldSet(\Yii::t('yiisns/search', 'Search sections'));
            echo \Yii::t('yiisns/search','In developing');
        echo $form->fieldSetEnd();
    }

    /**
     * @return string
     */
    public function getSearchQuery()
    {
        return (string) \Yii::$app->request->get($this->searchQueryParamName);
    }

    /**
     *
     * @param \yii\db\ActiveQuery $activeQuery
     * @param null $modelClassName
     * @return $this
     */
    public function buildElementsQuery(\yii\db\ActiveQuery $activeQuery)
    {
        $where = [];

        if ($this->enabledElementProperties == AppCore::BOOL_Y)
        {
            $activeQuery->joinWith('contentElementProperties');

            if ($this->enabledElementPropertiesSearchable == AppCore::BOOL_Y)
            {
                $activeQuery->joinWith('contentElementProperties.property');

                $where[] = ['and',
                    ['like', ContentElementProperty::tableName() . '.value', '%' . $this->searchQuery . '%', false],
                    [ContentProperty::tableName() . ".searchable" => AppCore::BOOL_Y]
                ];
            } else
            {
                $where[] = ['like', ContentElementProperty::tableName() . ".value", '%' . $this->searchQuery . '%', false];
            }
        }

        if ($this->searchElementFields)
        {
            foreach ($this->searchElementFields as $fieldName)
            {
                $where[] = ['like', ContentElement::tableName() . '.' . $fieldName, '%' . $this->searchQuery . '%', false];
            }
        }

        if ($where)
        {
            $where = array_merge(['or'], $where);
            $activeQuery->andWhere($where);
        }

        if ($this->searchElementContentIds)
        {
            $activeQuery->andWhere([
                ContentElement::tableName() . '.content_id' => (array) $this->searchElementContentIds
            ]);
        }

        return $this;
    }

    /**
     * @param ActiveDataProvider $dataProvider
     */
    public function logResult(ActiveDataProvider $dataProvider)
    {
        $pages = 1;

        if ($dataProvider->totalCount > $dataProvider->pagination->pageSize)
        {
            $pages = round($dataProvider->totalCount / $dataProvider->pagination->pageSize);
        }

        $searchPhrase = new \yiisns\search\models\SearchPhrase([
            'phrase'        => $this->searchQuery,
            'result_count'  => $dataProvider->totalCount,
            'pages'         => $pages,
        ]);

        $searchPhrase->save();
    }
}