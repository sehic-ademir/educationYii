<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
rmrevin\yii\fontawesome\NpmFreeAssetBundle::register($this);
 use rmrevin\yii\fontawesome\FAR;
 use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Edukacije */


$this->title = $model->lecture_title;
$this->params['breadcrumbs'][] = ['label' => 'Lectures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="edukacije-view">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> <br><br>
            <?= Html::a('Applied Users', ['/prijavljeni/index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Files', ['/files/index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Homeworks', ['/files/view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [ 
                'attribute' => 'lecturer',
                'label' => 'Lecturer'
            ],
            [
                'label' => 'Title',
                'attribute' => 'lecture_title'
            ],
            [
                'label' => 'Subject',
                'attribute' => 'subject',
            ],
            [
                'label' => 'Date',
                'attribute' => 'lecture_date'
            ],
            [
                'label' => 'Time',
                'attribute' => 'lecture_time'
            ],

        ],
      
    ])
   
     ?>

   

</div>
