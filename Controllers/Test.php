<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');

	class Test extends ControllerClass{
		public function test(){
			echo 'U thirr test';
			$this->load_view('ViewTest',[]);
		}
	}
 ?>