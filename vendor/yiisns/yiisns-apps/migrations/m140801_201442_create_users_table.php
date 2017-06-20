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
class m140801_201442_create_users_table extends Migration
{
    public function up()
    {
        $authManager = $this->getAuthManager();

        $tableExist = $this->db->getTableSchema("{{%users}}", true);
        if ($tableExist)
        {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->comment('用户名'),
            'auth_key' => $this->string(32)->notNull()->comment('密钥'),
            'password_hash' => $this->string()->notNull()->comment('密码'),
            'password_reset_token' => $this->string()->comment('恢复密码Token'),
            'email' => $this->string()->notNull()->comment('邮箱'),
            'role' => $this->smallInteger()->notNull()->defaultValue(10)->comment('角色'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
            'name' => $this->string()->notNull()->comment('昵称'),
            /*
 
            'name'                  => Schema::TYPE_STRING . '(255)',
            'city'                  => Schema::TYPE_STRING . '(255)',
            'address'               => Schema::TYPE_STRING . '(255)',
            'info'                  => Schema::TYPE_TEXT,
            'files'                 => Schema::TYPE_TEXT. ' NULL', //
            'count_subscribe'       => Schema::TYPE_INTEGER . ' NULL',
            'users_subscribers'     => Schema::TYPE_TEXT. ' NULL',   //Пользователи которые подписались (их id через запятую)
            'count_comment'         => Schema::TYPE_INTEGER . ' NULL', //Количество комментариев привязанных к пользователю.
            'status_of_life'        => Schema::TYPE_STRING . '(255)', //Коротки текстовый статус на странице
            'count_vote'            => Schema::TYPE_INTEGER . ' NULL', //Количество голосов
            'result_vote'           => Schema::TYPE_INTEGER . ' NULL', //Результат голосования
            'users_votes_up'        => Schema::TYPE_TEXT. ' NULL',   //Пользователи которые проголосовали +
            'users_votes_down'      => Schema::TYPE_TEXT. ' NULL',   //Пользователи которые проголосовали -*/
        ], $tableOptions);

        /*$this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(created_at);");
        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(updated_at);");
        $this->execute("ALTER TABLE {{%cms_user}} ADD UNIQUE(username);");
        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(email);");
        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(password_hash);");
        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(password_reset_token);");
        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(name);");
        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(city);");
        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(address);");

        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(count_comment);");

        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(count_vote);");
        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(result_vote);");

        $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(count_subscribe);");

        $this->execute("ALTER TABLE {{%cms_user}} ADD `gender` ENUM(\"men\",\"women\") NOT NULL DEFAULT 'men' ;");

        $this->execute("ALTER TABLE {{%cms_user}} COMMENT = 'Пользователь';");



        $this->addForeignKey(
            'auth_assignment_user_id', $authManager->assignmentTable,
            'user_id', '{{%cms_user}}', 'id', 'CASCADE', 'CASCADE'
        );*/

    }

    /**
     * @throws yii\base\InvalidConfigException
     * @return \yii\rbac\DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof \yii\rbac\DbManager) {
            throw new \yii\base\InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    public function down()
    {
        $authManager = $this->getAuthManager();

        $this->dropForeignKey("auth_assignment_user_id", $authManager->assignmentTable);
        $this->dropTable('{{%users}}');
    }
}
