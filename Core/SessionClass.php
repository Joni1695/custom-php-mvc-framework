<?php 
	defined('BASE_PATH') OR exit('No direct script access allowed');

	class SessionClass{
		const SESSION_STARTED = TRUE;
	    const SESSION_NOT_STARTED = FALSE;
	    
	    private $sessionState = self::SESSION_NOT_STARTED;
	    static $instance;

	    public function __construct(){
	        $this->startSession();
	        self::$instance=$this;
	    }
	    
	    public function startSession()
	    {
	        if ( $this->sessionState == self::SESSION_NOT_STARTED )
	        {
	            $this->sessionState = session_start();
	        }
	        
	        return $this->sessionState;
	    }
	    
	    public function __set( $name , $value )
	    {
	        $_SESSION[$name] = $value;
	    }
	    
	    public function __get( $name )
	    {
	        if ( isset($_SESSION[$name]))
	        {
	            return $_SESSION[$name];
	        }
	    }
	    
	    public function __isset( $name )
	    {
	        return isset($_SESSION[$name]);
	    }
	    
	    
	    public function __unset( $name )
	    {
	        unset( $_SESSION[$name] );
	    }
	    
	    public function destroy()
	    {
	        if ( $this->sessionState == self::SESSION_STARTED )
	        {
	            $this->sessionState = !session_destroy();
	            unset( $_SESSION );
	            
	            return !$this->sessionState;
	        }
	        
	        return FALSE;
	    }
	}
?>