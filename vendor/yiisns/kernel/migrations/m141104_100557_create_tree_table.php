<?php
/**
 * m141104_100557_create_tree_table
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */
use yii\db\Schema;
use yii\db\Migration;

class m141104_100557_create_tree_table extends Migration
{
    public function up()
    {
        $tableExist = $this->db->getTableSchema("{{%tree}}", true);
        
        if ($tableExist) {
            $this->dropTable("{{%tree}}");
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%tree}}", [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->comment('创建人'),
            'updated_at' => $this->integer()->comment('更新人'),
            'created_by' => $this->integer()->comment('创建时间'),
            'updated_by' => $this->integer()->comment('更新时间'),
            'name' => $this->string(255)->notNull()->comment(''),
            'image_id' => $this->integer()->comment(''),
            'image_full_id' => $this->integer()->comment(''),
            'description_short' => $this->longText()->comment(''),
            'description_full' => $this->longText()->comment(''),
            'code' => $this->string(64)->comment(''),
            'pid' => $this->integer()->comment(''),
            'pids' => $this->string(255)->comment(''),
            'level' => $this->integer()->comment(''),
            'dir' => $this->text()->comment(''),
            'has_children' => $this->smallInteger()->comment(''),
            'priority' => $this->integer()->notNull()->comment(''),
            'published_at' => $this->integer()->notNull()->comment(''), 
            'redirect' => $this->string(500)->comment(''), 
            'tree_menu_ids' => $this->string(500)->comment(''), 
            //'active'
            'meta_title' => $this->string(500)->comment(''),  
            'meta_description' => $this->text()->comment(''),
            'meta_keywords' => $this->text()->comment(''),
            //'site_code' => ->notNull()
            'tree_type_id' => $this->integer()->comment(''),
            'description_short_type' => $this->string(10)-notNull()->comment(''),
            'description_full_type' => $this->string(10)-notNull()->comment(''),
            'redirect_tree_id' => $this->integer()->comment(''),
            'redirect_code' => $this->integer()-notNull()->comment(''),
            'name_hidden' => $this->string(255)->comment(''), 
            'view_file' => $this->string(128)->comment(''),
        ], $tableOptions);

        $this->createIndex('pid_code', '{{%tree}}', ['pid', 'code'], true);
        $this->createIndex('created_by', '{{%tree}}', ['created_by'], false);
        $this->createIndex('updated_by', '{{%tree}}', ['updated_by'], false);
        $this->createIndex('created_at', '{{%tree}}', ['created_at'], false);
        $this->createIndex('updated_at', '{{%tree}}', ['updated_at'], false);
        
        $this->createIndex('name', '{{%tree}}', ['name'], false);
        $this->createIndex('seo_page_name', '{{%tree}}', ['seo_page_name'], false);
        $this->createIndex('pid', '{{%tree}}', ['pid'], false);
        $this->createIndex('pids', '{{%tree}}', ['pids'], false);
        $this->createIndex('level', '{{%tree}}', ['level'], false);    
        $this->createIndex('priority', '{{%tree}}', ['priority'], false);
        $this->createIndex('has_children', '{{%tree}}', ['has_children'], false);  
        $this->createIndex('published_at', '{{%tree}}', ['published_at'], false);
        $this->createIndex('redirect', '{{%tree}}', ['redirect'], false);
        $this->createIndex('', '{{%tree}}', [''], false);
        $this->createIndex('', '{{%tree}}', [''], false);
        $this->createIndex('', '{{%tree}}', [''], false);
        $this->createIndex('', '{{%tree}}', [''], false);
        $this->createIndex('', '{{%tree}}', [''], false);
        $this->createIndex('', '{{%tree}}', [''], false);
        $this->createIndex('', '{{%tree}}', [''], false);
        
        $this->execute("ALTER TABLE {{%tree}} COMMENT = '页面结构树';");



        $this->addForeignKey(
            'cms_tree_pid_cms_tree', "{{%tree}}",
            'pid', '{{%tree}}', 'id', 'RESTRICT', 'RESTRICT'
        );

        $this->addForeignKey(
            'pid_main_pid_cms_tree', "{{%tree}}",
            'pid_main', '{{%tree}}', 'id', 'RESTRICT', 'RESTRICT'
        );


        $this->addForeignKey(
            'cms_tree_created_by', "{{%tree}}",
            'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT'
        );

        $this->addForeignKey(
            'cms_tree_updated_by', "{{%tree}}",
            'updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT'
        );

    }

    public function down()
    {
        $this->dropForeignKey("pid_main_pid_tree", "{{%tree}}");
        $this->dropForeignKey("tree_pid_cms_tree", "{{%tree}}");
        $this->dropForeignKey("tree_created_by", "{{%tree}}");
        $this->dropForeignKey("tree_updated_by", "{{%tree}}");

        $this->dropTable("{{%tree}}");
    }
}