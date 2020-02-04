<?php

namespace api\modules\v1\controllers;

use Yii;
use api\components\Authorisation;
use common\models\User;
use common\models\UserSkill;
use yii\rest\ActiveController;
use yii\helpers\Url;

class UserController extends ActiveController
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
         $findUser = User::find()->where(['id' => $data['id']])->one();
         if(!$findUser)
         throw new \yii\web\HttpException(404, 'The requested ID could not be found.');
         $basicInfo['id'] = $findUser->id;
         $basicInfo['username'] = $findUser->username;
         $basicInfo['first_name'] = $findUser->first_name;
         $basicInfo['last_name'] = $findUser->last_name;
         $basicInfo['phone_number'] = $findUser->phone_number;
         $basicInfo['email'] = $findUser->email;
         $basicInfo['birthday'] = $findUser->birthday;
         $basicInfo['city'] = $findUser->city;
         $basicInfo['approved'] = $findUser->approved;
         $basicInfo['gender'] = $findUser->gender;
         $basicInfo['photo_path'] = $findUser->photo_path;
         $basicInfo['created_at'] = $findUser->created_at;
         $basicInfo['updated_at'] = $findUser->updated_at;
         $basicInfo['password_hash'] = $findUser->password_hash;
         $basicInfo['password_reset_token'] = $findUser->password_reset_token;
         $basicInfo['auth_key'] = $findUser->auth_key;
         return[$basicInfo];
     }
         else  {
         $findUsers = User::find()->all();
         if(!$findUsers)
         throw new \yii\web\HttpException(404, 'Users not found');
         else{
         foreach($findUsers as $findUser) {
             $basicInfo['id'] = $findUser->id;
             $basicInfo['username'] = $findUser->username;
             $basicInfo['first_name'] = $findUser->first_name;
             $basicInfo['last_name'] = $findUser->last_name;
             $basicInfo['phone_number'] = $findUser->phone_number;
             $basicInfo['email'] = $findUser->email;
             $basicInfo['birthday'] = $findUser->birthday;
             $basicInfo['city'] = $findUser->city;
             $basicInfo['approved'] = $findUser->approved;
             $basicInfo['gender'] = $findUser->gender;
             $basicInfo['photo_path'] = $findUser->photo_path;
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
        $model = new User();
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
        $model = User::find()->where(['id' => $data['id']])->one();
        $table = Yii::$app->db->schema->getTableSchema('user');
        foreach($data as $singleData => $value) {
            if($singleData == 'email' && $this->checkUnique($data[$singleData], 'email'))
            throw new \yii\web\HttpException(403, 'Email already taken.');
            if(!isset($table->columns[$singleData]) && $singleData != 'password')
            throw new \yii\web\HttpException(404, 'You have enter column that does not exist: ' . $singleData);
            if($singleData == 'username' || $singleData == 'email' || $singleData == 'auth_key' || $singleData == 'verification_token')
            throw new \yii\web\HttpException(403, 'You have enter column that cannot be altered: ' .$singleData);

            $model->$singleData = $value;
        }
        $model->updated_at = date("Y-m-d h:i:s");
        if(!$model->save())
        throw new \yii\web\HttpException(404, json_encode($model->getErrors()));
        else
        return[$model];
        }
    public function checkUnique($key, $column) {
        $searchDb = User::find()->where([$column => $key])->one();
        if($searchDb)
        return true;
        else return false;
    }
}
