<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\User;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;
   

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
        ];
    }
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function upload()
    {
        $id = Yii::$app->user->identity->id;
        $secret =  Yii::$app->user->identity->auth_key;
        $secret = substr($secret, 0, 8);
        $filename = Yii::$app->user->identity->username . $secret;
        $source = "uploads/";
        
        if ($this->validate()) {
            $user = $this->findModel($id);
            $user->cv_path = $filename . '.pdf';
            $user->save();
            $this->file->saveAs( $source . $filename . '.' . $this->file->extension);
         
            return true;
        }
        else {
            return false;
        }
    }
}
