<?php

namespace api\modules\v1\controllers;

use Yii;
use api\components\Authorisation;
use backend\models\Admin;
use yii\rest\ActiveController;
use yii\helpers\Url;

class AdminController extends ActiveController
{
    public $modelClass = Admin::class;

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
         $findUser = Admin::find()->where(['id' => $data['id']])->one();
         if(!$findUser)
         throw new \yii\web\HttpException(404, 'The requested ID could not be found.');
         $basicInfo['id'] = $findUser->id;
         $basicInfo['username'] = $findUser->username;
         $basicInfo['email'] = $findUser->email;
         $basicInfo['created_at'] = $findUser->created_at;
         $basicInfo['updated_at'] = $findUser->updated_at;
         $basicInfo['password_hash'] = $findUser->password_hash;
         $basicInfo['password_reset_token'] = $findUser->password_reset_token;
         $basicInfo['auth_key'] = $findUser->auth_key;
         return[$basicInfo];
     }
         else  {
         $findUsers = Admin::find()->all();
         if(!$findUsers)
         throw new \yii\web\HttpException(404, 'Users not found');
         else{
         foreach($findUsers as $findUser) {
             $basicInfo['id'] = $findUser->id;
             $basicInfo['username'] = $findUser->username;
             $basicInfo['email'] = $findUser->email;
             $basicInfo['created_at'] = $findUser->created_at;
             $basicInfo['updated_at'] = $findUser->updated_at;
             $basicInfo['password_hash'] = $findUser->password_hash;
             $basicInfo['password_reset_token'] = $findUser->password_reset_token;
             $basicInfo['auth_key'] = $findUser->auth_key;
             $finalInfo[] = $basicInfo;
         }
        return[$finalInfo];
      }
     }
 }
    public function actionCreate(){
        $data = Yii::$app->request->get();
        if($this->checkUnique($data['username'], 'username'))
        throw new \yii\web\HttpException(403, 'Username already taken.');
        if($this->checkUnique($data['email'], 'email'))
        throw new \yii\web\HttpException(403, 'Email already taken.');
        $model = new Admin();
        $model->username = $data['username'];
        $model->setPassword($data['password']);
        $model->email = $data['email'];
        $model->birthday = date('1970-01-01');
        $model->generateAuthKey();
        $model->generateEmailVerificationToken();
        if(!$model->save())
        throw new \yii\web\HttpException(404, json_encode($model->getErrors()));
        else
        return[$model];
    }
    public function actionUpdate(){
        $data = Yii::$app->request->get();
        $model = Admin::find()->where(['id' => $data['id']])->one();
        if(!$model)
        throw new \yii\web\HttpException(404, 'Admin ID: ' .$data['id'] .' not found');
        else{
        $table = Yii::$app->db->schema->getTableSchema('admin');
        foreach($data as $singleData => $value) {
            if($singleData == 'email' && $this->checkUnique($data[$singleData], 'email'))
            throw new \yii\web\HttpException(403, 'Email already taken.');
            if(!isset($table->columns[$singleData]) && $singleData != 'password')
            throw new \yii\web\HttpException(404, 'You have enter column that does not exist: ' . $singleData);
            if($singleData == 'username' || $singleData == 'auth_key' || $singleData == 'verification_token')
            throw new \yii\web\HttpException(403, 'You have enter column that cannot be altered: ' .$singleData);

            $model->$singleData = $value;
        }
        $model->updated_at = date("Y-m-d h:i:s");
        if(!$model->save())
        throw new \yii\web\HttpException(404, json_encode($model->getErrors()));
        else
        return[$model];
      }
        }
    public function checkUnique($key, $column) {
        $searchDb = Admin::find()->where([$column => $key])->one();
        if($searchDb)
        return true;
        else return false;
    }
}
