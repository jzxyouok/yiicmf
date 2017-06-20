<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.08.2015
 */
use yii\db\Schema;
use yii\db\Migration;
use yii\helpers\Json;

class m150923_183220_alter_table__tree__content_element extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE {{%cms_tree}} CHANGE `files` `files_depricated` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;;");
        $this->execute("ALTER TABLE {{%cms_content_element}} CHANGE `files` `files_depricated` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;;");
    }

    public function safeDown()
    {
        echo "m150923_173220_update_data__images_and_files cannot be reverted.\n";
        return false;
    }
}