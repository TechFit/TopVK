<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170426_143835_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string(254),
            'name' => $this->string(254),
            'password' => $this->text(),
            'token' => $this->text(),
            'created_at' => $this->dateTime() . ' DEFAULT NOW()',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
