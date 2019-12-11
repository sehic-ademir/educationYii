<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Edukacije;
use common\models\UserFiles;
class UploadHomework extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip, rar, pdf'],
        ];
    }
 
 
    public function uploadFile($edukacijaId)
    {
      
        $source = '../../frontend/web/zadace/';
        $edukacija = Edukacije::findOne($edukacijaId);
        $ifUpdate = UserFiles::find()
        ->where(['lecture_id' => $edukacijaId, 'user_id' => Yii::$app->user->identity->id])
        ->all();
     
        if ($this->validate()) {
          
                if($ifUpdate) {
                    $files = UserFiles::find()->where(['user_id' => Yii::$app->user->identity->id, 'lecture_id' => $edukacijaId])->one();
                }
                else $files = new UserFiles();
             
                $files->lecture_id = $edukacijaId;
            
                $files->user_id = Yii::$app->user->identity->id;
                $files->file_path = $edukacijaId . '-' . Yii::$app->user->identity->id . '-' . Yii::$app->user->identity->username . '.' . $this->file->extension;
                $files->save();
                $filename =  $edukacijaId . '-' . Yii::$app->user->identity->id . '-' . Yii::$app->user->identity->username . '.' . $this->file->extension;
                $this->file->saveAs( $source . $filename);
              
            
            return true;
        } else {
            return false;
        }
    }
}
