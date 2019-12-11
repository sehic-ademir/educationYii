<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prijavljeni".
 *
 * @property int $id
 * @property int $edukacije_id
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $Prisutan
 * @property int $status
 * 
 * @property Edukacije $edukacije
 * @property User $user
 */
class Prijavljeni extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lecture_applier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lecture_id', 'user_id', 'status'], 'required'],
            [['lecture_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['lecture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edukacije::className(), 'targetAttribute' => ['lecture_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['present', 'status'], 'boolean']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lecture_id' => 'Edukacije ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'present' => 'Present',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdukacije()
    {
        return $this->hasOne(Edukacije::className(), ['id' => 'lecture_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }



}
