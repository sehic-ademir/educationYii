<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EdukacijeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lectures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edukacije-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Lecture', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'label' => 'Date',
                'attribute' => 'lecture_date'
            ],
            [
                'label' => 'Time',
                'attribute' => 'lecture_time'
            ]
            ,
          

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
