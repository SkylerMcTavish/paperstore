<?php
/*****************	WEB Options Definitions ******************/
define("SYS_TITLE",				"SIC Mobile 3.0");
define("SYS_URL",				"http://localhost/paperv2");
define("WEB_MAIL",				"admin@sicmobile.com");
define('SYS_MAIL', 				'admin@sicmobile.com');
define('PFX_SYS', 				'sky_');

/****************** Main DB Configuration ******************/ 
//define("DB_HOST", 				'52.24.2.89');
define("DB_HOST", 				'localhost');
//define("DB_USERNAME", 			'skylarin_root');
//define("DB_PASSWORD", 			'Spartaco_141');
define("DB_USERNAME", 			'root');
define("DB_PASSWORD", 			'abcde12345!');
define("DB_NAME", 				'skylarin_paperv2');
define("PFX_MAIN_DB", 			'sky_');

/**************** 	Paths Definitions	 ******************/
define("DIRECTORY_CLASS",		"class/");
define("DIRECTORY_VIEWS", 		"views/");
define("DIRECTORY_BASE", 		"base/");
define("DIRECTORY_TEMPLATES",	"templates/");
define("DIRECTORY_AVATAR", 		"avatar/"); 
define("DIRECTORY_UPLOADS",		"uploads/"); 
define("DIRECTORY_FUNCS",		"funcs/");  
define("DIRECTORY_AJAX",		"ajax/"); 
define("DIRECTORY_IMAGES",		"img/"); 

/**************** 	Errors Definitions	 ****************/
$error_num = 0;
define("LOGIN_BADLOGIN",  		$error_num++);
define("LOGIN_DBFAILURE", 		$error_num++);

define("LOGIN_SUCCESS", 		$error_num++);


$error_num = 100;
define("ERR_DB_CONN",			$error_num++);
define("ERR_DB_EXEC",			$error_num++);
define("ERR_DB_QRY",			$error_num++);
define("ERR_DB_NOT_FOUND",		$error_num++);

$error_num = 200;
define("SES_RESTRICTED_ACTION", $error_num++);
define("SES_RESTRICTED_ACCESS", $error_num++);
define("SES_INVALID_ACTION", 	$error_num++);
define("SES_INVALID_ACCESS", 	$error_num++);

// Validation
$error_num = 300;
define("ERR_VAL_EMPTY",			$error_num++);
define("ERR_VAL_INVALID",		$error_num++);
define("ERR_VAL_NOT_UNIQUE",	$error_num++);
define("ERR_VAL_NOT_INT",		$error_num++);
define("ERR_VAL_NOT_DATE",		$error_num++);
define("ERR_VAL_NOT_EMAIL",		$error_num++); 

$error_num = 400;
define("ERR_FILE_INVALID",		$error_num++);
define("ERR_FILE_UPLOAD",		$error_num++);
define("ERR_FILE_PERMISSION",	$error_num++);
define("ERR_FILE_NOT_FOUND",	$error_num++);

$error_num = 400;
define("ERR_API_SESSION",		$error_num++);
define("ERR_API_INVALID",		$error_num++);
define("ERR_API_VALUE",			$error_num++);
define("ERR_API_NOT_FOUND",		$error_num++);

/************** 	Views Configuration 	****************/
$_command=1001;

/**************		LOGGING Definitions 	****************/
define('LOG_DIR', 'log/');
define('LOG_FILE', 'pa_log');
define('LOG_TMPLT', '[%s] %s @ %s: %s');
define('LOG_MAX_SIZE', '1073741824'); // 1G = 1073741824 bytes

define('LOG_PRC_DOWN',  1);
define('LOG_TRANS_ERR', 2);
define('LOG_DB_ERR',  	3);
define('LOG_SESS_ERR',  4);
define('LOG_INFO_ERR',  5);
define('LOG_API_ERR',   6);

define('COLOR1_DEFAULT', '#518351');
define('COLOR2_DEFAULT', '#fafafa');
define('COLOR3_DEFAULT', '#454545');

?>
