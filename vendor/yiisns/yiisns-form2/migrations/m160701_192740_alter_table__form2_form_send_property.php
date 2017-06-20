<?php
use yii\db\Schema;
use yii\db\Migration;

class m160701_192740_alter_table__form2_form_send_property extends Migration
{
    public function up()
    {
        $this->dropIndex('value', '{{%form2_form_send_property}}');
        $this->execute("ALTER TABLE {{%form2_form_send_property}} CHANGE `value` `value` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
    }

    public function down()
    {
        echo "m160701_192740_alter_table__form2_form_send_property cannot be reverted.\n";
        return false;
    }
}