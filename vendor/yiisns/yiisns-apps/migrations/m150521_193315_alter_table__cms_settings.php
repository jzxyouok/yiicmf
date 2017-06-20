<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 21.05.2016
 */
use yii\db\Schema;
use yii\db\Migration;

class m150521_193315_alter_table__cms_settings extends Migration
{
    public function safeUp()
    {
        $this->renameTable("cms_settings", "cms_component_settings");
    }

    public function down()
    {
        echo "m150521_193315_alter_table__cms_settings cannot be reverted.\n";
        return false;
    }
}
