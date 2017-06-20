<?php
/**
 * m140902_110812_create_storage_file_table
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */
use yii\db\Schema;
use yii\db\Migration;

class m140902_110812_create_storage_file_table extends Migration
{
    public function up()
    {
        $tableExist = $this->db->getTableSchema("{{%storage_file}}", true);
        
        if ($tableExist) {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%storage_file}}", [
            'id' => $this->primaryKey(),
            'cluster_id' => $this->string(16)->comment(''),
            'cluster_file' => $this->string(255)->comment(''),
            'created_at' => $this->integer()->comment('创建人'),
            'updated_at' => $this->integer()->comment('更新人'),
            'created_by' => $this->integer()->comment('创建时间'),
            'updated_by' => $this->integer()->comment('更新时间'),
            'size' => $this->bigInteger(32)->comment(''),
            'mime_type' => $this->string(16)->comment(''),
            'extension' => $this->string(16)->comment(''),
            'original_name' => $this->string(16)->comment(''),
            'name_to_save' => $this->string(255)->comment(''),
            'name' => $this->string(32)->comment(''),
            'description_short' => $this->text()->comment(''),
            'description_full' => $this->text()->comment(''),
            'image_height' => $this->integer()->comment(''),
            'image_width' => $this->integer()->comment(''),
        ], $tableOptions);

        $this->createIndex('cluster_id_file', '{{%storage_file}}', ['cluster_id', 'cluster_file'], true);
        $this->createIndex('cluster_id', '{{%storage_file}}', ['cluster_id'], false);
        $this->createIndex('cluster_file', '{{%storage_file}}', ['cluster_file'], false);
        $this->createIndex('created_by', '{{%storage_file}}', ['created_by'], false);
        $this->createIndex('updated_by', '{{%storage_file}}', ['updated_by'], false);
        $this->createIndex('created_at', '{{%storage_file}}', ['created_at'], false);
        $this->createIndex('updated_at', '{{%storage_file}}', ['updated_at'], false);
        $this->createIndex('size', '{{%storage_file}}', ['size'], false);
        
        $this->createIndex('extension', '{{%storage_file}}', ['extension'], false);
        $this->createIndex('name_to_save', '{{%storage_file}}', ['name_to_save'], false);
        $this->createIndex('name', '{{%storage_file}}', ['name'], false);
        $this->createIndex('mime_type', '{{%storage_file}}', ['mime_type'], false);
        $this->createIndex('image_height', '{{%storage_file}}', ['image_height'], false);
        $this->createIndex('image_width', '{{%storage_file}}', ['image_width'], false);
        
        $this->execute("ALTER TABLE {{%storage_file}} COMMENT = 'Files';");

        $this->addForeignKey(
            'storage_file_created_by', "{{%storage_file}}",
            'created_by', '{{%user}}', 'id', 'SET NULL', 'SET NULL'
        );

        $this->addForeignKey(
            'storage_file_updated_by', "{{%storage_file}}",
            'updated_by', '{{%user}}', 'id', 'SET NULL', 'SET NULL'
        );
    }

    public function down()
    {
        $this->dropForeignKey("storage_file_created_by", "{{%storage_file}}");
        $this->dropForeignKey("storage_file_updated_by", "{{%storage_file}}");

        $this->dropTable("{{%storage_file}}");
    }
}
