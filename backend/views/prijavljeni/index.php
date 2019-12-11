<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\controllers\PrijavljeniController;
use rmrevin\yii\fontawesome\FAR;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PrijavljeniSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$showthis = '/user/view?id=';
$this->title = 'Applied Participants - ' . $naziv;
$this->params['breadcrumbs'][] = ['label' => 'Lectures', 'url' => ['/edukacije/index']];
$this->params['breadcrumbs'][] = ['label' => $naziv, 'url' => ['/edukacije/view?id=' . Yii::$app->request->get('id')]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prijavljeni-index">

    <h1><?= Html::encode($this->title) ?></h1>

  

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                
            [
                'attribute' => 'user_id',
                'format'=>'raw',
                'label' => 'Participants',
                'value'=>function ($model, $index, $widget){
                    return Html::a($model->user->first_name  . ' ' . $model->user->last_name ,['user/view','id'=>$model->user->id],['title'=>'Pogledaj profil','target'=>'_blank']
                   );}
            ],
           
            //'prisutan',
            [
                
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    if ($model->present == 1) {
                        return ["onclick" => "submit($key)", 'checked' => true];
                    } else {
                        return ["onclick" => "submit($key)", 'checked' => false];
        
                    }
                },
                'header' => 'Present',
              
        
            ],
         
        ],
    ]); ?>

<script type="text/javascript">
    // action for all selected rows
    function submit($key) {

        $.ajax({
            type: "POST",
            url: '/prijavljeni/change-state?id='+$key, // Your controller action
            dataType: 'json',
            data: {key: $key},
            success: function (result) {
                console.log(result);
                location.reload();
            }
        });
    }
</script>
<?php

?>

</div>
