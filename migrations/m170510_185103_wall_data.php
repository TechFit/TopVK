<?php

use yii\db\Migration;

class m170510_185103_wall_data extends Migration
{
    public function up()
    {
        $this->createTable('wall_data', [
            'id' => $this->primaryKey(),
            'ownerId' => $this->string(254),
            'post_id' => $this->string(254),
            'likes' => $this->text(),
            'date' => $this->dateTime(),
        ]);
    }

    public function down()
    {
        echo "m170510_185103_wall_data cannot be reverted.\n";

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
