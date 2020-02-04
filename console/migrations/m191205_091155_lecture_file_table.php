<?php

use yii\db\Migration;

/**
 * Class m191205_091155_lecture_file_table
 */
class m191205_091155_lecture_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lecture_file',[
            'id' => $this->primaryKey(),
            'lecture_id' => $this->integer(255)->notNull(),
            'file_path' => $this->string(255)->notNull(),
            'file_name' => $this->string(255),
            'status' => $this->boolean(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime()
            ]);
            $this->addForeignKey(
                'fk-lecture_file-lecture_id',
                'lecture_file',
                'lecture_id',
                'lecture',
                'id',
                'CASCADE'
                );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lecture_file}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_091155_lecture_file_table cannot be reverted.\n";

        return false;
    }
    */
}
