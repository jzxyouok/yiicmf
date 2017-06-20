<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.04.2016
 */
namespace yiisns\apps\base;

use yii\base\Component as YiiComponent;

use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class CheckComponent
 * @package yiisns\apps\base
 */
abstract class CheckComponent extends YiiComponent
{
    const RESULT_SUCCESS        = 'success';
    const RESULT_ERROR          = 'error';
    const RESULT_WARNING        = 'warning';

    public $name                = '';
    public $description         = '';

    public $successText         = '';
    public $errorText           = '';
    public $warningText         = '';

    public $result                  = self::RESULT_SUCCESS;

    public $errorMessages           = [];
    public $successMessages         = [];
    public $warningMessages         = [];

    /**
     * @var int percent
     */
    public $ptc                     = 100;
    public $lastValue               = null;

    abstract public function run();

    public function init()
    {
        if(!$this->name)
        {
            $this->name = \Yii::t('yiisns/kernel', 'Checking the necessary modules');
        }
        if(!$this->description)
        {
            $this->description = \Yii::t('yiisns/kernel', 'Checking the availability of the required extensions for maximality work product. If an error occurs, show a list of modules that are unavailable.');
        }
        if(!$this->successText)
        {
            $this->successText = \Yii::t('yiisns/kernel', 'All necessary modules are installed');
        }
        if(!$this->errorText)
        {
            $this->errorText = \Yii::t('yiisns/kernel', 'Not all modules are installed');
        }
        if(!$this->warningText)
        {
            $this->warningText = \Yii::t('yiisns/kernel', 'Some non-critical remark');
        }

        parent::init();
    }

    /**
     * @param string $message
     * @return $this
     */
    public function addError($message = '')
    {
        $this->result = self::RESULT_ERROR;
        $this->errorMessages[] = $message;

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function addWarning($message = '')
    {
        $this->result = self::RESULT_WARNING;
        $this->warningMessages[] = $message;

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function addSuccess($message = '')
    {
        $this->result = self::RESULT_SUCCESS;
        $this->successMessages[] = $message;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return ($this->result == self::RESULT_SUCCESS);
    }
}