<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Edukacije */

$this->title = 'Create Lectures';
$this->params['breadcrumbs'][] = ['label' => 'Lectures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-2"></div>
<div class="edukacije-create col-md-7">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
     
    ]) ?>

</div>
