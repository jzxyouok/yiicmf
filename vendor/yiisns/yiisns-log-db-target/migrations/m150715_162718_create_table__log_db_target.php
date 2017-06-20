<?php
use yii\db\Schema;
use yii\db\Migration;

class m150715_162718_create_table__log_db_target extends Migration
{
    public function safeUp()
    {
        $tableExist = $this->db->getTableSchema("{{%log_db_target}}", true);
        if ($tableExist)
        {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $sql = <<<SQL
CREATE TABLE log_db_target (
  id       BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  level    INTEGER,
  category VARCHAR(255),
  log_time INTEGER,
  prefix   TEXT,
  message  TEXT,
  INDEX idx_log_level (level),
  INDEX idx_log_category (category)
)
SQL;
        $this->db->createCommand($sql)->execute();
    }

    public function safeDown()
    {
        $this->dropTable("{{%log_db_target}}");
    }
}