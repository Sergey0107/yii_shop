<?php

use yii\db\Migration;

class m250409_191013_add_table_order_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_products', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-order_products-order_id',
            'order_products',
            'order_id',
            'order',
            'id'
        );

        $this->addForeignKey(
            'fk-order_products-product_id',
            'order_products',
            'product_id',
            'product',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropForeignKey('fk-order_products-order_id', 'order_products');
       $this->dropForeignKey('fk-order_products-product_id', 'order_products');
       $this->dropTable('order_products');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_191013_add_table_order_products cannot be reverted.\n";

        return false;
    }
    */
}
