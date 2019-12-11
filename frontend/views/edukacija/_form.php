<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Edukacije */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edukacije-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lecturer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lecture_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lecture_date')->textInput() ?>

    <?= $form->field($model, 'lecture_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
