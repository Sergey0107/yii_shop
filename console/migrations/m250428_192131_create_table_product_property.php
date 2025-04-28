<?php

use yii\db\Migration;

class m250428_192131_create_table_product_property extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_property', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'property_id' => $this->integer(),
            'value_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk_product_property', 'product_property', 'product_id', 'product', 'id');
        $this->addForeignKey('fk_product_property_value', 'product_property', 'property_id', 'property', 'id');
        $this->addForeignKey('fk_product_property_value_value', 'product_property', 'value_id', 'property_value', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropForeignKey('fk_product_property', 'product_property');
       $this->dropForeignKey('fk_product_property_value', 'product_property');
       $this->dropForeignKey('fk_product_property_value_value', 'product_property');
       $this->dropTable('product_property');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250428_192131_create_table_product_property cannot be reverted.\n";

        return false;
    }
    */
}
