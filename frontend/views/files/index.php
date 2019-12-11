<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use rmrevin\yii\fontawesome\FAR;
use rmrevin\yii\fontawesome\FAS;
rmrevin\yii\fontawesome\NpmFreeAssetBundle::register($this);



/* @var $this yii\web\View */
/* @var $searchModel backend\models\FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lecture files - ' . $naziv;
$this->params['breadcrumbs'][] = ['label' => 'Lectures', 'url' => ['/edukacije/index']];
$this->params['breadcrumbs'][] = ['label' => $naziv, 'url' => ['/edukacija/view?id=' . Yii::$app->request->get('id')]];
$this->params['breadcrumbs'][] = $this->title;
$showthis = '/edukacija/'
?>
<div class="files-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php

    ?>
  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
               ;}
            
        ],
        [
            'attribute' => 'file_path',
            'format' => 'raw',
            'value' => function($data){
                $base = '/edukacije';
                $path = $base  . '/' . $data->file_path;
                return Html::a('<i class="fas fa-file-download fa-2x text-danger"></i>', $path, array('target'=>'_blank'));
            }
        ]
         
        ],
    ]); ?>


</div>
