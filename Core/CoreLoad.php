<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');

	require_once(CONFIG_PATH.'/init.php');
	require_once(CONFIG_PATH.'/route.php');
	require_once(CONFIG_PATH.'/database.php');

	define('BASE_URL',$config['BASE_URL']);

	require_once(CORE_PATH.'/SecurityClass.php');
	require_once(CORE_PATH.'/DatabaseClass.php');
	require_once(CORE_PATH.'/ControllerClass.php');
	require_once(CORE_PATH.'/ModelClass.php');
	require_once(CORE_PATH.'/RouterClass.php');
	require_once(CORE_PATH.'/SessionClass.php');

	foreach (scandir(getcwd().'/Controllers') as $controller) {
		if(strcmp($controller,'.htaccess')!=0 && strcmp($controller,'.')!=0 && strcmp($controller,'..')!=0){
			require_once(CONTROLLER_PATH.'/'.$controller);
		}
	}
	foreach (scandir(getcwd().'/Libraries') as $library) {
		if(strcmp($library,'.htaccess')!=0 && strcmp($library,'.')!=0 && strcmp($library,'..')!=0){
			require_once(LIBRARY_PATH.'/'.$library);
		}
	}

	$DB=new DatabaseClass($database);
	$Security=new SecurityClass();
	$Session=new SessionClass();
	$Router=new RouterClass($route);

?>