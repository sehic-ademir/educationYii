<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // [
            //     'label' => 'ID',
            //     'attribute' => 'id'],
            // 'username',
            [
                'label' => 'First Name',
                'attribute' => 'first_name'
             ],
             [
                 'label' => 'Last Name',
                 'attribute' => 'last_name'
             ],
            // 'broj',
            // [
            //     'label' => 'CV',
            //     'attribute' => 'cv'],
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            // 'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'verification_token',
            [
           
                
                'attribute' => 'approved',
                'value' => function ($model) {
                    return $model->approved ? 'Yes' : 'No';},
                
                'filter' => [0=>'No', 1=>'Yes'],
               ],
               

            [ 'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {delete}'],
        ],
    ]); ?>


</div>
