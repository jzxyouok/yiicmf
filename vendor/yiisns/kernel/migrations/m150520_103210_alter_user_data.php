<?php
/**
 * m150520_103210_alter_user_data
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */
use yii\db\Schema;
use yii\db\Migration;

class m150520_103210_alter_user_data extends Migration
{
    public function safeUp()
    {
        $this->addForeignKey(
         'yiisns_user_image_id', '{{%user}}', 'image_id', '{{%storage_file}}', 'id', 'SET NULL', 'SET NULL'
        );
        $this->execute("ALTER TABLE {{%user}} ADD `active` CHAR(1) NOT NULL DEFAULT 'Y' ;");
        $this->execute("ALTER TABLE {{%user}} ADD `gender` ENUM(\"men\",\"women\") NOT NULL DEFAULT 'men' ;");
        $this->execute("ALTER TABLE {{%user}} COMMENT = 'User Table';");
        
        
    }

    public function down()
    {
        echo "m150520_103210_alter_user_data cannot be reverted.\n";
        return false;
    }
}