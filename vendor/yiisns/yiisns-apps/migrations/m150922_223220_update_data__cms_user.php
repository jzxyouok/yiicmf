<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.07.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m150922_223220_update_data__cms_user extends Migration
{
    public function safeUp()
    {
        if ($users = \yiisns\kernel\models\User::find()->all())
        {
            /**
             * @var $user \yiisns\kernel\models\User
             */
            foreach ($users as $user)
            {
                if (!method_exists($user, 'getMainImageSrc'))
                {
                    continue;
                }

                //$user->getFiles()
                $imageSrc = $user->getMainImageSrc();
                if ($imageSrc)
                {
                    $storageFile = \yiisns\kernel\models\CmsStorageFile::find()->where(['src' => $imageSrc])->one();
                    if ($storageFile)
                    {
                        $user->image_id = $storageFile->id;
                        $user->save(false);
                    }
                }
            }
        }
    }

    public function down()
    {
        echo "m150922_223220_update_data__cms_user cannot be reverted.\n";
        return false;
    }
}
