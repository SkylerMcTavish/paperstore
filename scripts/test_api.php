<?php
ini_set('display_errors', TRUE);
ini_set('default_socket_timeout', 3000); 
//$service_url = 'http://172.20.111.69:8880/prosa/api.php';
//$service_url = 'http://localhost:8888/Ragasa-Central/api.php'; 
$service_url = 'http://54.187.219.128/ragasa/sicmobile/api.php'; 
$curl = curl_init($service_url);
$user = 'tst.adm.pry@correo.com';
$user = 'amartinez@ragasa.com.mx';
$user = 'gramos@ragasa.com.mx';
switch($_GET['cual']){ 
	case 'set_order': 
		$detail = array(
					//	array( 'product_id' => 7,  'quantity' => 5, 'price' => 70.50 ),
					//	array( 'product_id' => 10, 'quantity' => 7, 'price' => 200.00 ),
						array( 'product_id' => 13, 'quantity' => 9, 'price' => 200.00 ) 
					);  
		$curl_post_data = array(
			"request"	=> 'set_order',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'], 
			'date_time' => date('Y-m-d H:i'),
			'pdv_id'	=> 2, 
			'products'	=> '[{"product_id":13,"quantity":1,"price":23.5}]' //$detail
		);
		break;
	case 'set_payment': 
		$curl_post_data = array(
			"request"	=> 'save_payment',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'], 
			'date' 		=> date('Y-m-d'),
			'pdv_id'	=> 2, 
			'method_id'	=> 1, 
			'total'		=> 2000.00 
		);
		break;
	case 'set_deposit': 
		
		$evidence = base64_encode( file_get_contents( "../img/logo.png" ) );
		$curl_post_data = array(
			"request"	=> 'set_deposit',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'], 
			'date' 		=> date('Y-m-d'),
			'number'	=> "217183030", 
			'total'		=> 2000.00 ,
			'evidence'	=> $evidence
		);
		break;
	case 'get_invoices':
		$curl_post_data = array(
			"request"	=> 'get_invoices',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'] 
		);
		break;
	case 'get_workplan':
		$curl_post_data = array(
			"request"	=> 'get_workplan',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'] 
		);
		break;
	case 'get_pdvs':
		$curl_post_data = array(
			"request"	=> 'get_pdvs',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'] 
		);
		break;
	case 'get_products':
		$curl_post_data = array(
			"request"	=> 'get_products',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'] 
		);
		break;
	case 'get_order':
		$curl_post_data = array(
			"request"	=> 'get_order',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'],
			"id_order"	=> ( isset($_GET['id_order'])  ) ? $_GET['id_order'] : 2
		);
		break;
	case 'get_pdv_info':
		$curl_post_data = array(
			"request"	=> 'get_pdv_info',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'],
			"pdv_id"	=> ( isset($_GET['id_pdv'])  ) ? $_GET['id_pdv'] : 2
		);
		break; 
	case 'start_visit':
		$curl_post_data = array(
			"request"	=> 'start_visit',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'],
			"visit_id"	=> ( isset($_GET['visit_id'])  ) ? $_GET['visit_id'] : 2,
			"date_time"	=> str_replace(" ", "T", date( 'Y-m-d H:i'))
		);
		break;
	case 'end_visit':
		$curl_post_data = array(
			"request"	=> 'end_visit',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'],
			"visit_id"	=> ( isset($_GET['visit_id'])  ) ? $_GET['visit_id'] : 2,
			"date_time"	=> str_replace(" ", "T", date( 'Y-m-d H:i'))
		);
		break;
	case 'states':
		$curl_post_data = array(
			"request"	=> 'get_states',
			"user" 		=> $user ,
			"token" 	=> $_GET['token']
		);
		break; 
	case 'cities':
		$curl_post_data = array(
			"request"	=> 'get_cities',
			"user" 		=> $user ,
			"token" 	=> $_GET['token']
		);
		break; 
	case 'set_prospect': 
		$curl_post_data = array(
			"request"	=> 'set_prospect',
			"user" 		=> $user ,
			"token" 	=> $_GET['token'],
			 
			'name' 			=> "name", 
			'lastname' 		=> "lastname", 
			'lastname2' 	=> "lastname2",
			'route'	 		=> "route",
			
			'rfc' 			=> "rfc",
			'phone'			=> "phone",
			'curp' 			=> "curp",
			'email' 		=> "email", 
			 
			'street' 		=> "street",	
			'ext_num' 		=> "ext_num", 
			'int_num' 		=> "int_num",
			'district' 		=> "district", 
			'locality' 		=> "locality", 
			'city' 			=> "city",
			'state' 		=> "state",
			
			'latitude' 		=> "latitude", 
			'longitude'		=> "longitude",
	   
			'id_channel' 	=> "1",  
			'id_division' 	=> "2"  
		   
		);
		break;
	case 'logout':
		$curl_post_data = array(
			"request"	=> 'logout',
			"user" 		=> $user ,
			"token" 	=> $_GET['token']
		);
		break; 
	default:
		$curl_post_data = array(
			"request"	=> 'login',
			"user" 		=> $user,
			"password" 	=> 'test'
		);
		break;
}

echo "<pre>";
echo "<b>Function: </b> " . $curl_post_data['request'] . "<p> </p>";
echo "<b>Parameters: </b> ";
	var_dump($curl_post_data ); 
echo  "<p>";
$curl_post_data = http_build_query($curl_post_data);
echo "<b>HttpQuery: </b> ";
	var_dump($curl_post_data); 
echo  "<p>";

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
$curl_response = curl_exec($curl);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
echo "<b>Code: </b> " . $code . "<p>"; 
echo "<b>Response: </b>" . $curl_response ;
echo "<p> <b> Response object: </b> <br>";
var_dump( json_decode( $curl_response ) );
echo "</pre>";

echo md5('gramos');
?> 