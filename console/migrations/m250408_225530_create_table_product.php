<?php

use yii\db\Migration;

class m250408_225530_create_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->string()->defaultValue(null),
            'img' => $this->string()->defaultValue(null),
            'price' => $this->integer()->notNull(),
            'quantity' => $this->integer()->defaultValue(0),
            'is_active' => $this->integer()->defaultValue(0),
            'size_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'color_id' => $this->integer()->notNull(),
            'material_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-product-size',
            'product',
            'size_id',
            'size',
            'id'
        );

        $this->addForeignKey(
            'fk-product-country',
            'product',
            'country_id',
            'country',
            'id'
        );

        $this->addForeignKey(
            'fk-product-type',
            'product',
            'type_id',
            'type',
            'id'
        );

        $this->addForeignKey(
            'fk-product-material',
            'product',
            'material_id',
            'material',
            'id'
        );

        $this->addForeignKey(
            'fk-product-color',
            'product',
            'color_id',
            'color',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_225530_create_table_product cannot be reverted.\n";

        return false;
    }
    */
}
