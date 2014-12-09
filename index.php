<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');


/* Global Variables */
$UID = '';

// Configuration file
require 'app/inc/config.php';

// Slim Framework
require 'vendor/Slim/Slim.php';

// useful functions
require 'app/inc/functions.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

/* some important template configurations */
define('VISITOR_HEADER','app/views/visitor/tpl/header.php');
define('VISITOR_FOOTER','app/views/visitor/tpl/footer.php');
define('VISITOR_VIEWS','app/views/visitor');

/* include routes */
require 'app/routes/service.php';
require 'app/routes/visitor.php';

$app->run();

