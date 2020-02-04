<?php

namespace api\modules\v1;

use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init()
    {
        parent::init();
    }


}
