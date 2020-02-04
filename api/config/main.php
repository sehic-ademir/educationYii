<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    //'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    //'sourceLanguage' => 'en-US',
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'   // here is our v1 modules
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user'],
                    'tokens' => ['{id}' => '<id:\\w+>' ],
                    'extraPatterns' => [
                        'GET {id}' => 'index',
                        'POST create' => 'create',
                        'PUT update' => 'update'
                    ],


                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/lecture'],
                    'tokens' => ['{id}' => '<id:\\w+>' ],
                    'extraPatterns' => [
                        'GET {id}' => 'index',
                        'PUT update' => 'update',
                        'POST create' => 'create'
                    ],

                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/file'],
                    'tokens' => ['{id}' => '<id:\\w+>' ],
                    'extraPatterns' => [
                        'GET {id}' => 'index',
                        'GET lectureid/{id}' => 'file-by-lecture',
                        'POST create' => 'create',
                        'PUT update' => 'update'
                    ],

                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/skill'],
                    'tokens' => ['{id}' => '<id:\\w+>' ],
                    'extraPatterns' => [
                        'GET {id}' => 'index',
                        'GET userid/{id}' => 'skill-by-user',
                        'POST create' => 'create',
                        'PUT update' => 'update'
                    ],

                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/homework'],
                    'tokens' => ['{id}' => '<id:\\w+>' ],
                    'extraPatterns' => [
                        'GET {id}' => 'index',
                        'POST create' => 'create',
                        'PUT update' => 'update'
                    ],

                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/admin'],
                    'tokens' => ['{id}' => '<id:\\w+>' ],
                    'extraPatterns' => [
                        'GET {id}' => 'index',
                        'POST create' => 'create',
                        'PUT update' => 'update'
                    ],

                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/lecture-applier'],
                    'tokens' => ['{id}' => '<id:\\w+>' ],
                    'extraPatterns' => [
                        'GET {id}' => 'index',
                        'POST create' => 'create',
                        'PUT update' => 'update'
                    ],

                ],

        ]
    ],

],
    'params' => $params,

];
