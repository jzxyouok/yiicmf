<?php
use yii\db\Schema;
use yii\db\Migration;

class m150615_192740_create_table__form2_form_send_property extends Migration
{
    public function up()
    {
        $tableExist = $this->db->getTableSchema("{{%form2_form_send_property}}", true);
        if ($tableExist)
        {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%form2_form_send_property}}", [
            'id'                    => Schema::TYPE_PK,

            'created_by'            => Schema::TYPE_INTEGER . ' NULL',
            'updated_by'            => Schema::TYPE_INTEGER . ' NULL',

            'created_at'            => Schema::TYPE_INTEGER . ' NULL',
            'updated_at'            => Schema::TYPE_INTEGER . ' NULL',

            'property_id'           => Schema::TYPE_INTEGER . ' NULL',
            'element_id'            => Schema::TYPE_INTEGER . ' NULL',

            'value'                 => Schema::TYPE_STRING . '(255) NOT NULL',

            'value_enum'            => Schema::TYPE_INTEGER . '(11) NULL',
            'value_num'             => 'decimal(18,4) NULL',
            'description'           => Schema::TYPE_STRING . '(255) NULL',

        ], $tableOptions);

        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(updated_by);");
        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(created_by);");

        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(created_at);");
        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(updated_at);");

        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(property_id);");
        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(element_id);");

        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(value);");
        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(value_enum);");
        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(value_num);");
        $this->execute("ALTER TABLE {{%form2_form_send_property}} ADD INDEX(description);");

        $this->execute("ALTER TABLE {{%form2_form_send_property}} COMMENT = '';");

        $this->addForeignKey(
            'form2_form_send_property_created_by', "{{%form2_form_send_property}}",
            'created_by', '{{%cms_user}}', 'id', 'SET NULL', 'SET NULL'
        );

        $this->addForeignKey(
            'form2_form_send_property_updated_by', "{{%form2_form_send_property}}",
            'updated_by', '{{%cms_user}}', 'id', 'SET NULL', 'SET NULL'
        );

        $this->addForeignKey(
            'form2_form_send_property_element_id', "{{%form2_form_send_property}}",
            'element_id', '{{%form2_form_send}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'form2_form_send_property_property_id', "{{%form2_form_send_property}}",
            'property_id', '{{%form2_form_property}}', 'id', 'CASCADE', 'CASCADE'
        );
    }

    public function down()
    {
        echo "m150615_192740_create_table__form2_form_send_property cannot be reverted.\n";
        return false;
    }
}