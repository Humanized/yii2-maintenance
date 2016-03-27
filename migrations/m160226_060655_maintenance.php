<?php

use yii\db\Migration;

class m160226_060655_maintenance extends Migration {

    public function safeUp()
    {
        $this->createTable('maintenance', [
            'id' => $this->primaryKey(),
            'time_enabled' => $this->integer()->notNull(),
            'time_disabled' => $this->integer(),
            'message' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('maintenance');
        return false;
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
