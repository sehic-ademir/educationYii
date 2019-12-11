<?php

use yii\db\Migration;

/**
 * Class m191205_090815_lecture_table
 */
class m191205_090815_lecture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lecture',[
        'id' => $this->primaryKey(),
        'lecturer' => $this->string(55)->notNull(),
        'lecture_title' => $this->string(55)->notNull(),
        'subject' => $this->text(),
        'lecture_date' => $this->date(),
        'lecture_time' => $this->time(),
        'status' => $this->boolean(),
        'created_at' => $this->timestamp(),
        'updated_at' => $this->datetime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lecture}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_090815_lecture_table cannot be reverted.\n";

        return false;
    }
    */
}
