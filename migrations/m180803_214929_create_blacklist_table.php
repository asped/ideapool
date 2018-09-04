<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blacklist`.
 */
class m180803_214929_create_blacklist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('blacklist', [
            'id' => $this->primaryKey(),
            'token'=>$this->text(),
            'timestamp'=>$this->timestamp()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('blacklist');
    }
}
