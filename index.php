<?php
	
	require_once 'define.php';
	require_once 'common.php';

	
	function my_autoloader($class){
		require LIBRARY_PATH . $class .'.php';
	 }
	 spl_autoload_register('my_autoloader');
	
	 Session::init();
	 $bootstrap = new Bootstrap();
	 $bootstrap->init();