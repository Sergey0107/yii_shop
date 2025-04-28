<?php

use yii\db\Migration;

class m250428_191719_create_table_property extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('property', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('property');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250428_191719_create_table_property cannot be reverted.\n";

        return false;
    }
    */
}
