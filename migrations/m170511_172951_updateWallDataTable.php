<?php

use yii\db\Migration;

class m170511_172951_updateWallDataTable extends Migration
{
    public function up()
    {
        $this->alterColumn('wall_data', 'likes', $this->bigInteger());
    }

    public function down()
    {
        echo "m170511_172951_updateWallDataTable cannot be reverted.\n";

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
