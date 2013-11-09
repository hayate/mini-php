<?php

define('ROOTPATH', dirname(dirname(__FILE__)) . '/' );
define('APPPATH', ROOTPATH . 'application/');
define('MINIPATH', ROOTPATH . 'mini/');

require_once MINIPATH . 'mini.php';
use Mini\Mini;

$router = Mini::instance();
$router->run();
