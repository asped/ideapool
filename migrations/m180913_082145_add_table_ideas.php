<?php

use yii\db\Migration;

/**
 * Class m180913_082145_add_table_ideas
 */
class m180913_082145_add_table_ideas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ideas', [
            'id' => $this->primaryKey(),
            'content'=>$this->string(255),
            'impact'=>$this->integer(),
            'ease'=>$this->integer(),
            'confidence'=>$this->integer(),
            'average_score'=>$this->float(),
            'created_at' => $this->dateTime(),
            'created_by' => $this->integer(),
        ]);
        $this->createIndex('ideas_by','ideas','created_by');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ideas');
    }

}