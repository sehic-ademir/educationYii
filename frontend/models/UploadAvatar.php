<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\User;


class UploadAvatar extends Model
{
    /**
     * @var UploadedFile
     */
    public $photo_path;

    public function rules()
    {
        return [
            [['photo_path'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, svg, jpeg, '],
        ];
    }
 
    protected function findModel()
    {
        if (($model = User::findOne(Yii::$app->user->identity->id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
 
    public function uploadFile()
    {
      
        $source = '../../frontend/web/avatars/';
        if ($this->validate()) {

                $photo = $this->findModel();

                $photo->photo_path = $photo->id . '-avatar.' . $this->photo_path->extension;
                $photo->save();
                $filename = $photo->id . '-avatar.' . $this->photo_path->extension;;
                $this->photo_path->saveAs( $source . $filename);
            return true;
        } else {
            return false;
        }
    }
}
