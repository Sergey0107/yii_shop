<?php

use backend\models\Delivery;
use yii\db\Migration;

class m250409_150329_add_table_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'total_price' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->defaultValue(date('Y-m-d H:i:s')),
            'delivery_id' => $this->integer()->notNull()->defaultValue(Delivery::ID_PICKUP),
            'delivery_address' => $this->string()->defaultValue(null),
        ]);

        $this->addForeignKey(
            'fk-order-user_id',
            'order',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-order-delivery_id',
            'order',
            'delivery_id',
            'delivery',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order-user_id', 'order');
        $this->dropForeignKey('fk-order-delivery_id', 'order');
        $this->dropTable('order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_150329_add_table_order cannot be reverted.\n";

        return false;
    }
    */
}
