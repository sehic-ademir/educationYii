<?php

use yii\db\Migration;

/**
 * Class m191205_085612_lecture_applier_table
 */
class m191205_085612_lecture_applier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lecture_applier',[
        'id' => $this->primaryKey(),
        'lecture_id' => $this->integer(255)->notNull(),
        'user_id' => $this->integer(255)->notNull(),
        'present' => $this->boolean(),
        'status' => $this->boolean(),
        'created_at' => $this->timestamp(),
        'updated_at' => $this->datetime()
        ]);
        $this->addForeignKey(
            'fk-lecture_applier-user_id',
            'lecture_applier',
            'user_id',
            'user',
            'id',
            'CASCADE'
            );
        $this->addForeignKey(
            'fk-lecture_applier-lecture_id',
            'lecture_applier',
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
        $this->dropTable('{{%lecture_applier}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_085612_lecture_applier_table cannot be reverted.\n";

        return false;
    }
    */
}
