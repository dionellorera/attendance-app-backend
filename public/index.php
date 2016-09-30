<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
header("Content-Type: application/json");
require __DIR__ . '/../vendor/autoload.php';
require_once 'php-activerecord/ActiveRecord.php';
session_start();

//initialize mysql
require __DIR__ . '/../src/active_record_settings.php';
// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings); 
// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php'; 
  

//Error handler, Slim 3 doesnt have this and returns html that makes the app crash
require __DIR__ . '/../src/error_handler.php';

// Run app 
$app->run();
