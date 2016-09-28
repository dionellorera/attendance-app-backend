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

require __DIR__ . '/../vendor/autoload.php';
require_once 'php-activerecord/ActiveRecord.php';
session_start();
header("Content-Type: application/json");
//initialize mysql
ActiveRecord\Config::initialize(function($cfg){
   $cfg->set_model_directory(__DIR__ . '/model');
   $cfg->set_connections(array('development' =>
     'mysql://root:@localhost/attendance'));
});
// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php'; 
 

// Run app
$app->run();
