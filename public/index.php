<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//Load environmental variables
require_once(__DIR__ . "/../DotEnv.php");
(new DotEnv(__DIR__ . '/../.env'))->load();


require_once __DIR__ . '/../vendor/autoload.php';

// Define path to application directory
define('APPLICATION_PATH', substr(realpath(__DIR__), 0, -6));


// Route dispatch
$router = new Core\Router();
$router->dispatch();
