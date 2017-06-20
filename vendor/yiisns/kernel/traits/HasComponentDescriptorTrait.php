<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.05.2016
 */
namespace yiisns\kernel\traits;

use yiisns\kernel\base\ComponentDescriptor;

/**
 *
 * @property ComponentDescriptor descriptor
 *
 * Class HasComponentDescriptorTrait
 * @package yiisns\kernel\traits
 */
trait HasComponentDescriptorTrait
{
    /**
     * @var ComponentDescriptor
     */
    protected $_descriptor = null;
    /**
     * @var string
     */
    static public $descriptorClassName = 'yiisns\kernel\base\ComponentDescriptor';

    /**
     * @return array
     */
    static public function descriptorConfig()
    {
        return
        [
            'version'               => '1.0.0',
            'name'                  => 'YiiSNS',
            'description'           => '',
            'keywords'              => 'yiisns, sns',
            'homepage'              => 'http://www.yiisns.cn/',
            'license'               => 'BSD-3-Clause',
            'support'               =>
            [
                'issues'    =>  'http://issues.yiisns.cn/',
                'wiki'      =>  'http://docs.yiisns.cn/',
                'source'    =>  'https://github.com/uussoft/YiiSNS'
            ],

            'companies'   =>
            [
                [
                    'name'      =>  'YiiSNS',
                    'emails'    => ['info@yiisns.cn', 'support@yiisns.cn'],
                    'phones'    => ['+86 (21) 8888-8888'],
                    'sites'     => ['http://www.yiisns.cn']
                ]
            ],

            'authors'    =>
            [
                [
                    'name'      => 'uussoft',
                    'emails'    => ['uussoft@yiisns.cn'],
                    'phones'    => ['+86 (21) 8888-8888']
                ],
            ],
        ];
    }

    /**
     * @return ComponentDescriptor
     */
    public function getDescriptor()
    {
        if ($this->_descriptor === null)
        {
            $classDescriptor = static::$descriptorClassName;
            if (class_exists($classDescriptor))
            {
                $this->_descriptor = new $classDescriptor(static::descriptorConfig());
            } else
            {
                $this->_descriptor = new ComponentDescriptor(static::descriptorConfig());
            }
        }

        return $this->_descriptor;
    }
}