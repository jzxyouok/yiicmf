<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.05.2016
 */
use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190515_103210_drop_tables_social
 */
class m150519_103210_drop_tables_social extends Migration
{
    public function up()
    {
        $tableExist = $this->db->getTableSchema("{{%cms_vote}}", true);
        if ($tableExist)
        {
            $this->execute("DROP TABLE {{%cms_vote}}");
        }

        $tableExist = $this->db->getTableSchema("{{%cms_comment}}", true);
        if ($tableExist)
        {
            $this->execute("DROP TABLE {{%cms_comment}}");
        }

        $tableExist = $this->db->getTableSchema("{{%cms_static_block}}", true);
        if ($tableExist)
        {
            $this->execute("DROP TABLE {{%cms_static_block}}");
        }

        $tableExist = $this->db->getTableSchema("{{%cms_subscribe}}", true);
        if ($tableExist)
        {
            $this->execute("DROP TABLE {{%cms_subscribe}}");
        }
    }

    public function down()
    {
        echo "m150519_103210_drop_tables_social cannot be reverted.\n";
        return false;
    }
}