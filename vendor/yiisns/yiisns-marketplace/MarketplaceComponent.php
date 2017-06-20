<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
namespace yiisns\marketplace;

use yiisns\kernel\helpers\Curl;

use Yii;
use yii\base\Component;
use yii\web\Application;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * @property string $url;
 * @property string $baseUrl;
 *
 * Class MarketplaceComponent
 * @package yiisns\kernel\agent
 */
class MarketplaceComponent extends Component
{
    const RESPONSE_FORMAT_JSON = 'json';

    public $schema          = 'http';
    public $host            = 'api.yiisns.cn';
    public $version         = 'v1';

    public $responseFormat  = self::RESPONSE_FORMAT_JSON;

    /**
     *
     * Пример http://api.yiisns.cn/v1/
     *
     * @return string
     */
    public function getUrl()
    {
        if ($this->version)
        {
            return $this->baseUrl . $this->version . "/";
        }

        return $this->baseUrl;
    }

    /**
     *
     * Пример https://api.yiisns.cn/
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->schema . "://" . $this->host . "/";
    }

    /**
     * @param $route
     * @return string
     */
    public function getRequestUrl($route)
    {
        $data = [];
        $url = $this->url;

        if (is_string($route))
        {
            $url = $this->url . $route;
        } else if (is_array($route))
        {
            $route = $route[0];
            if (isset($route[1]))
            {
                $data = $route[1];
            }
            $url = $this->url . $route;

            if (!$data || !is_array($data))
            {
                $data = [];
            }

            $data = array_merge($data, [
                'sx-serverName' => \Yii::$app->request ? \Yii::$app->request->serverName : "",
                'sx-version'    => (\Yii::$app->appSettings && \Yii::$app->appSettings->descriptor) ? \Yii::$app->appSettings->descriptor->version : "",
                'sx-email'      => (\Yii::$app->appSettings && \Yii::$app->appSettings->adminEmail) ? \Yii::$app->appSettings->adminEmail : "",
            ]);

            if ($data)
            {
                $url .= '?' . http_build_query($data);
            }
        }

        return $url;
    }

    /**
     * @param string $method
     * @param string|array $route
     * @return Curl
     * @throws \yii\base\Exception
     */
    public function request($method, $route)
    {
        $curl = new Curl();

        $curl->setOption(CURLOPT_HTTPHEADER, [
            'Accept: application/' . $this->responseFormat. '; q=1.0, */*; q=0.1'
        ]);

        $curl->setOption(CURLOPT_TIMEOUT, 2);

        try
        {
            $url = $this->getRequestUrl($route);
            /*\Yii::info("Api request: " . $method . ": " . $url, self::className());*/
            $curl->httpRequest($method, $url);
        } catch (\Exception $e)
        {
            \Yii::error($e->getMessage(), self::className());
        }


        return $curl;
    }

    /**
     * @param $route
     * @return array
     */
    public function fetch($route)
    {
        $curl = $this->request(Curl::METHOD_GET, $route);

        if ($curl->responseCode == 200 && $curl->response)
        {
            return Json::decode($curl->response);
        }

        return [];
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        $key = 'sx-yiisns-info';

        $result = \Yii::$app->cache->get($key);
        if ($result === false)
        {
            $result = $this->fetch(['info']);
            \Yii::$app->cache->set($key, $result, (60*60*6) );
        }

        return $result;
    }
}