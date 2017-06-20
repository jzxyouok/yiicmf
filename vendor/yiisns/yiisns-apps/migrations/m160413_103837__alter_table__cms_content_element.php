<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.08.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m160413_103837__alter_table__cms_content_element extends Migration
{
    public function safeUp()
    {
        $this->dropColumn("{{%cms_content_element}}", "files_depricated");
        $this->dropColumn("{{%cms_tree}}", "files_depricated");
    }

    public function safeDown()
    {
        echo "m160413_103837__alter_table__cms_content_element cannot be reverted.\n";
        return false;
    }
}