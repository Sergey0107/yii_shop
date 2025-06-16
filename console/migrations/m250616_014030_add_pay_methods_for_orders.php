<?php

use yii\db\Migration;

class m250616_014030_add_pay_methods_for_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $orders = \backend\models\Order::find()->all();

        foreach ($orders as $order) {
            if (!$order->payment_method_id) {
                $order->payment_method_id = 1;
                $order->save(false);
            }

        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250616_014030_add_pay_methods_for_orders cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250616_014030_add_pay_methods_for_orders cannot be reverted.\n";

        return false;
    }
    */
}
