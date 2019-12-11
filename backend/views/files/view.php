<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
rmrevin\yii\fontawesome\NpmFreeAssetBundle::register($this);


/* @var $this yii\web\View */
/* @var $model common\models\UserFiles */
$this->title = 'Homeworks - ' . $naziv;
$this->params['breadcrumbs'][] = ['label' => 'Lectures', 'url' => ['/edukacije/index']];
$this->params['breadcrumbs'][] = ['label' => $naziv, 'url' => ['/edukacije/view?id=' . Yii::$app->request->get('id')]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-files-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= 
    
    GridView::widget([
      
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute' => 'lecture_id',
            'value'=>function ($model, $index, $widget){
                return $model->edukacije->lecture_title
               ;},
               'label' => 'Lecture ID',
            
        ],
        [
            'label' => 'User',
            'attribute' => 'user_id',
        'value'=>function ($model, $index, $widget){
            return $model->user->first_name . ' '. $model->user->last_name
           ;}
        
    ],
        [
            'attribute' => 'file_path',
            'format' => 'raw',
            'value' => function($data){
                $base = Yii::$app->urlManagerFrontEnd->createAbsoluteUrl('/zadace/');
                $path = $base  . '/' . $data->file_path;
                return Html::a('<i class="fas fa-file-download fa-2x text-danger"></i>', $path, array('target'=>'_blank'));
            },
            'label' => 'File'
        ],
     
         
        ],
    ]); ?>

</div>
