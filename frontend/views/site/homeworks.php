<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
rmrevin\yii\fontawesome\NpmFreeAssetBundle::register($this);


/* @var $this yii\web\View */
/* @var $model common\models\UserFiles */
$this->title = 'Homeworks - ' . Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
echo Html::a( '<button class="btn text-primary mobile">&#10094;</button><br><br>', ['settings']); 

\yii\web\YiiAsset::register($this);
?>
<div class="user-files-view">

   
    <div class="col-md-3"></div>
    
<div class="col-md-6">
<h1><?= Html::encode($this->title) ?></h1>
    <?= 
    
    GridView::widget([
        'export' => false,
        'panel' => [
            'heading' => '<i class="fas fa-user"> </i> ' . Yii::$app->user->identity->username,
            'type' => GridView::TYPE_SUCCESS,
            'footer' => false,
        ],
        'condensed'=> false,
        'hover'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'lecture_title',
            'label' => 'Lecture',
            'value'=>function ($model, $index, $widget){
                return $model->edukacije->lecture_title
               ;}
            
             ],
             ['attribute' => 'lecture_title',
                'label' => 'Lecturer',
                'value'=>function ($model, $index, $widget){
                return $model->edukacije->lecturer
           ;}
        
    ],
        [
            'attribute' => 'file_path',
            'format' => 'raw',
            'value' => function($data){
                $base = '/zadace';
                $path = $base  . '/' . $data->file_path;
                return Html::a('<i class="fas fa-file-download fa-2x text-danger"></i> ', $path, array('target'=>'_blank'));
            },
            'label' => 'File',

        ],
 
         
        ],
    ]); ?>

</div>
</div>
