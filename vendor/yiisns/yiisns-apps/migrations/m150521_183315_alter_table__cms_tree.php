<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 21.05.2016
 */
use yii\db\Schema;
use yii\db\Migration;

class m150521_183315_alter_table__cms_tree extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey("pid_main_pid_cms_tree", "{{%cms_tree%}}");
        //$this->execute("ALTER TABLE {{%cms_tree%}} DROP INDEX pid_main;");
        $this->execute("ALTER TABLE {{%cms_tree%}} DROP `pid_main`;");
    }

    public function down()
    {
        echo "m150521_183315_alter_table__cms_tree cannot be reverted.\n";
        return false;
    }
}
