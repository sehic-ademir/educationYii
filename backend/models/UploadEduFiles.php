<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Edukacije;
use common\models\Files;
class UploadEduFiles extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf, jpg, png, doc, docx, zip', 'maxFiles' => 5],
        ];
    }
 
 
    public function uploadFile($edukacijaId)
    {
        
        $source = '../../frontend/web/edukacije/';
        $edukacija = Edukacije::findOne($edukacijaId);
        $ifUpdate = Files::find()
        ->where(['lecture_id' => $edukacijaId])
        ->all();
        $lengthOfFile = count($ifUpdate);
        
        if ($this->validate()) {
          
           if($lengthOfFile < 1) 
            $i = 0;
            else
            $i = $lengthOfFile + 1;
            foreach ($this->file as $onefile) {
                $files = new Files();
                $files->lecture_id = $edukacijaId;
                $files->file_path = $edukacijaId . '-' . $i . '-' . $edukacija->lecturer . '.' . $onefile->extension;
                $files->save();
                $filename =  $edukacijaId . '-' . $i . '-' . $edukacija->lecturer . '.' . $onefile->extension;
                $onefile->saveAs( $source . $filename);
                $i++;
            }
            return true;
        } else {
            return false;
        }
    }
}
