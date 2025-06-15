<?php

use yii\db\Migration;

class m250615_154756_add_created_at_column_in_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%review}}', 'created_at', $this->dateTime());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250615_154756_add_created_at_column_in_review_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250615_154756_add_created_at_column_in_review_table cannot be reverted.\n";

        return false;
    }
    */
}
