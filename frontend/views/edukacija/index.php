<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\Prijavljeni;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EdukacijeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Lectures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edukacije-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'filterModel' => $searchModel,
        'rowOptions'=>function($model){
            if(Prijavljeni::find()->where(['user_id' => Yii::$app->user->identity->id, 'lecture_id' => $model->id, 'present' => true])->one()){
                return ['class' => 'success', 'title' => 'Present'];
            }
            else if (Prijavljeni::find()->where(['user_id' => Yii::$app->user->identity->id, 'lecture_id' => $model->id, 'status' => true])->one() && $model->lecture_date >  date("Y-m-d")){
                return ['class' => 'info', 'title' => 'You have confirmed your arrival'];
            }
            else if (Prijavljeni::find()->where(['user_id' => Yii::$app->user->identity->id, 'lecture_id' => $model->id, 'present' => false])->one() && $model->lecture_date <  date("Y-m-d")){
                return ['class' => 'danger', 'title' => 'Absent'];
            }
            else if($model->lecture_date === date("Y-m-d"))
            return ['class' => 'warning'];
        },
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          
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
            'attribute' => 'lecture_date',
            'value' => function ($model) {
                if($model->lecture_date === date("Y-m-d"))
                return 'Today';
                else return $model->lecture_date;
            },
        ],
        [
            'label' => 'Time',
            'attribute' => 'lecture_time',
          
        ],
            //'zadatakpath',
            [
                
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    $isChecked = Prijavljeni::find()->where(['user_id' => Yii::$app->user->identity->id, 'lecture_id' => $model->id])->one();
                    $isCheckedStatus = $isChecked;
                    if($isChecked){
                    $isChecked = $isChecked->lecture_id;
                    $isCheckedStatus = $isCheckedStatus->status;
                    }
                    

                  
                    if ($isChecked == $model->id && $isCheckedStatus) {
                        return ["onclick" => "submit($key)", 'checked' => true];
                    } else {
                        return ["onclick" => "submit($key)", 'checked' => false];
        
                    }
                },
                
               
               'header' => 'Confirm arrival',
               'headerOptions' =>['class' => 'text-primary'],
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>
 
</div>
<script type="text/javascript">

    function submit($key) {
        confirm("Potvrdite");
        $.ajax({
            type: "POST",
            url: '/edukacija/change-state?id='+$key, // Your controller action
            dataType: 'json',
            data: {key: $key},
            success: function (result) {
                location.reload();
            }

        });
           
        setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 500); 
    }
</script>


