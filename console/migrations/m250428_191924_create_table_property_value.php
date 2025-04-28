<?php

use yii\db\Migration;

class m250428_191924_create_table_property_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('property_value', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'value' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('fk_property_value_property_id',
            'property_value',
            'property_id',
            'property', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_property_value_property_id', 'property_value');
        $this->dropTable('property_value');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250428_191924_create_table_property_value cannot be reverted.\n";

        return false;
    }
    */
}
