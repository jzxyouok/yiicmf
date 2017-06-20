<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.03.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m150608_154030_alter_table__cms_user_emails_and_phones extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE {{%cms_user_email}} CHANGE `approved` `approved` CHAR(1) NOT NULL DEFAULT 'N';");
        $this->execute("ALTER TABLE {{%cms_user_phone}} CHANGE `approved` `approved` CHAR(1) NOT NULL DEFAULT 'N';");
    }

    public function down()
    {
        echo "m150608_154030_alter_table__cms_user_emails_and_phones cannot be reverted.\n";
        return false;
    }
}

