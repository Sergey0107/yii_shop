<?php

use yii\db\Migration;

class m250410_063559_add_quantity_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order_products', 'quantity', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250410_063559_add_quantity_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250410_063559_add_quantity_column cannot be reverted.\n";

        return false;
    }
    */
}
