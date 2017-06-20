<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.07.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m150807_213220_alter_table__cms_content_property extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE {{%cms_content_property}} DROP INDEX `code`, ADD INDEX `code` (`code`) USING BTREE;");
        $this->execute("ALTER TABLE {{%cms_content_property}} ADD UNIQUE (code,content_id);");
    }

    public function down()
    {
        echo "m150807_213220_alter_table__cms_content_property cannot be reverted.\n";
        return false;
    }
}
