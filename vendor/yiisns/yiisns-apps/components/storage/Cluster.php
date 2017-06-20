<?php
/**
 * Storage
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.10.2016
 * @since 1.0.0
 */
namespace yiisns\apps\components\storage;

use Yii;
use yii\base\Component;
use yiisns\sx\File;
use yiisns\sx\Dir;
use yii\base\Model;

/**
 * Class Cluster
 * 
 * @package yiisns\apps\components\storage
 */
abstract class Cluster extends Model
{
    public $id;

    public $name;

    public $priority = 100;

    public $publicBaseUrl;
 // http://site.cn/uploads/
    public $rootBasePath;
 // /var/www/sites/site.cn/application/web/uploads/
    
    /**
     *
     * @var integer the level of sub-directories to store uploaded files. Defaults to 1.
     *      If the system has huge number of uploaded files (e.g. one million), you may use a bigger value
     *      (usually no bigger than 3). Using sub-directories is mainly to ensure the file system
     *      is not over burdened with a single directory having too many files.
     */
    public $directoryLevel = 3;

    /**
     *
     * @param $file
     * @return string $clusterFileUniqSrc
     */
    abstract public function upload(File $file);

    /**
     *
     * @param $clusterFileUniqSrc
     * @param $file
     * @return mixed
     */
    abstract public function update($clusterFileUniqSrc, $file);

    /**
     *
     * @param $clusterFileUniqSrc
     * @return mixed
     */
    abstract public function delete($clusterFileUniqSrc);

    /**
     *
     * @param $clusterFileUniqSrc
     * @return mixed
     */
    abstract public function deleteTmpDir($clusterFileUniqSrc);

    /**
     *
     * @param $clusterFileUniqSrc
     * @return string
     */
    public function rootTmpDir($clusterFileUniqSrc)
    {
        $file = new File($this->getRootSrc($clusterFileUniqSrc));
        return $file->getDirName() . "/" . $file->getFileName();
    }

    /**
     *
     * @param $clusterFileSrc
     * @return string
     */
    public function getRootSrc($clusterFileUniqSrc)
    {
        return $this->rootBasePath . DIRECTORY_SEPARATOR . $clusterFileUniqSrc;
    }

    /**
     * eg.
     * /uploads/all/f4/df/sadfsd/sdfsdfsd/asdasd.jpg
     *
     * @param $clusterFileSrc
     * @return string
     */
    public function getPublicSrc($clusterFileUniqSrc)
    {
        return $this->publicBaseUrl . '/' . $clusterFileUniqSrc;
    }

    /**
     *
     * @param $clusterFileUniqSrc
     * @return string
     */
    public function getAbsoluteUrl($clusterFileUniqSrc)
    {
        return $this->getPublicSrc($clusterFileUniqSrc);
    }

    /**
     *
     * @param $newName
     * @return string
     */
    public function getClusterDir($newName)
    {
        $localDir = '';
        
        if ($this->directoryLevel > 0) {
            $count = 0;
            for ($i = 0; $i < $this->directoryLevel; ++ $i) {
                $count ++;
                if (($prefix = substr($newName, $i + $i, 2)) !== false) {
                    if ($count > 1) {
                        $localDir .= DIRECTORY_SEPARATOR;
                    }
                    
                    $localDir .= $prefix;
                }
            }
        }
        
        return $localDir;
    }

    /**
     *
     * @param $originalFileName
     * @return string
     */
    protected function _generateClusterFileName(File $originalFileName)
    {
        $originalFileName->getExtension();
        // generate a unique file name
        $newName = md5(microtime() . rand(0, 100));
        return $originalFileName->getExtension() ? $newName . "." . $originalFileName->getExtension() : $newName;
    }

    /**
     *
     * @return float
     */
    public function getFreeSpace()
    {
        return 0;
    }

    /**
     *
     * @return float
     */
    public function getTotalSpace()
    {
        return 0;
    }

    /**
     *
     * @return float
     */
    public function getUsedSpace()
    {
        return (float) ($this->getTotalSpace() - $this->getFreeSpace());
    }

    /**
     *
     * @return float
     */
    public function getFreeSpacePct()
    {
        return ($this->getFreeSpace() * 100) / $this->getTotalSpace();
    }

    /**
     *
     * @return float
     */
    public function getUsedSpacePct()
    {
        return (float) (100 - $this->getFreeSpacePct());
    }
}