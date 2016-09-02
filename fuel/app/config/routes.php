<?php
return array(
	'_root_'  => 'index/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
	'history' => array('history'),
	'history/:id' => 'history/detail/$1',
	'download/:id' => 'download/index/$1',
	'api/search_page' => array('api/search_page'),
);
