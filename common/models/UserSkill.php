<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_skill".
 *
 * @property int $id
 * @property int $user_id
 * @property string $skill_name
 * @property int $status
 * 
 * @property User $user
 */
class UserSkill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'skill_name'], 'required'],
            [['user_id'], 'integer'],
            [['status', 'updated_at'], 'safe'],
            [['status'], 'boolean'],
            [['skill_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'skill_name' => 'Skill Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}