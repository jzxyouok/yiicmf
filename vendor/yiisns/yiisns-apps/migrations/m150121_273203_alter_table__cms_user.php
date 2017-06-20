<?php
/**
 * m150121_273203_alter_table__cms_user
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.01.2015
 * @since 1.0.0
 */
use yii\db\Schema;
use yii\db\Migration;

class m150121_273203_alter_table__cms_user extends Migration
{
    public function up()
    {
        \Yii::$app->db->getSchema()->refresh();
        $userTable = \Yii::$app->db->getTableSchema('{{%cms_user}}');
        if ($userTable->getColumn('count_vote'))
        {
            $this->dropColumn('{{%cms_user}}', 'count_vote');
        }

        if ($userTable->getColumn('result_vote'))
        {
            $this->dropColumn('{{%cms_user}}', 'result_vote');
        }

        if ($userTable->getColumn('users_votes_up'))
        {
            $this->dropColumn('{{%cms_user}}', 'users_votes_up');
        }

        if ($userTable->getColumn('users_votes_down'))
        {
            $this->dropColumn('{{%cms_user}}', 'users_votes_down');
        }

        if (!$userTable->getColumn('phone'))
        {
            $this->addColumn('{{%cms_user}}', 'phone', Schema::TYPE_STRING . '(255) NULL');

            $this->execute("ALTER TABLE {{%cms_user}} ADD INDEX(phone);");

            $this->execute("ALTER TABLE {{%cms_user}} ADD UNIQUE(phone);");
            $this->execute("ALTER TABLE {{%cms_user}} ADD UNIQUE(email);");
        }

    }

    public function down()
    {
        echo "m150121_273205_alter_table__cms_user__add_emails cannot be reverted.\n";
        return false;
    }
}
