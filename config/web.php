<?php

$version = $_ENV['VERSION'] ?? YII_ENV;
$config = [
    'id' => 'flyo-nitro-example',
    'basePath' => dirname(__DIR__),
    'version' => $version,
    'language' => 'de-CH',
    'timeZone' => 'Europe/Zurich',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '!*t63Ch@M_.nxN*tNpHtpkdjYkN-R_.XA*yrpFcqmfTFc9ZXv_jJmm9*MW8s_JC9',
            'scriptUrl' => 'index.php',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@app/cache'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '' => 'site/index',
            ],
        ],
    ],
];

if (YII_DEBUG) {
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
    $config['bootstrap'][] = 'debug';
}

return $config;