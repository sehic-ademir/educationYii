<?php

use yii\db\Migration;

/**
 * Class m191204_113649_user_skill_table
 */
class m191204_113649_user_skill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_skill',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(255)->notNull(),
            'skill_name' => $this->string(255),
            'status' => $this->boolean(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->datetime()
        ]);
        $this->addForeignKey(
            'fk-user_skill-user_id',
            'user_skill',
            'user_id',
            'user',
            'id',
            'CASCADE'
            );
      
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_skill}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191204_113649_user_skill_table cannot be reverted.\n";

        return false;
    }
    */
}
