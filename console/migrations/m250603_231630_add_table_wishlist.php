<?php

use yii\db\Migration;

class m250603_231630_add_table_wishlist extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('wishlist', ['user_id' => $this->integer(), 'product_id' => $this->integer()]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('wishlist');
    }
}
