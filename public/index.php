<?php

declare(strict_types=1);

session_start();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('STORAGE_PATH', BASE_PATH . '/storage');

require APP_PATH . '/Helpers/functions.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = APP_PATH . '/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

$app = new App\Core\App(require APP_PATH . '/Config/routes.php');
$app->run();
