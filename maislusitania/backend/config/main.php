<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => '+Lusitânia',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        // ADICIONA ISTO ↓
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            // ADICIONA ISTO ↓ (para aceitar JSON)
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'GET api/local-culturals/distritos/<nome:\w+>' => 'api/local-cultural/distritos',
                'GET api/local-culturals/tipos/<nome:\w+>' => 'api/local-cultural/tipos',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                    'api/avaliacao',
                    'api/distrito',
                    'api/evento',
                    'api/favorito',
                    'api/linha-reserva',
                    'api/local-cultural',
                    'api/login-form',
                    'api/signup-form',
                    'api/noticia',
                    'api/reserva',
                    'api/tipo-bilhete',
                    'api/tipo-local',
                    'api/user',
                    'api/user-profile',
                    ],
                    'pluralize' => true,
                    'extraPatterns' => [
                        'GET distrito/{nome}' => 'distritos',
                        //'GET locais-culturais' => 'actionLocaisCulturais',
                    ],
                    'tokens' => [
                        '{nome}' => '<nome:[a-zA-Z0-9\\-]+>',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];