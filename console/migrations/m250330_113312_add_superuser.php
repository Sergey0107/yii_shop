<?php

use common\models\User;
use yii\db\Migration;

class m250330_113312_add_superuser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'status' => User::STATUS_ACTIVE,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250330_113312_add_superuser cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250330_113312_add_superuser cannot be reverted.\n";

        return false;
    }
    */
}
