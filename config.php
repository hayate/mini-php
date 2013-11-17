<?php

// initialize configuration array
$config = array();

// set hostname
$config['domain'] = 'mini.dev';

// 3 = [info, debug, error], 2 = [debug, error], 1 = ['error']
$config['logging']['level'] = 3;
$config['logging']['path'] = ROOTPATH . 'logs/';
