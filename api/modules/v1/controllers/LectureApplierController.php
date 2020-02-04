<?php

namespace api\modules\v1\controllers;

use Yii;
use api\components\Authorisation;
use common\models\Edukacije;
use common\models\Prijavljeni;
use yii\rest\ActiveController;
use yii\helpers\Url;

class LectureApplierController extends ActiveController
{
    public $modelClass = User::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => Authorisation::className(),
        ];
        return $behaviors;
    }
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['update'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionIndex(){
       if(Yii::$app->request->get()){
        $data = Yii::$app->request->get();
        $findApplier = Prijavljeni::find()->where(['id' => $data['id']])->one();
        if(!$findApplier)
        throw new \yii\web\HttpException(400, 'The requested ID could not be found.');
        $basicInfo['id'] = $findApplier->id;
        $basicInfo['lecture_id'] = $findApplier->lecture_id;
        $basicInfo['user_id'] = $findApplier->user_id;
        $basicInfo['present'] = $findApplier->present;
        $basicInfo['status'] = $findApplier->status;
        $basicInfo['created_at'] = $findApplier->created_at;
        $basicInfo['updated_at'] = $findApplier->updated_at;
        return[$basicInfo];
    }
        else  {

        $findAppliers = Prijavljeni::find()->all();
        if(!$findAppliers)
        throw new \yii\web\HttpException(404, 'Appliers not found');
        else{
        foreach($findAppliers as $findApplier) {
          $basicInfo['id'] = $findApplier->id;
          $basicInfo['lecture_id'] = $findApplier->lecture_id;
          $basicInfo['user_id'] = $findApplier->user_id;
          $basicInfo['present'] = $findApplier->present;
          $basicInfo['status'] = $findApplier->status;
          $basicInfo['created_at'] = $findApplier->created_at;
          $basicInfo['updated_at'] = $findApplier->updated_at;
            $finalInfo[] = $basicInfo;
        }
       return[$finalInfo];
     }
    }
}
    public function actionCreate(){
        $data = Yii::$app->request->get();
        $model = new Prijavljeni();
        $model->lecture_id = $data['lecture_id'];
        $model->user_id = $data['user_id'];
        $model->created_at = date('Y-m-d H:i:s');
        $model->status = 1;
        $model->present = 0;
        if(!$model->save())
        throw new \yii\web\HttpException(403, json_encode($model->getErrors()));
        else
        return[$model];
    }
    public function actionUpdate(){
        $data = Yii::$app->request->get();
        $model = Prijavljeni::find()->where(['id' => $data['id']])->one();
        if($model) {
        foreach($data as $singleData => $value) {
            if($singleData == 'created_at' || $singleData == 'user_id' || $singleData == 'updated_at' || $singleData == 'lecture_id')
            throw new \yii\web\HttpException(403, 'You have enter column that cannot be altered: ' .$singleData);
            if($singleData == 'status' || $singleData == 'present') {
                if($value < 0 || $value >= 1)
                  $value = 1;
                else
                  $value = 0;
                $model->$singleData = $value;
            }
        }
        $model->updated_at = date("Y-m-d h:i:s");
        if(!$model->save())
        throw new \yii\web\HttpException(403, json_encode($model->getErrors()));
        else
        return[$model];
        }
        else
        throw new \yii\web\HttpException(404, 'Applier not found on ID: ' .$data['id']);

    }

}
