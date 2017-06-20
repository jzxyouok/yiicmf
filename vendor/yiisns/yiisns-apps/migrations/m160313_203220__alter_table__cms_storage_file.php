<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 21.02.2016
 */
use yii\db\Schema;
use yii\db\Migration;
use yii\helpers\Json;

class m160313_203220__alter_table__cms_storage_file extends Migration
{
    public function safeUp()
    {
        $this->dropIndex('linked_to_model', '{{%cms_storage_file}}');
        $this->dropColumn('{{%cms_storage_file}}', 'linked_to_model');

        $this->dropIndex('linked_to_value', '{{%cms_storage_file}}');
        $this->dropColumn('{{%cms_storage_file}}', 'linked_to_value');

        $this->dropIndex('type', '{{%cms_storage_file}}');
        $this->dropColumn('{{%cms_storage_file}}', 'type');

        $this->dropIndex('published_at', '{{%cms_storage_file}}');
        $this->dropColumn('{{%cms_storage_file}}', 'published_at');

        $this->dropIndex('src', '{{%cms_storage_file}}');
        $this->dropColumn('{{%cms_storage_file}}', 'src');
    }

    public function safeDown()
    {
        echo "m160313_203220__alter_table__cms_storage_file cannot be reverted.\n";
        return false;
    }
}