<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\icons\Icon;
rmrevin\yii\fontawesome\NpmFreeAssetBundle::register($this);
 use rmrevin\yii\fontawesome\FAR;
 use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$filename = $model->cv_path;
$showthis = Yii::$app->urlManagerFrontEnd->createAbsoluteUrl('uploads/' . $filename);
$profileImg = Yii::$app->urlManagerFrontEnd->createAbsoluteUrl('avatars/' . $model->photo_path);
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view ">
<div class="col-md-2"></div>
<div class="col-md-8">

    <div class="form-group">

    <?php $form = ActiveForm::begin(['action' => ['update', 'id' => $model->id]]); ?>
    <?= Html::a('<i class="fas fa-tasks"></i>', ['/files/homeworks', 'id' => $model->id], ['target' => '_blank', 'class' => 'btn btn-success']) ?>
    <?= $form->field($model, 'approved')->hiddenInput(['value'=> $model->approved ? 0 : 1])->label(false) ?>
    <?= Html::submitButton($model->approved ? 'Disapprove' : 'Approve', ['class' => $model->approved ? 'btn btn-danger' : 'btn btn-success']) ?>
    
    <?= Html::a('<i class="float-right far fa-trash-alt text-white"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this user?',
                'method' => 'post',
            ],
        ]) ?>
        

 
      
        </div>
        <div class="text-center mb-4">
        <img src=<?=$profileImg?> class="rounded-circle" />
        </div>
 <?php ActiveForm::end(); ?>
    <?= 
    DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    'hover'=>true,
    'hAlign' => 'left',
    'mode'=>DetailView::MODE_VIEW,
    'panel'=>[
        'heading'=> 'User #' . $model->id,
        'type'=> $model->approved ?  DetailView::TYPE_SUCCESS : DetailView::TYPE_DANGER,
    ],
    'buttons1' => '',
    'attributes'=>[
      
        'username',
       [
           'label' => 'First Name',
           'attribute' => 'first_name'
        ],
        [
            'label' => 'Last Name',
            'attribute' => 'last_name'
        ],
        [
            'label' => 'Phone Number',
            'attribute' => 'phone_number',
        ],
        'email:email',
        'city',
        'address',
        'birthday',
        [
            'attribute' => 'gender',
            'value' => $model->gender ? 'Male' : 'Female'
        ],
        [
            'attribute' => 'approved',
           'value'=>$model->approved  ? 'Yes' : 'No',
            
            
           ],
           [
            'attribute'=>'cv_path',
            'label'=>'CV',
            'format'=>'raw',
            'value'=>Html::a('<i class="far fa-file-pdf fa-2x text-danger"></i>', $showthis, ['target' => '_blank']),
           ],
           [
            'label' => 'Attendance:',
            'value' => $attendance . ' / ' . $totalLectures,
           ],
           [
            'label' => 'Skills',
            'value' => $userSkill
           ]

    ]
]);
   
    ?>

</div>



</div>
