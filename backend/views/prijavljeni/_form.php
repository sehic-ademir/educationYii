<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Prijavljeni */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prijavljeni-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'present')->checkbox([
            'template' => "",
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>