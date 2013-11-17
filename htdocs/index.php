<?php

define('ROOTPATH', dirname(dirname(__FILE__)) . '/' );
define('APPPATH', ROOTPATH . 'application/');
define('MINIPATH', ROOTPATH . 'mini/');

require_once ROOTPATH . 'config.php';
require_once MINIPATH . 'autoloader.php';

// register mini and controllers autoloader
Mini\Autoloader::register();
// set configuration
Mini\Config::set($config);
// get instance of mini
$mini = Mini\Mini::instance();
// run app
$mini->run();
