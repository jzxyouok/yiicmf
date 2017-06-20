<?php
/**
 * m140801_201442_create_user_table
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */
use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m140801_201442_create_user_table
 */
class m140801_201442_create_user_table extends Migration
{
    public function up()
    {
        $tableExist = $this->db->getTableSchema("{{%user}}", true);
        
        if ($tableExist) {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment('用户名'),
            'auth_key' => $this->string(32)->notNull()->comment('密钥'),
            'password_hash' => $this->string()->notNull()->comment('密码'),
            'password_reset_token' => $this->string()->comment('恢复密码Token'),
            'name' => $this->string()->notNull()->comment('昵称'),
            'image_id' => $this->integer()->comment('头像ID'),
            'email' => $this->string()->notNull()->unique()->comment('邮箱'),
            'phone' => $this->string(64)->notNull()->unique()->comment('电话号码'),
            'logged_at' => $this->integer()->comment('登录时间'),
            'last_activity_at' => $this->integer()->comment('最后活动时间'),
            'last_admin_activity_at' => $this->integer()->comment('管理员最后活动时间'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
            'email_is_approved' => $this->integer()->defaultValue(0)->comment('邮箱获得批准'),
            'phone_is_approved' => $this->integer()->defaultValue(0)->comment('电话号码获得批准'),
            'created_at' => $this->integer()->comment('创建人'),
            'updated_at' => $this->integer()->comment('更新人'),
            'created_by' => $this->integer()->comment('创建时间'),
            'updated_by' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
           
        $this->createIndex('password_hash', '{{%user}}', ['password_hash'], false);
        $this->createIndex('password_reset_token', '{{%user}}', ['password_reset_token'], false);
        $this->createIndex('name', '{{%user}}', ['name'], false);
        $this->createIndex('created_by', '{{%user}}', ['created_by'], false);
        $this->createIndex('updated_by', '{{%user}}', ['updated_by'], false);
        $this->createIndex('created_at', '{{%user}}', ['created_at'], false);
        $this->createIndex('updated_at', '{{%user}}', ['updated_at'], false);
        $this->createIndex('logged_at', '{{%user}}', ['logged_at'], false);
        $this->createIndex('last_activity_at', '{{%user}}', ['last_activity_at'], false);
        $this->createIndex('last_admin_activity_at', '{{%user}}', ['last_admin_activity_at'], false);
        $this->createIndex('image_id', '{{%user}}', ['image_id'], false);
        $this->createIndex('phone_is_approved', '{{%user}}', ['phone_is_approved'], false);
        $this->createIndex('email_is_approved', '{{%user}}', ['email_is_approved'], false);
        
        /*$this->addForeignKey(
            'yiisns_user_image_id', '{{%user}}', 'image_id', '{{%storage_file}}', 'id', 'SET NULL', 'SET NULL'
        ); 在增加了storage_file后增加*/
        $this->addForeignKey(
            'yiisns_user_created_by', '{{%user}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'SET NULL'
        );
        $this->addForeignKey(
            'yiisns_user_updated_by', '{{%user}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'SET NULL'
        );
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
