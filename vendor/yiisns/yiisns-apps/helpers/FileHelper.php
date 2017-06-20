<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.06.2016
 */
namespace yiisns\apps\helpers;

use yiisns\apps\components\imaging\Filter;

/**
 * Class FileHelper
 * @package yiisns\kernel\helpers
 */
class FileHelper extends \yii\helpers\FileHelper
{
    /**
     *
     * @param $file1
     * @return null|string
     */
    static public function getFirstExistingFile($file1 /*...*/)
    {
        $files = func_get_args();
        return self::getFirstExistingFileArray($files);
    }

    /**
     *
     * @param string[] $files
     * @return string|null
     */
    static public function getFirstExistingFileArray($files = [])
    {
        foreach ($files as $file)
        {
            if (file_exists(\Yii::getAlias($file)))
            {
                return $file;
            }
        }

        return null;
    }

    /**
     *
     * Search for files on all connected extensions
     *
     * @param string $fileName
     * @return array
     */
    static public function findExtensionsFiles($fileName = '/config/main.php', $onlyFileExists = true)
    {
        $configs     = [];

        $fileNames = [];
        if (is_string($fileName))
        {
            $fileNames[] = $fileName;
        } else if (is_array($fileName))
        {
            $fileNames = $fileName;
        }

        foreach ((array) \Yii::$app->extensions as $code => $data)
        {
            if (is_array($data['alias']))
            {
                $configTmp  = [];

                foreach ($data['alias'] as $code => $path)
                {
                    foreach ($fileNames as $fileName)
                    {
                        $file = $path . $fileName;
                        if ($onlyFileExists === true)
                        {
                            if (file_exists($file))
                            {
                                $configs[] = $file;
                            }
                        } else
                        {
                            $configs[] = $file;
                        }
                    }
                }
            }
        }

        return $configs;
    }
}