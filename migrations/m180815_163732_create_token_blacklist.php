<?php

use yii\db\Migration;

/**
 * Class m180815_163732_create_token_blacklist
 */
class m180815_163732_create_token_blacklist extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('blacklisted_tokens', [
            'id'=>$this->primaryKey(),
            'token'=>$this->string(1000)->unique(),
            'expiration'=>$this->dateTime(),
        ]);
        $this->createIndex('blacklisted_tokens_expiration','blacklisted_tokens','expiration');
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('blacklisted_tokens');
    }

}