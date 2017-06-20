<?php
use yii\db\Schema;
use yii\db\Migration;

class m150615_172718_create_table__form2_form_property extends Migration
{
    public function up()
    {
        $tableExist = $this->db->getTableSchema("{{%form2_form_property}}", true);
        if ($tableExist)
        {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%form2_form_property}}", [
            'id'                    => Schema::TYPE_PK,

            'created_by'            => Schema::TYPE_INTEGER . ' NULL',
            'updated_by'            => Schema::TYPE_INTEGER . ' NULL',

            'created_at'            => Schema::TYPE_INTEGER . ' NULL',
            'updated_at'            => Schema::TYPE_INTEGER . ' NULL',

            'name'                  => Schema::TYPE_STRING . '(255) NOT NULL',
            'code'                  => Schema::TYPE_STRING . '(64) NULL',

            'active'                => "CHAR(1) NOT NULL DEFAULT 'Y'",
            'priority'              => "INT NOT NULL DEFAULT '500'",
            'property_type'         => "CHAR(1) NOT NULL DEFAULT 'S'",
            'list_type'             => "CHAR(1) NOT NULL DEFAULT 'L'",
            'multiple'              => "CHAR(1) NOT NULL DEFAULT 'N'",
            'multiple_cnt'          => "INT NULL",
            'with_description'      => "CHAR(1) NULL",
            'searchable'            => "CHAR(1) NOT NULL DEFAULT 'N'",
            'filtrable'             => "CHAR(1) NOT NULL DEFAULT 'N'",
            'is_required'           => "CHAR(1) NULL",
            'version'               => "INT NOT NULL DEFAULT '1'",
            'component'             => "VARCHAR(255) NULL",
            'component_settings'    => "TEXT NULL",
            'hint'                  => "VARCHAR(255) NULL",
            'smart_filtrable'       => "CHAR(1) NOT NULL DEFAULT 'N'",

            'form_id'               => Schema::TYPE_INTEGER . ' NULL',

        ], $tableOptions);

        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(updated_by);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(created_by);");

        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(created_at);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(updated_at);");

        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(name);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD UNIQUE(code,form_id);");

        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(active);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(priority);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(property_type);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(list_type);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(multiple);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(multiple_cnt);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(with_description);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(searchable);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(filtrable);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(is_required);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(version);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(component);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(hint);");
        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(smart_filtrable);");

        $this->execute("ALTER TABLE {{%form2_form_property}} ADD INDEX(form_id);");

        $this->execute("ALTER TABLE {{%form2_form_property}} COMMENT = '';");

        $this->addForeignKey(
            'form2_form_property_created_by', "{{%form2_form_property}}",
            'created_by', '{{%cms_user}}', 'id', 'SET NULL', 'SET NULL'
        );

        $this->addForeignKey(
            'form2_form_property_updated_by', "{{%form2_form_property}}",
            'updated_by', '{{%cms_user}}', 'id', 'SET NULL', 'SET NULL'
        );

        $this->addForeignKey(
            'form2_form_property_form2_form', "{{%form2_form_property}}",
            'form_id', '{{%form2_form}}', 'id', 'CASCADE', 'CASCADE'
        );
    }

    public function down()
    {
        echo "m150615_172718_create_table__form2_form_property cannot be reverted.\n";
        return false;
    }
}