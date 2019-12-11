<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update information: ';
echo Html::a( '<button class="btn text-primary mobile">&#10094;</button><br><br>', ['settings']); 

?>
<div class="user-update">
<div class="col-md-3"></div>
<div class="col-md-6">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
  </div>

</div>
