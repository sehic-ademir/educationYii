<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\FileInput;
use yii\widgets\DetailView;


$this->title = 'Upload Files';
$this->params['breadcrumbs'][] = ['label' => 'My Account', 'url' => ['/site/about']];
$this->params['breadcrumbs'][] = $this->title;


?>
<?= $model->file ?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<input type="hidden" name="edukacijaId" value=<?= $edukacijaId ?> >
<?= $form->field($model, 'file[]')->widget(FileInput::className(),[
    'name' => 'attachments', 
    'options' => ['multiple' => true], 
    'pluginOptions' => ['previewFileType' => 'any']
    ]) ?>
  

<?= Html::a('Submit', [''], [
            'class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
 

<?php ActiveForm::end() ?>
