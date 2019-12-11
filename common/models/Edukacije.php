<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "edukacije".
 *
 * @property int $id ID
 * @property string $predavac Predavač
 * @property string $nazivedukacije Naziv Edukacije
 * @property string $datum Datum
 * @property string $vrijeme Vrijeme
 * @property string $zadatakpath Zadatak
 * @property Files[] $files
 * @property Prijavljeni[] $prijavljenis
 * @property Prisutni[] $prisutnis
 * @property UserFiles[] $userFiles
 */
class Edukacije extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lecture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lecturer', 'lecture_title', 'lecture_date', 'lecture_time'], 'required'],
            [['lecture_date', 'lecture_time', 'subject'], 'safe'],
            [['lecturer'], 'string', 'max' => 35],
            [['lecture_date'], 'date', 'format' => 'php:Y-m-d'],
            [['lecture_time'],  'date', 'format'=>'H:i'],
            [['lecture_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lecturer' => 'Lecturer',
            'lecture_title' => 'Title',
            'lecture_date' => 'Date',
            'lecture_time' => 'Time',
            'subject' => 'Subject',
        ];
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrijavljenis()
    {
        return $this->hasMany(Prijavljeni::className(), ['lecture_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['lecture_id' => 'id']);
    }
    public function getUserFiles()
    {
        return $this->hasMany(UserFiles::className(), ['lecture_id' => 'id']);
    }
}

