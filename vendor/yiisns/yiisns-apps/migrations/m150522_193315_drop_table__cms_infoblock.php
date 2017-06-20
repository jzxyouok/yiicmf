<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 21.05.2016
 */
use yii\db\Schema;
use yii\db\Migration;

class m150522_193315_drop_table__cms_infoblock extends Migration
{
    public function safeUp()
    {
        $this->dropTable('cms_infoblock');
    }

    public function down()
    {
        echo "m150522_193315_drop_table__cms_infoblock cannot be reverted.\n";
        return false;
    }
}
