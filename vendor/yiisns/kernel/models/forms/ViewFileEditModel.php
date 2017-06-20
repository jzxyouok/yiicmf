<?php
/**
 * SignupForm
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */

namespace yiisns\kernel\models\forms;

use yiisns\kernel\models\UserEmail;
use yiisns\kernel\models\User;

use Yii;
use yii\base\Model;

/**
 * Class ViewFileEditModel
 * @package yiisns\kernel\models\forms
 */
class ViewFileEditModel extends Model
{
    public $rootViewFile;

    public $error;

    public $source;

    public function init()
    {
        parent::init();

        if (is_readable($this->rootViewFile) && file_exists($this->rootViewFile))
        {
            $fp = fopen ($this->rootViewFile, 'a+');
            if ($fp)
            {
                $content = fread ( $fp, filesize($this->rootViewFile) );
                fclose ( $fp );
                $this->source = $content;

            } else
            {
                $this->error = \Yii::t('yiisns/kernel', 'File is not exist or is not readable');
            }
        }
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'source' => \Yii::t('yiisns/kernel', 'Code'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['rootViewFile', 'string'],
            ['source', 'string'],
        ];
    }

    /**
     * @return bool
     */
    public function saveFile()
    {
        if (is_writable($this->rootViewFile) && file_exists($this->rootViewFile))
        {
            $file = fopen($this->rootViewFile, 'w');
            fwrite($file, $this->source);
            fclose($file);

            return true;
        }
        return false;
    }
}