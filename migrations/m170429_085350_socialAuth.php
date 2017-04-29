<?php

use yii\db\Migration;

class m170429_085350_socialAuth extends Migration
{
    public function up()
    {
        $this->dropColumn('users', 'name');
        $this->addColumn('users', 'username', $this->string()->notNull());
        $this->addColumn('users', 'status',  $this->smallInteger()->notNull()->defaultValue(10));
        $this->addColumn('users', 'updated_at', $this->dateTime() . ' DEFAULT NOW()');

        $this->createTable('auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('auth');
        $this->dropTable('user');
    }
}
