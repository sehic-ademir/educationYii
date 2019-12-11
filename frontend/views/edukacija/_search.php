<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\EdukacijeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edukacije-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'lecturer') ?>

    <?= $form->field($model, 'lecture_title') ?>

    <?= $form->field($model, 'lecture_date') ?>

    <?= $form->field($model, 'lecture_time') ?>

    <?php // echo $form->field($model, 'zadatakpath') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
