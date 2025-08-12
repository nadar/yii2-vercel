<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$debug = $_ENV['YII_DEBUG'] ?? false;
$env = $_ENV['YII_ENV'] ?? 'prod';

defined('YII_DEBUG') or define('YII_DEBUG', (bool) $debug);
defined('YII_ENV') or define('YII_ENV', $env);

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
