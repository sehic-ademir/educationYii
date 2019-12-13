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
$this->title = 'Account Settings';


?>
<style>
body {
    background-color: #f2f1f6;
}
</style>

<?= Html::a( '<button class="btn text-primary mobile">&#10094;</button>', ['account']); ?>
    
<div class="image-container text-center">
    <div class="rounded-circle">
      <img  src=<?= $model->photo_path ? '/avatars/' . $model->photo_path : $png ?> class=<?= $model->approved?'border-green':'border-red' ?>  />
    </div>
</div>
    <br>
    <div class="w-100">
        <div class="mobile-settings">
        <?= Html::a( '<div class="setting-single">
                <button class="btn btn-warning"><i class="far fa-file-pdf"></i><p class="setting-title-desktop">Update Resume/CV</p></button> 
                <span class="setting-title">Update Resume/CV</span>
                    <span class="setting-arrow">&#10095;</span> 
                ' , ['cvupload'] ); ?>
            </div>
            <?= Html::a( '<div class="setting-single">
                <button class="btn btn-primary"><i class="far fa-edit"></i><p class="setting-title-desktop">Update Personal Information</p></button> 
                <span class="setting-title">Update Personal Information</span>
                    <span class="setting-arrow">&#10095;</span> 
                ' , ['update'] ); ?>
            </div>
            <?= Html::a( '<div class="setting-single">
                <button class="btn btn-primary"><i class="fas fa-book"></i><p class="setting-title-desktop">Homeworks</p></button> 
                <span class="setting-title">Homeworks</span>
                    <span class="setting-arrow">&#10095;</span> 
                ' , ['homeworks'] ); ?>
            </div>
            <?= Html::a( '<div class="setting-single">
                <button class="btn btn-success"><i class="far fa-image"></i><p class="setting-title-desktop">Upload Profile Photo</p></button> 
                <span class="setting-title">Upload Profile Photo</span>
                    <span class="setting-arrow">&#10095;</span> 
                ' , ['uploadavatar'] ); ?>
            </div>
            
        </div>
    </div>
 
