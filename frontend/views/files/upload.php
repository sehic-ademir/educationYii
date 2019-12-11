<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\FileInput;
use yii\widgets\DetailView;


$this->title = 'Upload Homework - ' . $naziv;
$this->params['breadcrumbs'][] = ['label' => 'Lectures', 'url' => ['/edukacije/index']];
$this->params['breadcrumbs'][] = ['label' => $naziv, 'url' => ['/edukacija/view?id=' . Yii::$app->request->get('id')]];
$this->params['breadcrumbs'][] = $this->title;


?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<input type="hidden" name="edukacijaId" value=<?= $edukacijaId ?> >
<?= $form->field($model, 'file')->widget(FileInput::className(),[
    'name' => 'attachments', 
    'options' => ['multiple' => false], 
    'pluginOptions' => ['previewFileType' => 'any']
    ]) ?>

<?= Html::a('Submit', [''], [
            'class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>

<?php ActiveForm::end() ?>