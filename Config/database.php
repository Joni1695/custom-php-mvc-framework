<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');

	/* DATABASE DATA */
	/* TRUE if project uses database, false on the contrary */
	$database['DATABASE']=true;
	/* $database[DATABASE_ID][PARAMETER] so it can support multiple databases at once*/
	/* DATABASE TYPE can be mysqli or sqlserver */
	$database['default']['DATABASE_TYPE']='mysqli';
	/* DATABASE NAME */
	$database['default']['DATABASE_NAME']='csd_database';
	/* NAME OF USER TO AUTHENTICATE , in case of sqlserver windows authentication leave both password and user empty*/
	$database['default']['DATABASE_USER']='root';
	/* PASSWORD TO CONNECT WITH */
	$database['default']['DATABASE_PASSWORD']='';
	/* DATABASE ADDRESS */
	$database['default']['DATABASE_ADDRESS']='localhost';
	/* DATABASE PORT , if not specified default will be 1433 for sqlserver and 3306 for mysqli*/
	$database['default']['DATABASE_PORT']='';
	/* DATABASE GENERATE , if set to true models will be automatically created*/
	$database['default']['DATABASE_AUTOGEN']=true;

 ?>