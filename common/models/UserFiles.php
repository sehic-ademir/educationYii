<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_files".
 *
 * @property int $id
 * @property int $user_id
 * @property int $lecture_id
 * @property string $path
 *
 * @property Edukacije $edukacije
 * @property User $user
 */
class UserFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_homework';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'lecture_id', 'file_path'], 'required'],
            [['user_id', 'lecture_id'], 'integer'],
            [['file_path'], 'string', 'max' => 255],
            [['lecture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edukacije::className(), 'targetAttribute' => ['lecture_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'lecture_id' => Yii::t('app', 'Edukacije ID'),
            'file_path' => Yii::t('app', 'file_path'),
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
