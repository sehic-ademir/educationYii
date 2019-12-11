<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use rmrevin\yii\fontawesome\FAR;
rmrevin\yii\fontawesome\NpmFreeAssetBundle::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Edukacije */

$this->title = $model->lecture_title . ' - ' . $model->lecturer;
$this->params['breadcrumbs'][] = ['label' => 'Lectures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="edukacije-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="far fa-file-pdf fa-2x"></i>', ['/files/index', 'id' => $model->id], ['class' => 'btn btn-danger', 'title' => 'Open files']) ?>
        <?= Html::a('<i class="fas fa-file-upload fa-2x"></i>', ['/files/upload', 'id' => $model->id], ['class' => 'btn btn-success', 'title' => 'Upload Homework']) ?>
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
    ]) ?>

</div>
