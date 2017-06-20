<?php
/**
 * Dir
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
 * @package yiisns\sx
 */
class Dir
{
    use traits\Entity;
    use traits\InstanceObject;

    /**
     * @param bool $autoOpen
     * @return Dir
     */
    static public function runtimeTmp($autoOpen = true)
    {
        return new static(\Yii::getAlias("@app/runtime/tmp-yiisns"), $autoOpen);
    }
    /**
     * @param string|Dir $dirPath
     * @param bool $autoOpen
     * @throws Exception
     */
    public function __construct($dirPath, $autoOpen = true)
    {
        if (is_string($dirPath))
        {
            $this->_data["dirpath"] = realpath($dirPath) ? realpath($dirPath) : $dirPath;
        } else if ($dirPath instanceof static)
        {
            $this->_data    = $dirPath->toArray();
        } else
        {
            throw new Exception('incorrect data');
        }

        if ($autoOpen)
        {
            $this->make(0777, true);
        }
    }

    /**
     *
     * @param $src
     * @return File
     */
    public function downloadRemouteFile($src)
    {
        $content = file_get_contents($src);
        $realName = File::object($src)->getBaseName();

        $file = $this->newFile($realName);
        $file->write($content);

        return $file;
    }

    /**
     * @param $baseFileName
     * @return File
     */
    public function newFile($baseFileName = null)
    {
        if (!$baseFileName)
        {
            $baseFileName = md5(microtime() . rand(0,100));
        }
        return new File($this->getPath() . "/" . $baseFileName);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return (string) $this->get("dirpath");
    }

    /**
     * @return bool
     */
    public function isExist()
    {
        return is_dir($this->getPath());
    }


    /**
     * @return string
     */
    public function toString()
    {
        return $this->getPath();
    }


    /**
     *
     * @param int $mode
     * @return bool
     */
    public function setChmod($mode = 0777)
    {
        return chmod($this->getPath(), $mode);
    }

    /**
     * @return resource
     * @throws Exception
     */
    public function open()
    {
        if (!$this->isExist())
        {
            throw new Exception("dir {$this->getPath()} not exist");
        }

        return opendir($this->getPath());
    }

    /**
     * @param int $mode
     * @param bool $recursive
     * @return bool
     */
    public function make($mode = 0777, $recursive = true)
    {
        if (!$this->isExist())
        {
            return mkdir($this->getPath(), $mode, $recursive);
        }

        return true;
    }

    /**
     * @return bool
     */
    public function remove()
    {
        FileHelper::removeDirectory($this->getPath());

        return ! (bool) $this->isExist();
    }

    /**
     * @return $this
     */
    public function clear()
    {
        FileHelper::removeDirectory($this->getPath());
        FileHelper::createDirectory($this->getPath());

        return $this;
    }

    /**
     * @return array<Dir>
     */
    public function findDirs()
    {
        $dir = $this->getPath();
        $files = array();

        if ( $dir [ strlen( $dir ) - 1 ] != '/' )
        {
            $dir .= '/';
        }

        $nDir = opendir( $dir );

        while ( false !== ( $file = readdir( $nDir ) ) )
        {
            if (!is_dir($dir . "/" .  $file))
            {
                continue;
            }


            if ($file != "." AND $file != ".."  )
            {
                $files [] = Dir::object($dir . $file);
            }
        }

        closedir( $nDir );

        return $files;
    }

    /**
     * @return File[]
     */
    public function findFiles()
    {
        $dir = $this->getPath();

        $files = array();

        if ( $dir [ strlen( $dir ) - 1 ] != '/' )
        {
            $dir .= '/';
        }

        $nDir = opendir( $dir );

        while ( false !== ( $file = readdir( $nDir ) ) )
        {
            if (!is_file($dir . "/" .  $file))
            {
                continue;
            }

            if ( $file != "." AND $file != ".." )
            {
                $files [] = File::object($dir . "/" .  $file);
            }
        }

        closedir( $nDir );

        return $files;
    }



    /**
     * @return FileSize
     */
    public function getSize()
    {
        if ($this->isExist())
        {
            $dir = $this->getPath();

            $totalsize=0;
            if ($dirstream = @opendir($dir)) {
                while (false !== ($filename = readdir($dirstream)))
                {
                    if ($filename!="." && $filename!="..")
                    {
                        if (is_file($dir."/".$filename))
                        {
                            $totalsize+=filesize($dir."/".$filename);
                        }

                        if (is_dir($dir."/".$filename))
                        {
                            $subdir = new self($dir."/".$filename);
                            $totalsize+= $subdir->getSize()->getBytes();
                        }
                    }
                }
            }
            closedir($dirstream);

            return FileSize::object($totalsize);
        }

        return FileSize::object(0);
    }

    /**
     * @return FileSize
     */
    public function size()
    {
        return $this->getSize();
    }
}