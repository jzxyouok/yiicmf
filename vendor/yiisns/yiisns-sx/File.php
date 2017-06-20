<?php
/**
 * File
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.10.2016
 * @since 1.0.0
 */
namespace yiisns\sx;

use yiisns\sx\Exception;
use yii\helpers\FileHelper;

/**
 * Class File
 * 
 * @package yiisns\sx
 */
class File
{
    use traits\Entity;
    use traits\HasWritableOptions;
    use traits\InstanceObject;

    /**
     *
     *
     * @param $filePath
     * @param array $options            
     */
    public function __construct($filePath, $options = [])
    {
        if (is_string($filePath)) {
            $this->_parse($filePath);
        } else 
            if ($filePath instanceof static) {
                $this->_data = $filePath->toArray();
                $this->_options = $filePath->getOptions();
            }
        
        $this->setOptions(array_merge([
            // 'isHaveExtension' => true,
            'rewrite' => true,
            'autoCreateDir' => true
        ]
), $options);
        
        $this->_init();
    }

    /**
     *
     * @return $this
     */
    private function _init()
    {
        // $this->setDirName($this->getDirName());
        if ($this->offsetExists("basename")) {
            unset($this->_data["basename"]);
        }
        
        return $this;
    }

    /**
     *
     * @param $filePath
     * @return $this
     */
    private function _parse($filePath)
    {
        $this->_data = pathinfo($filePath);
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDirName()
    {
        return (string) $this->get("dirname");
    }

    /**
     *
     * @return string
     */
    public function getFileName()
    {
        return (string) $this->get("filename");
    }

    /**
     *
     * @return string
     */
    public function getBaseName()
    {
        return (string) $this->getExtension() ? $this->getFileName() . "." . $this->getExtension() : $this->getFileName();
    }

    /**
     *
     * @return string
     */
    public function getExtension()
    {
        return (string) $this->get("extension");
    }

    /**
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getMimeType()
    {
        return FileHelper::getMimeType($this->getPath());
    }

    /**
     * mime_type
     * 
     * @return string
     */
    public function getType()
    {
        $dataMimeType = explode('/', $this->getMimeType());
        return (string) $dataMimeType[0];
    }

    /**
     *
     * @param $value
     * @return $this
     * @throws Exception
     */
    public function setDirName($value)
    {
        return $this->set('dirname', (string) realpath($value));
    }

    /**
     *
     * @param string $value            
     * @return $this
     * @throws Exception
     */
    public function setFileName($value)
    {
        return $this->set('filename', (string) $value);
    }

    /**
     *
     * @param string $value            
     * @return $this
     * @throws Exception
     */
    public function setExtension($value)
    {
        return $this->set('extension', (string) $value);
    }

    /**
     *
     * @return bool
     */
    public function isHaveExtension()
    {
        return (bool) $this->get('extension');
    }

    /**
     *
     * @return $this
     */
    public function enableRewrite()
    {
        $this->setOption("rewrite", true);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function disableRewrite()
    {
        $this->setOption("rewrite", false);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function enableAutoCreateDir()
    {
        $this->setOption("autoCreateDir", true);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function disableAutoCreateDir()
    {
        $this->setOption("autoCreateDir", false);
        return $this;
    }

    /**
     * 
     * @return bool
     */
    public function isExist()
    {
        return file_exists($this->getPath());
    }

    /**
     *
     * @return FileSize
     */
    public function getSize()
    {
        if ($this->isExist()) {
            return FileSize::object(filesize($this->getPath()));
        }
        
        return FileSize::object(0);
    }

    /**
     *
     * @return FileSize
     */
    public function size()
    {
        return $this->getSize();
    }

    /**
     * 
     * @return bool
     */
    public function isReadable()
    {
        return is_readable($this->getPath());
    }

    /**
     *
     * @throws Exception
     */
    public function read()
    {
        if (! $this->isExist()) {
            throw new Exception("file: ({$this->getPath()}) is not exist");
        }
        
        if (! $this->isReadable()) {
            throw new Exception("file: ({$this->getPath()}) cannot be read");
        }
        
        $fp = fopen($this->getPath(), 'a+');
        if ($fp) {
            $size = $this->getSize();
            $content = fread($fp, $size->getBytes());
            fclose($fp);
            return (string) $content;
        } else {
            throw new Exception("file: ({$this->getPath()}) is not exist");
        }
    }

    /**
     *
     * @return bool
     * @throws Exception
     */
    public function unlink()
    {
        if (! $this->isExist()) {
            throw new Exception("file: ({$this->getPath()}) is not exist");
        }
        
        return unlink($this->getPath());
    }

    /**
     *
     * @return bool
     * @throws Exception
     */
    public function remove()
    {
        return $this->unlink();
    }

    /**
     *
     * @param string $content            
     * @param string $recordingMode            
     * @return $this
     */
    public function write($content = "", $recordingMode = "w")
    {
        $this->checkAndCreateDir();
        
        $file = fopen($this->getPath(), $recordingMode);
        fwrite($file, $content);
        fclose($file);
        
        return $this;
    }

    /**
     *
     * @param string $content            
     * @param string $recordingMode            
     * @return File
     */
    public function make($content = "", $recordingMode = "w")
    {
        return $this->write($content, $recordingMode);
    }

    /**
     *
     * @param $newFileNameWhithoutExtension
     * @return $this
     */
    public function rename($newFileNameWhithoutExtension)
    {
        $name = $this->getName();
        
        if (! $extension = $this->getExtension()) {
            return $this->setBaseName($newFileNameWhithoutExtension);
        } else {
            return $this->setBaseName($newFileNameWhithoutExtension . "." . $extension);
        }
    }

    /**
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->getDirName() . "/" . $this->getBaseName();
    }

    /**
     *
     * @return Dir
     */
    public function getDir()
    {
        return Dir::object((string) $this->getDirName());
    }

    public function checkAndCreateDir()
    {
        $dir = $this->getDir();
        
        if ($this->isExist() && ! $this->getOption("rewrite")) {
            throw new Exception("file {$dir} exists and option '_rewrite' === false");
        }
        
        if (! $dir->isExist() && ! $this->getOption("autoCreateDir")) {
            throw new Exception("dir {$dir} not exists and option '_autoCreateDir' === false");
        } else 
            if (! $dir->isExist() && $this->getOption("autoCreateDir")) {
                $dir->make();
            }
        
        if (! $dir->isExist()) {
            throw new Exception("dir {$dir} not exists");
        }
        
        return $this;
    }

    /**
     *
     * @param $newFile
     * @return File
     * @throws Exception
     */
    public function copy($newFile)
    {
        $newFile = static::object($newFile);
        
        $newFile->checkAndCreateDir();
        
        if (! copy((string) $this->getPath(), (string) $newFile->getPath())) {
            throw new Exception("not copy file: " . $this->getPath() . " into: " . $newFile->getPath());
        }
        
        return $newFile;
    }

    /**
     *
     * @param $newRootPathFle
     * @return File
     * @throws Exception
     */
    public function move($newRootPathFle)
    {
        $newFile = $this->copy($newRootPathFle);
        $this->unlink();
        
        return $newFile;
    }

    /**
     *
     * @return string
     */
    public function toString()
    {
        return $this->getPath();
    }

    /**
     *
     * @param $file1
     * @return null|File
     */
    static public function getFirstExistingFile($file1 /*...*/)
    {
        $files = func_get_args();
        foreach ($files as $file) {
            if (file_exists($file)) {
                return new self($file);
            }
        }
        
        return null;
    }

    /**
     *
     * @param array $files            
     * @return null|File
     */
    static public function getFirstExistingFileArray($files = array())
    {
        foreach ($files as $file) {
            if (file_exists($file)) {
                return new self($file);
            }
        }
        
        return null;
    }
}