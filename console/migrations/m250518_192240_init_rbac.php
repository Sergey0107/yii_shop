<?php

use yii\db\Migration;

class m250518_192240_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $adminPanel = $auth->createPermission('adminPanel');
        $adminPanel->description = 'Доступ к админ-панели';
        $auth->add($adminPanel);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $adminPanel);


        $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->authManager->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250518_192240_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
