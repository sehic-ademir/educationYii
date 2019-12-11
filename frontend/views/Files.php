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
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edukacije_id', 'path'], 'required'],
            [['edukacije_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['edukacije_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edukacije::className(), 'targetAttribute' => ['edukacije_id' => 'id']],
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
            'path' => 'Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdukacije()
    {
        return $this->hasOne(Edukacije::className(), ['id' => 'edukacije_id']);
    }

    
    
}
