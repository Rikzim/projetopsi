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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/local-cultural', 
                    'pluralize' => true,
                    'extraPatterns' => [
                        'GET distrito/{nome}' => 'distrito', // Permite filtrar por distrito
                        'GET tipo-local/{nome}' => 'tipo-local', // Permite filtrar por tipo de local
                        'GET search/{nome}' => 'search', // Permite pesquisa por nome
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{nome}' => '<nome:[a-zA-Z0-9\\-]+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/noticia', // Necessário ter Autenticação
                    'pluralize' => true,
                    'extraPatterns' => [
                        'GET tipo-local/{nome}' => 'tipo-local', // Permite filtrar por tipo de local
                        'GET search/{nome}' => 'search', // Permite pesquisa por nome
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{nome}' => '<nome:[a-zA-Z0-9\\-]+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/evento', // Necessário ter Autenticação
                    'pluralize' => true,
                    'extraPatterns' => [
                        'GET tipo-local/{nome}' => 'tipo-local', // Permite filtrar por tipo de local
                        'GET search/{nome}' => 'search', // Permite pesquisa por nome
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{nome}' => '<nome:[a-zA-Z0-9\\-]+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                    'api/avaliacao',
                    'api/distrito',
                    'api/favorito',
                    'api/linha-reserva',
                    'api/login-form', //Funciona
                    'api/signup-form', //Funciona
                    'api/reserva', 
                    'api/tipo-bilhete',
                    'api/tipo-local',
                    'api/user',
                    'api/user-profile',
                    'api/mapa',
                    ],
                    'pluralize' => true,
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{nome}' => '<nome:[a-zA-Z0-9\\-]+>',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];