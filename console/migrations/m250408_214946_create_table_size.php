<?php

use yii\db\Migration;

class m250408_214946_create_table_size extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%size}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%size}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_214946_create_table_size cannot be reverted.\n";

        return false;
    }
    */
}
