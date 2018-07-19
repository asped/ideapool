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
            'username'=>$this->string(50)->unique(),
            'password'=>$this->string(255),
            'refresh_token'=>$this->string(255)
        ]);
        $this->createIndex('users_username','users','username');
        $this->createIndex('users_token','users','refresh_token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
