<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\FileInput;

$filename = $model->photo_path;
if(!Yii::$app->user->identity->photo_path)
$filename = 'nofile';
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'photo_path')->label(false)->widget(FileInput::className(),[
    'name' => 'attachments', 
    
    'pluginOptions' => ['previewFileType' => 'any']
    ]) ;
 
    ?>

<?= Html::a('Submit', ['uploadavatar'], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' =>  file_exists($filename) ? 'Uploading this avatar will overwrite your old one. Continue?' : '',
                'method' => 'post',
            ],
        ]) ?>

<?php ActiveForm::end() ?>
