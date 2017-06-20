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

use yiisns\kernel\models\StorageFile;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\helpers\BaseUrl;
use yiisns\sx\File;
use yiisns\sx\Dir;

/*
 * interface Storage
 * {
 * public function add($file);
 * public function update($storageFileSrc, $file);
 * public function delete($storageFileSrc);
 * }
 */

/**
 *
 * @property Cluster[] $clusters Class Storage
 * @package yiisns\apps\components\Storage
 */
class Storage extends Component
{
    public $components = [];

    /**
     *
     * @param UploadedFile|string|File $file            
     * @param array $data            
     * @param null $clusterId            
     *
     * @return StorageFile
     * @throws Exception
     */
    public function upload($file, $data = [], $clusterId = null)
    {
        $tmpdir = Dir::runtimeTmp();
        $tmpfile = $tmpdir->newFile();
        
        if ($file instanceof UploadedFile) {
            $extension = File::object($file->name)->getExtension();
            $tmpfile->setExtension($extension);
            
            if (! $file->saveAs($tmpfile->getPath())) {
                throw new Exception(\Yii::t('yiisns/kernel', 'The file was not loaded into the temporary directory'));
            }
        } else 
            if ($file instanceof File || (is_string($file) && BaseUrl::isRelative($file))) {
                $file = File::object($file);
                $tmpfile->setExtension($file->getExtension());
                $tmpfile = $file->move($tmpfile);
            } else 
                if (is_string($file) && ! BaseUrl::isRelative($file)) {
                    $curl_session = curl_init($file);
                    
                    if (! $curl_session) {
                        throw new Exception(\Yii::t('yiisns/kernel', 'The wrong link'));
                    }
                    
                    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_session, CURLOPT_BINARYTRANSFER, true);
                    curl_setopt($curl_session, CURLOPT_FOLLOWLOCATION, true);
                    
                    $file_content = curl_exec($curl_session);
                    
                    curl_close($curl_session);
                    
                    if (! $file_content) {
                        throw new Exception(\Yii::t('yiisns/kernel', 'Failed to download the file'));
                    }
                    
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    $pos = strpos($extension, '?');
                    
                    if ($pos === false) {} else {
                        $extension = substr($extension, 0, $pos);
                    }
                    
                    if ($extension) {
                        $tmpfile->setExtension($extension);
                    }
                    
                    $is_file_saved = file_put_contents($tmpfile, $file_content);
                    
                    if (! $is_file_saved) {
                        throw new Exception(\Yii::t('yiisns/kernel', 'could not save file'));
                    }
                    
                    if (! $extension) {
                        $tmpfile = new File($tmpfile->getPath());
                        
                        try {
                            $mimeType = FileHelper::getMimeType($tmpfile->getPath(), null, false);
                        } catch (InvalidConfigException $e) {
                            throw new Exception("Don't have the file extension: " . $e->getMessage());
                        }
                        
                        if (! $mimeType) {
                            throw new Exception("Don't have the file extension");
                        }
                        
                        $extensions = FileHelper::getExtensionsByMimeType($mimeType);
                        if ($extensions) {
                            if (in_array('jpg', $extensions)) {
                                $extension = 'jpg';
                            } else 
                                if (in_array('png', $extensions)) {
                                    $extension = 'png';
                                } else {
                                    $extension = $extensions[0];
                                }
                            
                            $newFile = new File($tmpfile->getPath());
                            $newFile->setExtension($extension);
                            
                            $tmpfile = $tmpfile->copy($newFile);
                        }
                    }
                } else {
                    throw new Exception("The file should be defined as \yii\web\UploadedFile or \yiisns\sx\File or string");
                }
        $data['mime_type'] = $tmpfile->getMimeType();
        $data['size'] = $tmpfile->size()->getBytes();
        $data['extension'] = $tmpfile->getExtension();
        
        if ($tmpfile->getType() == 'image') {
            if (extension_loaded('gd')) {
                list ($width, $height, $type, $attr) = getimagesize($tmpfile->toString());
                $data['image_height'] = $height;
                $data['image_width'] = $width;
            }
        }
        
        if ($cluster = $this->getCluster($clusterId)) {
            if ($newFileSrc = $cluster->upload($tmpfile)) {
                $data = array_merge($data, [
                    'cluster_id' => $cluster->id,
                    'cluster_file' => $newFileSrc
                ]);
            }
        }
        
        $file = new StorageFile($data);
        $file->save(false);
        
        return $file;
    }

    protected $_clusters = null;

    /**
     *
     * @return Cluster[]
     */
    public function getClusters()
    {
        if ($this->_clusters === null) {
            ArrayHelper::multisort($this->components, 'priority');
            
            foreach ($this->components as $id => $data) {
                if (! is_int($id)) {
                    $data['id'] = $id;
                }
                
                $cluster = \Yii::createObject($data);
                $this->_clusters[$cluster->id] = $cluster;
            }
        }
        return $this->_clusters;
    }

    /**
     *
     * @param null $id            
     * @return Cluster
     */
    public function getCluster($id = null)
    {
        if ($id == null) {
            foreach ($this->clusters as $clusterId => $cluster) {
                return $cluster;
            }
        } else {
            return ArrayHelper::getValue($this->clusters, $id);
        }
    }
}