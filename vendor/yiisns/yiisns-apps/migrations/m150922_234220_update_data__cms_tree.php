<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.07.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m150922_234220_update_data__cms_tree extends Migration
{
    public function safeUp()
    {
        if ($models = \yiisns\kernel\models\Tree::find()->all())
        {
            /**
             * @var $model \yiisns\kernel\models\Tree
             */
            foreach ($models as $model)
            {
                if (!method_exists($model, 'getMainImageSrc'))
                {
                    continue;
                }

                //$user->getFiles()
                $imageSrc = $model->getMainImageSrcOld();
                if ($imageSrc)
                {
                    $storageFile = \yiisns\kernel\models\CmsStorageFile::find()->where(['src' => $imageSrc])->one();
                    if ($storageFile)
                    {
                        $model->image_id = $storageFile->id;
                        $model->image_full_id = $storageFile->id;

                        $model->save(false);
                    }
                }
            }
        }
    }

    public function down()
    {
        echo "m150922_234220_update_data__cms_tree cannot be reverted.\n";
        return false;
    }
}
