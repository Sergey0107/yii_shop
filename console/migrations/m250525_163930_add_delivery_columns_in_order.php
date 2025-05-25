<?php

use yii\db\Migration;

class m250525_163930_add_delivery_columns_in_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%order}}', 'delivery_address');

        $this->addColumn('{{%order}}', 'pickup_point_id', $this->string()->defaultValue(null));
        $this->addColumn('{{%order}}', 'city', $this->string()->defaultValue(null));
        $this->addColumn('{{%order}}', 'street', $this->string()->defaultValue(null));
        $this->addColumn('{{%order}}', 'house', $this->string()->defaultValue(null));
        $this->addColumn('{{%order}}', 'comment', $this->string()->defaultValue(null));
        $this->addColumn('{{%order}}', 'phone', $this->string()->defaultValue(null));
        $this->addColumn('{{%order}}', 'email', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250525_163930_add_delivery_columns_in_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250525_163930_add_delivery_columns_in_order cannot be reverted.\n";

        return false;
    }
    */
}
