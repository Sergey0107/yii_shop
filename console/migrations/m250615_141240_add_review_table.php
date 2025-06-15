<?php

use yii\db\Migration;

class m250615_141240_add_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('review', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'user_id' => $this->integer(),
            'rating' => $this->integer(),
            'review' => $this->text(),
        ]);
        $this->addForeignKey(
            'fk-review-product_id',
            'review',
            'product_id',
            'product',
            'id'
        );
        $this->addForeignKey(
            'fk-review-user_id',
            'review',
            'user_id',
            'user',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('review');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250615_141240_add_review_table cannot be reverted.\n";

        return false;
    }
    */
}
