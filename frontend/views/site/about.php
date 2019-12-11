<?php

/* @var $this yii\web\View */
rmrevin\yii\fontawesome\NpmFreeAssetBundle::register($this);


use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Dropdown;
use yii\bootstrap\ButtonDropdown;


$this->title = 'My Account';

$webPath = '/uploads/' . Yii::$app->user->identity->cv_path;


?>
<style>
.dropdownforma button {
    background-color: #ffffff !important;
}
</style>
<div class="site-about">
 
    <div class="col-md-2"></div>
<div class="col-md-8 dropdownforma">
<h1><?= Html::encode($this->title) .  ButtonDropdown::widget([
        'label' => '<i class="far fa-edit fa-2x text-primary"></i>',
        'encodeLabel' => false,
        'dropdown' => [
            'items' => [
                ['label' => 'CV', 'url' => '/site/cvupload', 'format' => 'raw'],
                [
                    'label' => 'Edit Information', 'url' => '/site/update',
         ],
            ],
        ],
    ]);
   ?>   <?= Html::a('<i class="fas fa-book"></i>', ['homeworks'], ['target' => '_blank', 'class' => 'btn btn-success']) ?>
   </h1>
  
 <?= '<div class="bg-dark">',
    DetailView::widget([
    'options' => ['class' => 'border-circle'],
    'tooltips' => true,
    'model'=>$model,
    'condensed'=> false,
    'hover'=>true,
    'template' => 'reset',
    'mode'=>DetailView::MODE_VIEW,
    'panel'=>[
        'heading'=> $model->approved  ? '<i class="fas fa-user"> </i> ' . $model->username : '<i class="fas fa-user-slash"> </i> ' . $model->username,
        'type'=> $model->approved ? DetailView::TYPE_SUCCESS : DetailView::TYPE_DANGER,
    ],
    'buttons1' => '',
    'attributes'=>[
      
        [
            'attribute' => 'first_name',
            'label' => 'First Name'
        ],
        [
            'label' => 'Last Name',
            'attribute' => 'last_name'],
        [
            'label' => 'Phone Number',
            'attribute' => 'phone_number',
        ],
        'email:email',
      
           [
            'attribute'=>'cv_path',
            'label'=>'CV',
            'format'=>'raw',
            'value'=>Html::a('<i class="far fa-file-pdf fa-2x text-danger"></i>', $webPath, ['target' => '_blank']),
          ]
    

    ]
]);


   
    ?>
</div>
    </div>

   </div>