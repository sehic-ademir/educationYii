<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Prijavljeni */

$this->title = 'Prijavljeni na edukaciju';
$this->params['breadcrumbs'][] = ['label' => 'Prijavljenis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);



?>

<div class="prijavljeni-form">
<?php $form = ActiveForm::begin(); ?>
    <h1><?= Html::encode($this->title) ?></h1>


    <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Ime</th>
      <th scope="col">Prezime</th>
      <th scope="col">Username</th>
      <th scope="col">Prisutan</th>
    </tr>
  </thead>
    <?php
    foreach ($model as &$singlemodel) {
      
     
        $id = $singlemodel['user_id'];
        $profile = User::findIdentity($id);
            echo '
  <tbody>
    <tr>
      <th scope="row"> '.$profile->id.' </th>
      <td> '.$profile->first_name.' </td>
      <td> '.$profile->last_name.' </td>
      <td> '.$profile->username.' </td>
      <input type="hidden" name="profileId" value='. $profile['id'] .' >
   
      <td> '.Html::a(($singlemodel['present']) ? 'Da' : 'Ne', ['/prijavljeni/update', 'id' => $singlemodel->lecture_id], ['class' => 'btn ']).' </td>
    </tr>
  </tbody>
 
';
    }
  
    ?>
  

   </table>
   <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
   <?php ActiveForm::end(); ?>

</div>
<?php

?>
