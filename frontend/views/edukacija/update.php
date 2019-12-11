<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Edukacije */

$this->title = 'Update Lecture: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lectures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="edukacije-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
