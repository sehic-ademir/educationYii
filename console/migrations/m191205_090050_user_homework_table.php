<?php

use yii\db\Migration;

/**
 * Class m191205_090050_user_homework_table
 */
class m191205_090050_user_homework_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_homework',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(255)->notNull(),
            'lecture_id' => $this->integer(255)->notNull(),
            'file_path' => $this->string(255),
            'status' => $this->boolean(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->datetime()
            ]);
        $this->addForeignKey(
            'fk-user_homework-user_id',
            'user_homework',
            'user_id',
            'user',
            'id',
            'CASCADE'
            );
        $this->addForeignKey(
            'fk-user_homework-lecture_id',
            'user_homework',
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
        $this->dropTable('{{%user_homework}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_090050_user_homework_table cannot be reverted.\n";

        return false;
    }
    */
}
