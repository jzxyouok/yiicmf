<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.08.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m160522_093837__create_table__cms_admin_filter extends Migration
{
    public function safeUp()
    {
        $tableExist = $this->db->getTableSchema("{{%cms_admin_filter}}", true);
        if ($tableExist)
        {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%cms_admin_filter}}", [
            'id'                    => $this->primaryKey(),

            'created_by'            => $this->integer(),
            'updated_by'            => $this->integer(),

            'created_at'            => $this->integer(),
            'updated_at'            => $this->integer(),

            'cms_user_id'           => $this->integer(),
            'is_default'            => $this->integer(),

            'name'                  => $this->string(64),
            'namespace'             => $this->string(255)->notNull(),

            'values'                => $this->text()->comment('Values filters'),
            'visibles'              => $this->text()->comment('Visible fields'),

        ], $tableOptions);

        $this->createIndex('updated_by', '{{%cms_admin_filter}}', 'updated_by');
        $this->createIndex('created_by', '{{%cms_admin_filter}}', 'created_by');
        $this->createIndex('created_at', '{{%cms_admin_filter}}', 'created_at');
        $this->createIndex('updated_at', '{{%cms_admin_filter}}', 'updated_at');

        $this->createIndex('cms_user_id', '{{%cms_admin_filter}}', 'cms_user_id');
        $this->createIndex('unique_default', '{{%cms_admin_filter}}', ['cms_user_id', 'is_default', 'namespace']);

        $this->execute("ALTER TABLE {{%cms_admin_filter}} COMMENT = 'Filters in the administrative part';");

        $this->addForeignKey(
            'cms_admin_filter__created_by', "{{%cms_admin_filter}}",
            'created_by', '{{%cms_user}}', 'id', 'SET NULL', 'SET NULL'
        );

        $this->addForeignKey(
            'cms_admin_filter__updated_by', "{{%cms_admin_filter}}",
            'updated_by', '{{%cms_user}}', 'id', 'SET NULL', 'SET NULL'
        );

        $this->addForeignKey(
            'cms_admin_filter__cms_user_id', "{{%cms_admin_filter}}",
            'cms_user_id', '{{%cms_user}}', 'id', 'CASCADE', 'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey("cms_admin_filter__created_by", "{{%cms_admin_filter}}");
        $this->dropForeignKey("cms_admin_filter__updated_by", "{{%cms_admin_filter}}");

        $this->dropTable("{{%cms_admin_filter}}");
    }
}