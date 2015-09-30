<?php
$method = strtolower($_SERVER['REQUEST_METHOD']);
$http_vars = array();

switch($method){
	case 'get':
		$CONTEXT =& $_GET;
		$http_vars = ""; //$HTTP_GET_VARS;
		break;
	case 'post':
		$CONTEXT =& $_POST;
		$http_vars = ""; //$HTTP_GET_VARS;
		break;
	default:
		$CONTEXT = array();
		break;
}

function sanitize($var){
	$var = htmlspecialchars ($var,ENT_NOQUOTES); 
	if(!get_magic_quotes_gpc()) {
		 $var  = addslashes($var); 
	}
	return utf8_decode($var);
}

function validate_url($url){
    static $urlregex = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";

    return eregi($urlregex, $url);
}

function validate_characters($txt){
    $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.";
    for ($i=0; $i<strlen($txt); $i++) {
        if (strpos($permitidos, substr($txt,$i,1))===false){ 
            return false;
        }
    }
    return true;
}

function generate_password(){
	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ";
	$numbers = "0123456789";
	$symbols = ".:,;?-_!$%&#()=+";
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
	$alphaLength = strlen($numbers) - 1; //put the length -1 in cache
    for ($i = 0; $i < 3; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $numbers[$n];
    }
	$alphaLength = strlen($symbols) - 1; //put the length -1 in cache
    for ($i = 0; $i < 2; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $symbols[$n];
    } 
	return implode( shuffle( $pass ) );
}

function get_timestamp( $string, $delimeter = "/", $hastime = FALSE, $direction = 0 ){
	if ( $hastime ){ 
		list( $string , $time_str ) = explode(" ", $string);
		list( $H, $i, $s ) = explode( ":", $time_str );
	} else {
		switch ( $direction ) { 
			case -1:  $H = 0; 	$i = 0; 	$s = 1; 	break;
			case 1: $H = 23; 	$i = 59; 	$s = 59; 	break;  
			default:
			case 0:  $H = 12; 	$i = 0; 	$s = 0; 	break;
		}
	}
	
	list( $Y, $m, $d ) = explode($delimeter, $string);
	
	return mktime( $H, $i, $s, $m, $d, $Y  );
	
}

?>