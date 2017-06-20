<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.08.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m160320_093837__alter_table__cms_storage_file extends Migration
{
    public function safeUp()
    {
        //m220319_093837__alter_table__cms_storage_file

        if ($this->db->createCommand('SELECT * FROM migration WHERE version="m220319_093837__alter_table__cms_storage_file"')->queryOne())
        {
            $this->db->createCommand()->delete('migration', 'version = "m220319_093837__alter_table__cms_storage_file"')->execute();
            return true;
        }

        $this->dropForeignKey('storage_file_created_by', "{{%cms_storage_file}}");
        $this->dropForeignKey('storage_file_updated_by', "{{%cms_storage_file}}");

        $this->addForeignKey(
            'storage_file_created_by', "{{%cms_storage_file}}",
            'created_by', '{{%cms_user}}', 'id', 'SET NULL', 'SET NULL'
        );

        $this->addForeignKey(
            'storage_file_updated_by', "{{%cms_storage_file}}",
            'updated_by', '{{%cms_user}}', 'id', 'SET NULL', 'SET NULL'
        );

    }

    public function safeDown()
    {
        $this->dropForeignKey('storage_file_created_by', "{{%cms_storage_file}}");
        $this->dropForeignKey('storage_file_updated_by', "{{%cms_storage_file}}");

        $this->addForeignKey(
            'storage_file_created_by', "{{%cms_storage_file}}",
            'created_by', '{{%cms_user}}', 'id', 'RESTRICT', 'RESTRICT'
        );

        $this->addForeignKey(
            'storage_file_updated_by', "{{%cms_storage_file}}",
            'updated_by', '{{%cms_user}}', 'id', 'RESTRICT', 'RESTRICT'
        );
    }
}