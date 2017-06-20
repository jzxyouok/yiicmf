<?php
/**
 * Filter
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 11.12.2016
 * @since 1.0.0
 */

namespace yiisns\apps\components\imaging;

use Faker\Provider\File;
use yii\base\Component;

/**
 * Class Filter
 * @package yiisns\apps\components\imaging
 */
abstract class Filter extends Component
{
    protected $_config = [];
    
    protected $_originalRootFilePath    = null;
    protected $_newRootFilePath         = null;

    public function __construct($config = [])
    {
        $this->_config = $config;
        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return str_replace('\\', '-', $this->className());
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * @param $originalFilePath
     * @return $this
     */
    public function setOriginalRootFilePath($originalRootFilePath)
    {
        $this->_originalRootFilePath = (string) $originalRootFilePath;
        return $this;
    }

    /**
     * @param $originalFilePath
     * @return $this
     */
    public function setNewRootFilePath($newRootFilePath)
    {
        $this->_newRootFilePath = (string) $newRootFilePath;
        return $this;
    }


    /**
     * @return \yiisns\sx\File
     * @throws \ErrorException
     */
    public function save()
    {
        if (!$this->_originalRootFilePath)
        {
            throw new \ErrorException(\Yii::t('yiisns/apps', 'Not configurated original file'));
        }

        if (!$this->_newRootFilePath)
        {
            throw new \ErrorException(\Yii::t('yiisns/apps', 'Not configurated new file path'));
        }

        //try
        //{
            $this->_createNewDir();
            $this->_save();
            $file = new \yiisns\sx\File($this->_newRootFilePath);

            if (!$file->isExist())
            {
                throw new \ErrorException(\Yii::t('yiisns/apps', 'File not found'));
            }

        //} catch (\Cx_Exception $e)
        //{
        //    throw new \ErrorException($e->getMessage());
        //}

        return $file;
    }


    /**
     * @return $this
     */
    protected function _createNewDir()
    {
        $newFile = new \yiisns\sx\File($this->_newRootFilePath);

        if (!$newFile->getDir()->make())
        {
            throw new \ErrorException(\Yii::t('yiisns/apps', 'Could not create subdirectory for new file'));
        }

        return $this;
    }

    abstract protected function _save();
}