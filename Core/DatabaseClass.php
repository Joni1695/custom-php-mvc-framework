<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');

	class DatabaseClass{
		static $dbs;
		function __construct($database){
			if($database['DATABASE']==true){
				foreach($database as $key => $value){
					if(strcmp($key,'DATABASE')!=0) $this->connect_db($key,$database[$key]);
				}
			}//end of required db
			else if($database['DATABASE']!=false && PRODUCTION_MODE==='development') 
				exit('Wrong value at init file for DATABASE. Must be true or false.');

		}//end construct
		function connect_db($key,$database){
			// Check if variables are okay
			if((!isset($database['DATABASE_NAME']) || !isset($database['DATABASE_PORT']) || !isset($database['DATABASE_ADDRESS']) || !isset($database['DATABASE_TYPE']) || !isset($database['DATABASE_PASSWORD']) || !isset($database['DATABASE_USER'])) && PRODUCTION_MODE==='development') exit('Error with loading database values from init file.');
			// Different connections for mysqli and sqlserver
			switch($database['DATABASE_TYPE']){
				case 'mysqli':
					self::$dbs[$key]=mysqli_connect($database['DATABASE_ADDRESS'].':'.($database['DATABASE_PORT']!=='')?$database['DATABASE_PORT']:'3306',$database['DATABASE_USER'],$database['DATABASE_PASSWORD'],$database['DATABASE_NAME']);
					break;
				case 'sqlserver':
					(trim($database['DATABASE_PORT'])!=='')?$server=$database['DATABASE_ADDRESS'].', '.$database['DATABASE_PORT']:$server=$database['DATABASE_ADDRESS'].', 1433';
					$serverdata=array('Database' => $database['DATABASE_NAME']);
					if(trim($database['DATABASE_USER'])!==''){
						$serverdata['UID']=$database['DATABASE_USER'];
						$serverdata['PWD']=$database['DATABASE_PWD'];
					}
					self::$dbs[$key]=sqlsrv_connect($server,$serverdata);
					break;
				default:
					if(PRODUCTION_MODE==='development') exit('Database type not supported.');
					else exit('There was a problem, please contact the staff.');
					break;
			}//end of switch

			//Check connection
			if($database['DATABASE_TYPE']=='mysqli'){
				if(mysqli_connect_errno() && PRODUCTION_MODE=='development') exit('There was a problem connecting to the database.');
				else if(mysqli_connect_errno()) exit('There was a problem, please contact the staff.');
			} else{
				if(!self::$dbs[$key] && PRODUCTION_MODE=='development') exit('There was a problem connecting to the database.');
				else if(!self::$dbs[$key]) exit('There was a problem, please contact the staff.');
			}
		}// end of connect_db
	}//end class
?>