<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 11.12.2016
 * @since 1.0.0
 */
namespace yiisns\apps\components;

use yiisns\apps\components\imaging\Filter;
use yiisns\apps\helpers\UrlHelper;

use Yii;
use yii\base\Component;
use yii\base\Exception;

/**
 * Class Imaging
 * 
 * @package yiisns\kernel\components
 */
class Imaging extends Component
{
    /**
     *
     * @var array 
     */
    public $extensions = [
        'jpg',
        'png',
        'jpeg',
        'gif'
    ];

    /**
     *
     * @var string
     */
    public $sold = 'sold_for_check_params';

    const THUMBNAIL_PREFIX = 'sx-filter__';

    const DEFAULT_THUMBNAIL_FILENAME = "sx-file";

    /**
     * @param $originalSrc
     * @param Filter $filter
     * @param string $nameForSave
     * @return string
     */
    public function thumbnailUrlOnRequest($originalSrc, Filter $filter, $nameForSave = '')
    {
        $originalSrc = (string) $originalSrc;
        $extension = static::getExtension($originalSrc);
        
        if (! $extension) {
            return $originalSrc;
        }
        
        if (! $this->isAllowExtension($extension)) {
            return $originalSrc;
        }
        
        if (! $nameForSave) {
            $nameForSave = static::DEFAULT_THUMBNAIL_FILENAME;
        }
        
        $params = [];
        if ($filter->getConfig()) {
            $params = $filter->getConfig();
        }
        
        $replacePart = DIRECTORY_SEPARATOR . static::THUMBNAIL_PREFIX . $filter->id . ($params ? DIRECTORY_SEPARATOR . $this->getParamsCheckString($params) : "") . DIRECTORY_SEPARATOR . $nameForSave;
        
        $imageSrcResult = str_replace('.' . $extension, $replacePart . '.' . $extension, $originalSrc);
        
        if ($params) {
            $imageSrcResult = $imageSrcResult . '?' . http_build_query($params);
        }
        
        return $imageSrcResult;
    }

    /**
     *
     * @param $extension
     * @return bool
     */
    public function isAllowExtension($extension)
    {
        return (bool) in_array(strtolower($extension), $this->extensions);
    }

    /**
     *
     * @param $filePath
     * @return string|bool
     */
    static public function getExtension($filePath)
    {
        $parts = explode('.', $filePath);
        $extension = end($parts);
        
        if (! $extension) {
            return false;
        }
        
        $extension = explode("?", $extension);
        $extension = $extension[0];
        return $extension;
    }

    /**
     *
     * @param array $params            
     * @return string
     */
    public function getParamsCheckString($params = [])
    {
        if ($params) {
            return md5($this->sold . http_build_query($params));
        }
        
        return '';
    }

    /**
     * 
     * @param $imageSrc
     * @param Filter $filter            
     */
    public function getImagingUrl($imageSrc, Filter $filter)
    {
        return $this->thumbnailUrlOnRequest($imageSrc, $filter);
    }

    /**
     *
     * @param $filterCode
     * @return string
     */
    protected function _assembleParams(Filter $filter)
    {
        /*
         * $params[] = $filter->getId();
         *
         * if ($filter->getConfig())
         * {
         * $params[] = $filter->getConfig();
         * }
         *
         * $result = String::compressBase64EncodeUrl($params);
         *
         * $result = str_split($result, $this->splitLongNames);
         * $result = implode('/', $result);
         *
         * return $result;
         */
    }
}