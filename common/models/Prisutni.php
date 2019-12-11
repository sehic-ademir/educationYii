<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prisutni".
 *
 * @property int $id
 * @property int $edukacije_id
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Edukacije $edukacije
 * @property User $user
 */
class Prisutni extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prisutni';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edukacije_id', 'user_id', 'created_at', 'updated_at'], 'required'],
            [['edukacije_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['edukacije_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edukacije::className(), 'targetAttribute' => ['edukacije_id' => 'id']],
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
            'edukacije_id' => 'Edukacije ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdukacije()
    {
        return $this->hasOne(Edukacije::className(), ['id' => 'edukacije_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
