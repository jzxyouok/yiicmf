<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 21.05.2016
 */
use yii\db\Schema;
use yii\db\Migration;

class m150521_183310_alter_table__cms_tree extends Migration
{
    public function safeUp()
    {

        $this->execute("ALTER TABLE {{%cms_tree%}} DROP `main_root`;");
    }

    public function down()
    {
        echo "m150521_183310_alter_table__cms_tree cannot be reverted.\n";
        return false;
    }
}
