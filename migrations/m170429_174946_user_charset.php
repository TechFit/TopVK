<?php

use yii\db\Migration;

class m170429_174946_user_charset extends Migration
{
    public function up()
    {
        $this->alterColumn('users', 'username', $this->string()->append('CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL'));
    }

    public function down()
    {
        echo "m170429_174946_user_charset cannot be reverted.\n";

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
