<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'homeUrl' => Yii::getAlias('@apiUrl'),
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            //'baseUrl' => Yii::getAlias('@project_folder_name') . '/api',
            'baseUrl' => '/purepetal/api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ],
            'enableCookieValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-api',
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
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8'
        ],
        'errorHandler' => [
            'errorAction' => 'api/error',
        ],

        // 'urlManager' => [
        //     'enablePrettyUrl' => true,
        //     'showScriptName' => false,
        //     'rules' => array(
        //     ),
        // ],

    ],
    'params' => $params,
];
