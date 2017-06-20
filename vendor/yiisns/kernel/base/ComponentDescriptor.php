<?php
namespace yiisns\kernel\base;

/**
 * The name and description of the component etc.
 */
class ComponentDescriptor extends \yii\base\Component
{
    public $version = '1.0.0';

    public $startDevelopmentDate = '2016-01-01';

    public $name = 'YiiSNS';

    public $description = '';

    public $keywords = [];

    public $homepage = 'http://www.yiisns.cn/';

    public $license = 'BSD-3-Clause';

    public $support = [
        'issues' => 'http://www.yiisns.cn/',
        'wiki' => 'http://www.yiisns.cn/wiki/',
        'source' => 'https://github.com/uussoft/YiiSNS',
    ];

    public $companies = [
        [
            'name' => 'YiiSNS',
            'emails' => [
                'info@yiisns.cn',
                'support@yiisns.cn'
            ],
            'phones' => [
                '+86 (21) 8888-8888'
            ],
            'sites' => [
                'http://www.yiisns.cn'
            ]
        ]
    ];

    public $authors = [
        [
            'name' => 'uussoft',
            'emails' => [
                'uussoft@yiisns.cn'
            ],
            'phones' => [
                '+86 (21) 8888-8888'
            ]
        ]
    ];

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     *
     * @return string
     */
    public function toString()
    {
        return $this->name . ' (' . $this->version . ')';
    }

    /**
     *
     * @return string
     */
    public function getCopyright()
    {
        return (string) '@' . \Yii::$app->getFormatter()->asDate($this->startDevelopmentDate, 'y') . '-' . \Yii::$app->getFormatter()->asDate(time(), 'y') . ' ' . $this->toString();
    }

    /**
     *
     * @return string
     */
    public function getPowered()
    {
        return 'Powered by <a href="' . $this->homepage . '" rel="external">' . $this->name . '</a>';
    }
}