<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.04.2016
 */
namespace yiisns\sshConsole;

use yii\base\Widget;
use yii\helpers\Json;

/**
 * Class SshConsoleWidget
 * 
 * @package yiisns\kernel\sshConsole
 */
class SshConsoleWidget extends Widget
{
    public $consoleHeight = '600px';

    public $consoleWidth = '100%';

    public $iframeId = '';

    public function init()
    {
        parent::init();
        
        if (! $this->iframeId) {
            $this->iframeId = 'sx-iframe-' . $this->id;
        }
    }

    public function run()
    {
        if (! function_exists('system')) {
            return $this->render('ssh-no-console', [
                'widget' => $this
            ]);
        } else {
            return $this->render('ssh-console', [
                'widget' => $this
            ]);
        }
    }

    /**
     *
     * @return string
     */
    public function getClientOptionsJson()
    {
        return Json::encode([
            'id' => $this->id,
            'iframeId' => $this->iframeId
        ]);
    }
}