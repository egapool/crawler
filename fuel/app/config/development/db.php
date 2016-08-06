<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'type'        => 'mysqli',
		'connection'   => array(
			'hostname'       => '127.0.0.1',
			'database'       => 'crawler',
			'username'       => 'root',
			'password'       => 'root',
			'port'           => '3306',
		 ),

		'profiling'    => true,
	),
);
