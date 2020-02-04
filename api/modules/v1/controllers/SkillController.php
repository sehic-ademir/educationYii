<?php

namespace api\modules\v1\controllers;

use Yii;
use api\components\Authorisation;
use common\models\User;
use common\models\UserSkill;
use yii\rest\ActiveController;
use yii\helpers\Url;

class SkillController extends ActiveController
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
        $findSkill = UserSkill::find()->where(['id' => $data['id']])->one();
        if(!$findSkill)
        throw new \yii\web\HttpException(400, 'The requested ID could not be found.');
        $basicInfo['id'] = $findSkill->id;
        $basicInfo['user_id'] = $findSkill->user_id;
        $basicInfo['skill_name'] = $findSkill->skill_name;
        $basicInfo['status'] = $findSkill->status;
        $basicInfo['created_at'] = $findSkill->created_at;
        $basicInfo['updated_at'] = $findSkill->updated_at;
        return[$basicInfo];
    }
        else  {

        $findSkills = UserSkill::find()->all();
        if(!$findSkills)
        throw new \yii\web\HttpException(404, 'Skills not found');
        else{
        foreach($findSkills as $findSkill) {
            $basicInfo['id'] = $findSkill->id;
            $basicInfo['user_id'] = $findSkill->user_id;
            $basicInfo['skill_name'] = $findSkill->skill_name;
            $basicInfo['status'] = $findSkill->status;
            $basicInfo['created_at'] = $findSkill->created_at;
            $basicInfo['updated_at'] = $findSkill->updated_at;
            $finalInfo[] = $basicInfo;
        }
       return[$finalInfo];
     }
    }
}
    public function actionCreate(){
        $data = Yii::$app->request->get();
        $model = new UserSkill();
        $model->user_id = $data['user_id'];
        $model->created_at = date('Y-m-d H:i:s');
        $model->skill_name = $data['skill_name'];
        $model->status = 1;
        if(!$model->save())
        throw new \yii\web\HttpException(403, json_encode($model->getErrors()));
        else
        return[$model];
    }
    public function actionUpdate(){
        $data = Yii::$app->request->get();
        $model = UserSkill::find()->where(['id' => $data['id']])->one();
        if($model) {
        foreach($data as $singleData => $value) {
            if($singleData == 'created_at' || $singleData == 'user_id' || $singleData == 'updated_at' || $singleData == "skill_name")
            throw new \yii\web\HttpException(403, 'You have enter column that cannot be altered: ' .$singleData);
            if($singleData == 'status') {
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
        throw new \yii\web\HttpException(404, 'Skill not found on ID: ' .$data['id']);

    }

}
