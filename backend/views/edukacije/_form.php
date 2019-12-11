<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model common\models\Edukacije */
/* @var $secondmodel backend\models\Edukacije */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edukacije-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lecturer')->textInput(['maxlength' => true])->label('Lecturer') ?>

    <?= $form->field($model, 'lecture_title')->textInput(['maxlength' => true])->label('Title') ?>

    <?= $form->field($model, 'subject')->textArea()->label('Subject') ?> 
    
    <?= $form->field($model, 'lecture_date')->widget(DatePicker::className(),[
            'name' => 'check_issue_date', 
            'value' => date('YYYY-mm-dd', strtotime('+2 days')),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-m-dd',
                'todayHighlight' => true
            ],
        
        ])->label('Date')
       ?>

    <?= $form->field($model, 'lecture_time')->widget(TimePicker::classname(),[
    'name' => 'event-time', 
    'pluginOptions' => [
        'minuteStep' => 10,
        'showSeconds' => false,
        'showMeridian' => false

    ],
    'class' => 'col-md-2'

])->label('Time') ?>
   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
