<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property int $edukacije_id Edukacija
 * @property string $path Link
 *
 * @property Edukacije $edukacije
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lecture_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lecture_id', 'file_path'], 'required'],
            [['lecture_id'], 'integer'],
            [['status', 'created_at', 'updated_at'], 'safe'],
            [['file_path'], 'string', 'max' => 255],
            [['lecture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edukacije::className(), 'targetAttribute' => ['lecture_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lecture_id' => 'Lecture ID',
            'file_path' => 'File Path',
            'status' => 'Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdukacije()
    {
        return $this->hasOne(Edukacije::className(), ['id' => 'lecture_id']);
    }

    
    
}
