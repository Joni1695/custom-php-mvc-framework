<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');
	
	class ControllerClass{
		public static function load_view($viewName,$data){
			extract($data);
			require_once VIEW_PATH.'/'.$viewName.'.php';
		}
		public static function load_model($modelName){
			require_once MODEL_PATH.'/'.$modelName.'.php';
			$model=new $modelName();
			return $model;
		}
	}
 ?>