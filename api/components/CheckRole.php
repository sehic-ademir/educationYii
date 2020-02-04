<?php

namespace  api\components;

use api\modules\v1\models\Token;
use api\modules\v1\models\User;
use yii\base\Behavior;
use Yii;

class CheckRole extends Behavior
{

    public $rules = [];

    public $tokenData = null;
    public $action;

    public function exitWithError($httpStatusCode, $errorMessage, $errorCode, $function)
    {
        $errorData = [
            "error_message" => $errorMessage,
            "error_code" => $errorCode,
            "error_in_function" => $function
        ];

        $response = Yii::$app->response;

        $response->statusCode = $httpStatusCode;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $errorData;

    }


    public function init()
    {
        if($this->checkRole()===Yii::$app->params['sysadmin']) {
            die();
            return true;
        }else{
            return $this->exitWithError('401', Yii::t('app','You have not permission for this action'), '1000',Yii::$app->controller->id . '/update');

        }

    }

    public function checkRole(){
        $headers = Yii::$app->request->headers;
        $token = $headers->get("Authorization");
        $token = str_replace('Bearer ','', $token);
        $this->tokenData = Token::find()->where(['token' => $token])->one();
        $user=User::find()->where(['id'=>$this->tokenData->user_id])->one();
        return $user->sysadmin;
    }
}