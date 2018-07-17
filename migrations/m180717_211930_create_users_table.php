<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180717_211930_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50),
            'username'=>$this->string(50),
            'password'=>$this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
