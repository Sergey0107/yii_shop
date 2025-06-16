<?php

use backend\models\ProductProperty;
use yii\db\Migration;

class m250616_012911_add_weight_for_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $productIds = (new \yii\db\Query())
            ->select(['id'])
            ->from('product')
            ->column();
        foreach ($productIds as $productId) {
            $productProperty = new ProductProperty();
            $productProperty->product_id = $productId;
            $productProperty->property_id = 3;
            $productProperty->value_id = 14;
            $productProperty->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250616_012911_add_weight_for_products cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250616_012911_add_weight_for_products cannot be reverted.\n";

        return false;
    }
    */
}
