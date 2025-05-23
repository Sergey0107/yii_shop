<?php

use yii\db\Migration;

class m250409_104753_add_column_is_new_in_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'is_new', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_104753_add_column_is_new_in_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_104753_add_column_is_new_in_product_table cannot be reverted.\n";

        return false;
    }
    */
}
