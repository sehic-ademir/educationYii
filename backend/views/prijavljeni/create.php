<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Prijavljeni */

$this->title = 'Create Prijavljeni';
$this->params['breadcrumbs'][] = ['label' => 'Prijavljeni', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prijavljeni-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
