<?php

use yii\db\Migration;

class m170427_165723_auth_key extends Migration
{
    public function up()
    {
        /**
         * Rename column users.token for users.auth_key for
         * implementation login system.
         */
        $this->renameColumn('users', 'token', 'auth_key');
    }

    public function down()
    {
        echo "m170427_165723_auth_key cannot be reverted.\n";

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
