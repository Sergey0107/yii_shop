<?php

use yii\db\Migration;

class m250409_150217_add_table_delivery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('delivery', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('delivery');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_150217_add_table_delivery cannot be reverted.\n";

        return false;
    }
    */
}
