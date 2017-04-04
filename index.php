<?php 

	/* CUSTOM PHP MVC FRAMEWORK */
	/*
		* @desc Definde the mode in which the framework will work, development or production. If development, all errors will be shown to make development 
		* easier. If production all errors will be hidden. This will be developer customizable.
	 */
	define('PRODUCTION_MODE','development');

	/*
		* @desc In case of development, all errors showing. Otherwise checking php version to apply correct error hiding.
		* @param PRODUCTION_MODE - Mode of production
	*/
	switch(PRODUCTION_MODE){
		case 'development':
			error_reporting(-1);
			ini_set('display_errors', 1);
		break;
		case 'production':
			ini_set('display_errors', 0);
			if (version_compare(PHP_VERSION, '5.3', '>='))
			{
				error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
			}
			else
			{
				error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
			}
		break;
		default:
			die('Wrong Production Mode. Only Values Allowed are development or production.');
		break;
	}
	
	/*
		* @desc Define all system paths
	*/
	define('BASE_PATH',realpath(''));
	define('CORE_PATH',BASE_PATH.'/Core');
	define('CONFIG_PATH',BASE_PATH.'/Config');
	define('CONTROLLER_PATH',BASE_PATH.'/Controllers');
	define('VIEW_PATH',BASE_PATH.'/Views');
	define('MODEL_PATH',BASE_PATH.'/Models');
	define('LIBRARY_PATH',BASE_PATH.'/Libraries');

	require_once(CORE_PATH.'/CoreLoad.php');
?> 