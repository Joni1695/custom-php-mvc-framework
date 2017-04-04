<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');

	class SecurityClass{
		function __construct(){
		
		}
		static function dbEscape($query,$type){
			if($type=='mysqli'){
				return htmlentities($query);
			}	else if($type=='SQL Server Connection'){
				if ( !isset($query) or empty($query) ) return '';
		        if ( is_numeric($query) ) return $query;

		        $non_displayables = array(
		            '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
		            '/%1[0-9a-f]/',             // url encoded 16-31
		            '/[\x00-\x08]/',            // 00-08
		            '/\x0b/',                   // 11
		            '/\x0c/',                   // 12
		            '/[\x0e-\x1f]/'             // 14-31
		        );
		        foreach ( $non_displayables as $regex )
		            $query = preg_replace( $regex, '', $query );
		        return $query;
			}
		}
		static function hashPasswords($password){
			return crypt($password,sprintf("$2a$%02d$", 10).strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.'));
		}

		static function equalHash($password,$hash){
			return hash_equals(crypt($password,$hash),$hash);
		}
	}
 ?>