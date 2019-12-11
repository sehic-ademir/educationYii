<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\FileInput;


$this->title = 'CV';
echo Html::a( '<button class="btn text-primary mobile">&#10094;</button><br><br>', ['settings']); 


$filename = 'uploads/' . Yii::$app->user->identity->cv_path;

$cvexists = !Yii::$app->user->identity->cv_path ? false : true;
if(!Yii::$app->user->identity->cv_path)
$filename = 'nofile';
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'file')->widget(FileInput::className(),[
    'name' => 'attachments', 
    'options' => ['multiple' => false], 
    'pluginOptions' => ['previewFileType' => 'any']
    ]) ?>

<?= Html::a('Submit', [''], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' =>  file_exists($filename) ? 'Uploading file will overwrite your old one. Continue?' : '',
                'method' => 'post',
            ],
        ]) ?>

<?php ActiveForm::end() ?>