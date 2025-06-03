<?php

use yii\db\Migration;

class m250603_233323_fix_wishlist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%wishlist}}', 'id', $this->primaryKey());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250603_233323_fix_wishlist_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250603_233323_fix_wishlist_table cannot be reverted.\n";

        return false;
    }
    */
}
