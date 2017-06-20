<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.03.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m150324_273205_alter_table__cms_infoblock extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE {{%cms_infoblock%}} ADD `protected_widget` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Запрет на смену виджета.' ,
                                                        ADD `auto_created` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Автоматически созданный инфоблок' ;");
    }

    public function down()
    {
        echo "m150324_273205_alter_table__cms_infoblock cannot be reverted.\n";
        return false;
    }
}
