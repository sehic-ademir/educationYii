<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

 
    <?= $form->field($model, 'first_name')->textInput() ?>
    <?= $form->field($model, 'last_name')->textInput() ?>
    <?= $form->field($model, 'phone_number')->textInput() ?>
    <?= $form->field($model, 'address')->textInput() ?>
    <?= $form->field($model, 'city')->textInput() ?>
    <?= $form->field($model, 'birthday')->widget(DatePicker::className(),[
            'name' => 'check_issue_date', 
            'value' => date('YYYY-mm-dd', strtotime('+2 days')),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-m-dd',
                'todayHighlight' => true
            ],
        
        ])->label('Date')
       ?>
       <?= $form->field($model, 'gender')->dropDownList(['1' => 'Male', '0' => 'Female'],['prompt'=>'Select Option']) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
