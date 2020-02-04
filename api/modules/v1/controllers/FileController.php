<?php

namespace api\modules\v1\controllers;

use Yii;
use api\components\Authorisation;
use common\models\Files;
use yii\rest\ActiveController;
use yii\helpers\Url;

class FileController extends ActiveController
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

    public function actionIndex() {
        if(Yii::$app->request->get()){
            $data = Yii::$app->request->get();
            if(!is_numeric($data['id']))
            return $this->actionFileByLecture();
            $findFile = Files::find()->where(['id' => $data['id']])->one();
            if(!$findFile)
            throw new \yii\web\HttpException(404, 'The requested ID could not be found.');
            $basicInfo['id'] = $findFile->id;
            $basicInfo['lecture_id'] = $findFile->lecture_id;
            $basicInfo['file_path'] = $findFile->file_path;
            return[$basicInfo];
        }
        else  {
            $findFiles = Files::find()->all();
            if(!$findFiles)
            throw new \yii\web\HttpException(404, 'Files not found');
            else{
            foreach($findFiles as $findFile) {
                $basicInfo['id'] = $findFile->id;
                $basicInfo['lecture_id'] = $findFile->lecture_id;
                $basicInfo['file_path'] = $findFile->file_path;
                $finalInfo[] = $basicInfo;
            }
           return[$finalInfo];
         }
        }
    }
    public function actionFileByLecture() {
        if(Yii::$app->request->get()  && is_numeric(Yii::$app->request->get()['id'])){
            $data = Yii::$app->request->get();
            $findFiles = Files::find()->where(['lecture_id' => $data['id']])->all();
            if(!$findFiles)
            throw new \yii\web\HttpException(404, 'The requested ID could not be found.');
            foreach($findFiles as $findFile) {
                $basicInfo['id'] = $findFile->id;
                $basicInfo['lecture_id'] = $findFile->lecture_id;
                $basicInfo['file_path'] = $findFile->file_path;
                $basicInfo['created_at'] = $findFile->created_at;
                $basicInfo['updated_at'] = $findFile->updated_at;
                $finalInfo[] = $basicInfo;
            }
            return[$finalInfo];
        }
        else
        throw new \yii\web\HttpException(400, 'ID was not provided.');
    }
    public function actionCreate(){
        $data = Yii::$app->request->get();
        $model = new Files();
        $model->lecture_id = $data['lecture_id'];
        $model->file_path = $data['file_path'];
        $model->status = 1;
        $model->created_at = date('Y-m-d H:i:s');
        if(!$model->save())
        throw new \yii\web\HttpException(404, json_encode($model->getErrors()));
        else return[$model];
    }
    public function actionUpdate() {
        $data = Yii::$app->request->get();
        $model = Files::find()->where(['id' => $data['id']])->one();
        if($model->status == 1)
        $model->status = 0;
        else
          $model->status = 1;
        $model->updated_at = date('Y-m-d H:i:s');
        if(!$model->save())
        throw new \yii\web\HttpException(404, json_encode($model->getErrors()));
        else return[$model];

    }
}
