<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');
	class RouterClass{
		static private $urlKeywords=array();
		private $baseURL;
		static private $routeKeywords=array();
		static private $routeRedirectKeywords=array();
		private $scriptName;
		private $route;
		private $data;
		function __construct($routes){

			//Initialize the routes
			foreach($routes as $key => $value){
				self::$routeKeywords[]=explode('/',$key);
				self::$routeRedirectKeywords[]=explode('/',$value);
			}
			//Initialize the script location, keywords and base url
			$this->scriptName=explode('/',trim($_SERVER['SCRIPT_NAME'],'/'));
			self::$urlKeywords=explode('/',trim($_SERVER['REQUEST_URI'],'/'));
			$this->baseURL=array();

			//Break the URL
			RouterClass::breakURL();

			foreach (self::$urlKeywords as $value) $value=htmlentities($value);

			//Route using URL
			RouterClass::route('URL');
			
		}

		static function route($routePath){
			$data=array();
			//Routing through URL
			if(strcmp($routePath,'URL')==0){
				$index=self::matchRoute(self::$urlKeywords,self::$routeKeywords);
				
				//If empty, means direct at home
				if($index==-1 && sizeof(self::$urlKeywords)==0){
					 $index=0;
					 $controllerName=self::$routeRedirectKeywords[$index][0];
					 $methodName=self::$routeRedirectKeywords[$index][1];
					 for($i=2;$i<sizeof(self::$urlKeywords);$i++) $data[$i]=self::$routeRedirectKeywords[$index][$i];
				}
				//URL not empty
				else{
					//There is a pre-defined route
					if($index!=-1){
						for($i=0;$i<sizeof(self::$urlKeywords);$i++){
							if(strcmp(self::$routeKeywords[$index][$i],'$var')==0) $data[$i]=self::$urlKeywords[$i];
						}
						$controllerName=self::$routeRedirectKeywords[$index][0];
						$methodName=self::$routeRedirectKeywords[$index][1];	
					//There is not a pre-defined route
					} else{
						$controllerName=self::$urlKeywords[0];
						if(sizeof(self::$urlKeywords)>=2) $methodName=self::$urlKeywords[1];
						for($i=2;$i<sizeof(self::$urlKeywords);$i++) $data[$i]=self::$urlKeywords[$i];
					}
				}
			//Routing through routes path
			}	else{
				header("Location: ".BASE_URL.$routePath);
				die();
			}


			//We check if controller and method exist
			$problemLoading=false;
			if(!class_exists($controllerName)) $problemLoading=true;
			if(!method_exists($controllerName, $methodName)) $problemLoading=true;

			//If problem was found loading the controller and its respective method then load the 404
			if($problemLoading==true){
				$Object404=new Controller404();
			}	else{
				$Controller=new $controllerName();
				call_user_func_array([$Controller,$methodName], $data);
			}

		}

		//Check if there is a pre-defined route, return -1 if not
		static function matchRoute($urlKeywords,$routeKeywords){
			$matchedRoutes=-1;
			for($i=0;$i<sizeof($routeKeywords);$i++){
				if(sizeof($urlKeywords)==sizeof($routeKeywords[$i])){
					$match=true;
					for($j=0;$j<sizeof($routeKeywords[$i]);$j++){
						if(strcmp($urlKeywords[$j],$routeKeywords[$i][$j])!=0 && strcmp($routeKeywords[$i][$j],'$var')!=0){
							$match=false;
							break;
						}
					}
					if($match) $matchedRoutes=$i;
				}
			}
			return $matchedRoutes;
		}

		//Separates URL into keywords and determines baseURL
		function breakURL(){
			for($i=0;$i<sizeof($this->scriptName)-1;$i++) {
				if(strcmp($this->scriptName[$i],self::$urlKeywords[$i])==0){
					$this->baseURL[$i]=$this->scriptName[$i];
					array_shift(self::$urlKeywords);
				}
				else break;
			}
			array_unshift($this->baseURL,$_SERVER['HTTP_HOST']);
		}
	}
 ?>