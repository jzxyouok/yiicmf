<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.10.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models\behaviors;

use yiisns\sx\filters\string\SeoPageName as FilterSeoPageName;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\base\Event;

/**
 * Class SeoPageNameBehavior
 * 
 * @package yiisns\kernel\models\behaviors
 */
class SeoPageNameBehavior extends AttributeBehavior
{
    /**
     *
     * @var string the attribute that will receive timestamp value
     *      Set this property to false if you do not want to record the creation time.
     */
    public $generatedAttribute = 'code';

    public $fromAttribute = 'name';

    public $uniqeue = true;

    public $maxLength = 64;

    /**
     *
     * @var
     *
     */
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [
                    $this->generatedAttribute
                ],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => [
                    $this->generatedAttribute
                ]
            ];
        }
    }

    /**
     *
     * @param Event $event            
     * @return mixed the value of the user.
     */
    public function getValue($event)
    {
        if (! $this->value) {
            $filter = new FilterSeoPageName();
            $filter->maxLength = $this->maxLength;
            
            if ($this->owner->{$this->generatedAttribute}) {
                $seoPageName = $filter->filter($this->owner->{$this->generatedAttribute});
            } else {
                $seoPageName = $filter->filter($this->owner->{$this->fromAttribute});
            }
            
            if ($this->uniqeue) {
                if (! $this->owner->isNewRecord) {
                    if ($founded = $this->owner->find()
                        ->where([
                        $this->generatedAttribute => $seoPageName
                    ])
                        ->andWhere([
                        "!=",
                        "id",
                        $this->owner->id
                    ])
                        ->one()) {
                        if ($last = $this->owner->find()
                            ->orderBy('id DESC')
                            ->one()) {
                            $seoPageName = $seoPageName . '-' . $last->id;
                            return $filter->filter($seoPageName);
                        }
                    }
                } else {
                    if ($founded = $this->owner->find()
                        ->where([
                        $this->generatedAttribute => $seoPageName
                    ])
                        ->one()) {
                        if ($last = $this->owner->find()
                            ->orderBy('id DESC')
                            ->one()) {
                            $seoPageName = $seoPageName . '-' . $last->id;
                            return $filter->filter($seoPageName);
                        }
                    }
                }
            }
            
            return $seoPageName;
        } else {
            return call_user_func($this->value, $event);
        }
    }
}