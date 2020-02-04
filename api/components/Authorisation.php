<?php

namespace api\components;

use api\modules\v1\models\ApiCustomer;
use yii\base\Behavior;
use Yii;
use backend\models\Admin;
class Authorisation extends Behavior
{

    public $rules = [];

    public $tokenData = null;
    public $action;

    public function init()
    {
        $headers = Yii::$app->request->headers;
        $token = $headers->get("Authorization");

        if (empty($token)) {
            $this->exitWithAuthorisationError();
        }
        if (strpos($token, 'Bearer') === false) {
            $this->exitWithAuthorisationError();
        }
        $token = str_replace('Bearer ', '', $token);


        $project = Admin::find()->where(['auth_key' => $token])->one();

        if (!$project) {
            $this->exitWithAuthorisationError();
        }

    }

    private function exitWithAuthorisationError()
    {
        $errorData = [
            "error_message" => "Token is invalid or expired.",
            "error_code" => "124",
        ];

        $response = Yii::$app->response;

        $response->statusCode = 401;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $errorData;

        $response->send();
        die();
    }
}