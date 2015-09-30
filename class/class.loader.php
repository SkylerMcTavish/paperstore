<?php
/**
 * class Loader
 * 
 * 
 */ 
abstract class Loader extends Object {
	
	protected $handle;
	public $processed = 0;
	public $saved = 0;
	public $line = 0;
	
	function __construct() {
		
	} 
	
	function validate_file(){
		
	}
	
	function validate_header(){
		
	}
	
	function get_line(){
		
	}
	
	protected function close_file(){ 
		try { 
			if ( $this->handle ){
				return fclose($this->handle); 
			}
		} catch (Exception $e){
			$this->handle = FALSE;
			return FALSE;
		} 
	}
	
	protected function open_file( $route ){  
		try {
			$this->handle = fopen( $route, "r" ); 
			if ( $this->handle === FALSE ){
				$this->set_error( "Could not open File. ", ERR_FILE_NOT_FOUND);
				return FALSE;
			} else return TRUE;
		} catch (Exception $e){
			$this->handle = FALSE;
			return FALSE;
		} 
	}
	
}
?>