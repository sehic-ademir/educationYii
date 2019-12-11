<?php

/* @var $this yii\web\View */
rmrevin\yii\fontawesome\NpmFreeAssetBundle::register($this);


use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Dropdown;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Modal;


use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
$this->title = 'My Account';

$webPath = '/uploads/' . Yii::$app->user->identity->cv_path;
$model = $user;




?>

<style>
.dropdownforma button {
    background-color: #ffffff !important;
}
</style>
<div class="site-about">
  <div class="row">
    <div class="col-md-4  col-sm-6">
      <div class="resize">
        <img src=<?= $model->photo_path ? '/avatars/' . $model->photo_path : $png ?> class=
        <?= $model->approved ? 'border-success' : 'border-danger'  ?> style="" />
      </div>
      <hr>
      <div class="text-left">
        <h4>Skills:</h4>
     
        <?php 
        foreach($skills as $skill) {
        echo '<button class="btn skillset btn-primary" value=' .
        $skill->skill_name  .
       ' onclick="submit('.$skill->id.')" > <span class="skillname" >'  . $skill->skill_name . '</span><span class="dlt-btn" title='.$skill->skill_name .'>Delete</span></button>';
        }
        ?>

      <form>
        <input class="add-skillset" placeholder="Add Skill"  width="10" id="skillID" />
        <input type="submit" value="+" class="btn btn-success submit-btn" onclick="addSkill()" />
      </form>

   
        <hr>
        <h4>CV:
          <?=   Html::a('<i class="far fa-file-pdf text-danger"></i>', ['/uploads/' . $model->cv_path], ['target' => '_blank'])?> </h4>
      </div>
    </div>
    <hr class="mobile">
    <div class="col-md-4 col-sm-6">
      <h1>
        <?= $model->first_name . ' ' . $model->last_name ?> <small class="text-primary"> <i class="fas fa-map-marker-alt"></i> <?= $model->city ?> </small> </h1>
      <?= $model->approved ?   '<h5 class="text-success"> @' . $model->username . '</h5>' : '<h5 class="text-danger"> @' . $model->username . '</h5>' ?>
        <p style="margin-top: 5%;" class=<?= $attendance < 55 ? "text-danger" : 'text-success' ?>>
          <?= $attendance?>% lectures present</p>
        <hr>
        <h4>Contact Info:</h4>
        <p>Phone:
          <?= $model->phone_number ?>
        </p>
        <p>E-mail:
          <?= $model->email ?>
        </p>
        <Address>Adresa: <?= $model->address ?> </Address>
        <hr>
        <h4>Basic Information:</h4>
        <p>Birthday:
          <?= $model->birthday ?>
        </p>
        <p>Gender:
          <?= $model->gender ? 'Male' : 'Female' ?>
        </p>
    </div>
    <div class="col-md-4 col-sm-12 text-right desktop-actions" style="margin-top: 2%">
      <h4>Actions</h4>
      <p>Edit CV
        <?= Html::a('<i class="fas fa-file-import"></i>', ['cvupload'], ['target' => '_blank', 'class' => 'btn btn-success']) ?> </p>
      <p>Update information
        <?= Html::a('<i class="far fa-edit"></i>', ['update'], ['target' => '_blank', 'class' => 'btn btn-primary']) ?> </p>
      <?= 
    $model->approved ? '<p> Homeworks ' . Html::a('<i class="fas fa-book"></i>', ['homeworks'], ['target' => '_blank', 'class' => 'btn btn-success']) . '</p>' : '' 
    ?>

        <p> Change Profile Photo
          <?php
    Modal::begin([
    'header' => 'Change Profile Photo &nbsp;',
    'toggleButton' => ['label' => '<i class="far fa-image"></i>',  'class' => 'btn btn-primary'],
   
]);



 $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

echo $form->field($image, 'photo_path')->label(false)->widget(FileInput::className(),[
    'name' => 'attachments', 
    'options' => false,
    'pluginOptions' => ['previewFileType' => 'any']
    ]) ;
 
    

echo Html::a('Submit', [''], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' =>  'Uploading this avatar will overwrite your old one. Continue?' ,
                'method' => 'post',
            ],
        ]);

 ActiveForm::end();




Modal::end();
   ?>

    </div>
  </div>

</div>
<script type="text/javascript">

    function submit($key) {
      
        $.ajax({
            type: "POST",
            url: '/site/delete-skill?id='+$key,   // Your controller action
            dataType: 'json',
            data: {key: $key},
        });
          setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 500); 
     
        
    }
</script>
<script type="text/javascript">

function addSkill() {
    $key = document.getElementById("skillID").value;
    console.log($key);
    $.ajax({
        type: "POST",
        url: '/site/add-skill', // Your controller action
        dataType: 'json',
        data: {key: $key},

    });
   
       
         
 
    
}
</script>