<?php

use yii\db\Migration;

class m250613_032539_add_payment_status_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'payment_status', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250613_032539_add_payment_status_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250613_032539_add_payment_status_column cannot be reverted.\n";

        return false;
    }
    */
}
