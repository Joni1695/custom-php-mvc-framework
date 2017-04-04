<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');

	class Controller404 extends ControllerClass{
		public function __construct(){
			echo 'The page you request does not exist';
		}
	}
 ?>