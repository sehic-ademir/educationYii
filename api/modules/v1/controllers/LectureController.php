<?php

namespace api\modules\v1\controllers;

use Yii;
use api\components\Authorisation;
use common\models\User;
use common\models\Edukacije;
use common\models\Files;
use yii\rest\ActiveController;
use yii\helpers\Url;

class LectureController extends ActiveController
{
    public $modelClass = Edukacije::class;

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
        if(!is_numeric($data['id']))
        return $this->actionFile();
        $findLecture = Edukacije::find()->where(['id' => $data['id']])->one();
        if(!$findLecture)
        throw new \yii\web\HttpException(404, 'The requested ID could not be found.');
        $basicInfo['id'] = $findLecture->id;
        $basicInfo['lecturer'] = $findLecture->lecturer;
        $basicInfo['lecture_title'] = $findLecture->lecture_title;
        $basicInfo['lecture_subject'] = $findLecture->subject;
        $basicInfo['lecture_date'] = $findLecture->lecture_date;
        $basicInfo['lecture_time'] = $findLecture->lecture_time;
        $basicInfo['status'] = $findLecture->status;
        $basicInfo['created_at'] = $findLecture->created_at;
        $basicInfo['updated_at'] = $findLecture->updated_at;
        return[$basicInfo];
    }
        else  {
        $findLectures = Edukacije::find()->all();
        foreach($findLectures as $findLecture) {
            $basicInfo['lecturer'] = $findLecture->lecturer;
            $basicInfo['lecture_title'] = $findLecture->lecture_title;
            $basicInfo['lecture_subject'] = $findLecture->subject;
            $basicInfo['lecture_date'] = $findLecture->lecture_date;
            $basicInfo['lecture_time'] = $findLecture->lecture_time;
            $basicInfo['status'] = $findLecture->status;
            $basicInfo['created_at'] = $findLecture->created_at;
            $basicInfo['updated_at'] = $findLecture->updated_at;
            $finalInfo[] = $basicInfo;
    }
       return[$finalInfo];
    }
}
    public function actionCreate(){
        $data = Yii::$app->request->get();
        $model = new Edukacije();

        foreach($data as $singleData => $value) {
            if($singleData == 'id' || $singleData == 'created_at' || $singleData == 'updated_at' || $singleData == 'status')
            throw new \yii\web\HttpException(403, 'You have enter column that cannot be altered: ' .$singleData);

            $model->$singleData = $value;
        }
        $model->status = 1;
        $model->created_at = date('yy-m-d H:i:s');
        if(!$model->save())
        throw new \yii\web\HttpException(404, json_encode($model->getErrors()));
        else return[$model];

    }
    public function actionUpdate(){
        $data = Yii::$app->request->get();
        $model = Edukacije::find()->where(['id' => $data['id']])->one();
        if($model){
            foreach($data as $singleData => $value) {
                if($singleData == 'created_at' || $singleData == 'updated_at')
                throw new \yii\web\HttpException(403, 'You have enter column that cannot be altered: ' .$singleData);
                if($singleData != 'id'){
                $model->$singleData = $value;
              }
                if($singleData == 'status'){
                    if($value >= 1)
                    $model->status = 1;
                    else
                    $model->status = 0;
                }
            }
            $model->updated_at = date('yy-m-d H:i:s');
            if(!$model->save())
            throw new \yii\web\HttpException(404, json_encode($model->getErrors()));


            return[$model];
            }
            else
            throw new \yii\web\HttpException(404, 'Lecture not found on ID: ' .$data['id']);
    }


}
