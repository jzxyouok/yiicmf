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

class m151030_173220_alter_table__cms_tree extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%cms_tree}}', 'redirect_tree_id', $this->integer());
        $this->createIndex('redirect_tree_id', '{{%cms_tree}}', 'redirect_tree_id');

        $this->addForeignKey(
            'cms_tree__redirect_tree_id', "{{%cms_tree}}",
            'redirect_tree_id', '{{%cms_tree}}', 'id', 'SET NULL', 'SET NULL'
        );
    }

    public function safeDown()
    {
        echo "m151030_173220_alter_table__cms_tree cannot be reverted.\n";
        return false;
    }
}