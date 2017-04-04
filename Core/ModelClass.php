<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');

	class ModelClass{
		private $query;
		private $data_result;
		private $connection;
		private $connectionType;

		function __construct(){
			$this->db_select(key(DatabaseClass::$dbs));
			$this->query='';
		}

		function db_select($key){
			if(array_key_exists($key, DatabaseClass::$dbs)){
				$this->connection=DatabaseClass::$dbs[$key];
				if(is_object(DatabaseClass::$dbs[$key]) && get_class(DatabaseClass::$dbs[$key])!=false)	$this->connectionType=get_class(DatabaseClass::$dbs[$key]);
				else if(get_resource_type(DatabaseClass::$dbs[$key])!=NULL) $this->connectionType=get_resource_type(DatabaseClass::$dbs[$key]);
				else if(PRODUCTION_MODE=='development') echo 'Error translating database connection.';
			}	
			else if(PRODUCTION_MODE=='development') echo 'Database key does not exist.';
		}

		function do_query($myquery){
			if($this->connectionType=='mysqli'){
				$data_result=mysqli_query($this->connection,$myquery);
				if($data_result==false){
					if(PRODUCTION_MODE=='development') echo mysqli_error($this->connection);
					return false;
				}	else if($data_result==TRUE && is_object($data_result)){
					$i=0;
					$data['num_rows']=$data_result->num_rows;
					while($row=mysqli_fetch_assoc($data_result)){
						$data[]=$row;
					}
					mysqli_free_result($data_result);
					return $data;
				}	else return true;
				//end of mysqli
			}	else if($this->connectionType=='SQL Server Connection'){
				if(($data_result=sqlsrv_query($this->connection,$myquery))===false){
					if(PRODUCTION_MODE=='development')	die( print_r( sqlsrv_errors(), true));
				}	else{
					if(($row=sqlsrv_fetch_array($data_result,SQLSRV_FETCH_ASSOC))===false) return true;
					else{
						$data[]=$row;
						while($row=sqlsrv_fetch_array($data_result,SQLSRV_FETCH_ASSOC)){
							$data[]=$row;
						}
						sqlsrv_free_stmt($data_result);
						return $data;
					}
				}
			}//end of sqlsrv
		}//end of query

		function clear_query(){
			$this->query='';
		}

		function get_query(){
			return $query;
		}

	} 
 ?>