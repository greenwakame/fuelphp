<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=localhost;dbname=fuel_db_devel;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock',
			'username'   => 'root',
			'password'   => 'root',
		),
	),
);
