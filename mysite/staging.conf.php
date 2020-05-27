<?php

global $databaseConfig;
$databaseConfig = array(
	'type' => 'MySQLDatabase',
	'server' => 'localhost',
	'username' => 'root',
	'password' => 'bskcYo3KUnUFWZCu',
	'database' => 'nedc',
	'path' => ''
);

//Director::set_environment_type('dev');

Security::setDefaultAdmin('admin', 'password');
