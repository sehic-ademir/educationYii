<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Prijavljeni */
/*
$this->title = 'Update Prijavljeni: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prijavljenis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
*/
?>
<div class="prijavljeni-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
