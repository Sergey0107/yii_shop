<?php

use yii\db\Migration;

class m250524_205244_add_column_old_price extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'old_price', $this->integer()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%product}}', 'old_price');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250524_205244_add_column_old_price cannot be reverted.\n";

        return false;
    }
    */
}
