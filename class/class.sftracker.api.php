<?php
require_once 'class.api.php';

class SFTrackerApi extends api{
    
	public $error;
	private $detalles = array();
	private $id_proyect = 0;
	
    public function __construct($request, $origin) {
        parent::__construct($request);
		
		if ($this->request['request'] != 'login'){ 
			if ( array_key_exists('token', $this->request) && !$this->check_token() ){
				$this->set_error( 'Invalid User Token. ', LOG_SESS_ERR, 1 );
	            throw new Exception('Invalid User Token');
	        }
		}
    }
	
	/**
	 * login()
	 * 
	 * @return 		Array response
	 */
	protected function login(){ 
		if ($this->method == 'POST'){ 
	 		if (!array_key_exists('user', $this->request)) {
	 			$this->set_error(   'No User Provided.' , LOG_API_ERR, 1); 
	            throw new Exception('No User provided.');
	        } else if (!array_key_exists('password', $this->request)) {
	        	$this->set_error(   'No Password provided.', LOG_API_ERR, 1 ); 
	            throw new Exception('No Password provided.');
	        }
			 
			require_once 'class.login.php';
			$Login = new Login();
			
			$user	= $this->request['user'];
			$pwd	= $this->request['password'];
			
			$login = $Login->log_in($user, md5($pwd) ); 
			if ( $login != LOGIN_SUCCESS ){ 
				$this->set_error( "Invalid credentials.", LOG_SESS_ERR, 3); 
				return array('success' => FALSE, 'resp' => "Invalid credentials."); 
			} else { 
				$resp = $this->set_user_info($user);
				if ( $resp ){ 
					$token = $this->set_token();
					if ($token !== FALSE){
						return array('success' => TRUE, 'resp' => 'OK', 'token' => $token);
					} else {
						$this->set_error( "ERROR: An error occured while generating a Token.", LOG_SESS_ERR, 3); 
						return array('success' => FALSE, 'resp' => "ERROR: An error occured while generating a Token.");
				 	}
				} else {
					$this->set_error( "ERROR: Invalid user information.", LOG_SESS_ERR, 2); 
					return array('success' => FALSE, 'resp' => "ERROR: Invalid user information.");
				}
			}
	 	} else {
	 		$this->set_error( 'ERROR: Use POST to Login. ', LOG_API_ERR, 3 ); 
			return array('success' => FALSE, 'resp' =>"ERROR: Use POST to Login.");
        }
	}
	
	/**
	 * set_user_info()
	 * 
	 * @param 	$user string
	 */
	protected function set_user_info( $user ){ 
		if ( $user != '' ){ 
			global $obj_bd;
			$query = " SELECT * FROM " . PFX_MAIN_DB . "user "  
					. " WHERE us_user = :us_user " ; 
			$result = $obj_bd->query( $query, array( ":us_user" => $user ) ); 
		  	if ( $result ){
		 		$info = $result[0];
				$this->User = new stdClass;
				$this->User->id_user	= $info['id_user'];
				$this->User->user		= $info['us_user'];
				$this->User->email 		= $info['us_user'];
				$this->User->name 		= $info['us_user'];
				$this->User->route 		= $info['us_route'];
				$this->User->id_profile	= $info['us_pf_id_profile']; 
				
				$this->id_proyect 		= $info['pu_pr_id_proyect'];
				
				
				return TRUE;
			} else {
				$this->set_error( "ERROR: User not found. ", LOG_SESS_ERR, 2); 
				throw new Exception('ERROR: User not found.');
			} 
		} else {
			$this->set_error( "ERROR: Invalid user. ", LOG_SESS_ERR, 2); 
			throw new Exception('ERROR: Invalid user.');
		} 
	} 
	
	/**
	 * logout()
	 * 
	 * @return 	Array on success; FALSE otherwise
	 */
	protected function logout(){
		global $obj_bd; 
		$query = "UPDATE " . PFX_MAIN_DB . "token SET tk_timestamp = :timestamp "
							. " WHERE tk_us_id_user = :tk_user " ;
		$params = array( ':timestamp' => 0, ':tk_user' => $this->User->id_user );
		$resp = $obj_bd->execute($query,$params); 
		if ( !$resp ) {
			$this->set_error( "An error occured while updating the token. ", LOG_DB_ERR, 3 ) ;
			return array('success' => FALSE, 'resp' => 'Database Error while updating the token.'   );
		}
		else{  
			return array('success' => TRUE, 'resp' => 'OK' );
		} 
	}
	 
	/**
	* check_token
	* 
	* @return 	TRUE if token is valid; FALSE otherwise  
	*/
	protected function check_token(){
 		if (!array_key_exists('user', $this->request) && $this->request['user'] != '' ) {
 			$this->set_error('No User (user) Provided', LOG_API_ERR, 3);
            throw new Exception('No User (user) Provided');
        } else if (!array_key_exists('token', $this->request) && $this->request['token'] != '') {
            $this->set_error('No Token (token) provided.', LOG_API_ERR, 3);
            throw new Exception('No Token (token) provided.');
        } 
		$user 	= $this->request['user'];
		$token 	= $this->request['token'];
		
		global $obj_bd;
		$query  = " SELECT id_user, tk_token, tk_timestamp, us_user FROM " . PFX_MAIN_DB . "token " 
						. " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = tk_us_id_user " 
					. " WHERE us_user = :us_user AND tk_token = :token ";
		$result = $obj_bd->query( $query, array( ':us_user' => $user, ':token' => $token ) ); 
		if ( $result === FALSE ) {
			$this->set_error( 'An error occured while querying the DB for the token. ', LOG_DB_ERR, 3 );
			throw new Exception('Database error.');
		} 
		 
		if ( count( $result ) < 1 ) { 
			return FALSE;
		}  
		$record = $result[0]; 
		if ( !$record ){ 
			return FALSE;
		} 
		if ($record['tk_timestamp'] > 0 && $record['tk_timestamp'] > time() ){
			return $this->set_user_info( $record['us_user'] ); 
		} else { 
            throw new Exception('Session has expired.');
		}
	}

	protected function renew_token(){
		if ( $this->User->id_user > 0 ){
			global $obj_bd;
			$query = "UPDATE " . PFX_MAIN_DB . "token SET tk_timestamp = :timestamp "
							. " WHERE tk_us_id_user = :us_user " ;
			$params = array( 
							':timestamp' => ( time() + (86400 * 20) ), 
							':us_user' => $this->User->id_user 
						);
			
			if ( $result = $obj_bd->execute( $query, $params ) ) {
				$this->set_error("An error occured while saving the token. ", LOG_DB_ERR, 3  );
				return FALSE;
			}
			else{  
				return TRUE; 
			}
		} 
	}
	 
	protected function set_token(){ 
		if ($this->User->user != ''){
			global $obj_bd;
			$token = md5( 	"SF·Tracker#" .
							$this->User->id_user . "#" . 
							$this->User->user . "#" . 
							$this->User->name . "#" .
							date('YmdHis') 
					);
			$query  = "SELECT * FROM " . PFX_MAIN_DB . "token " 
						. " WHERE tk_us_id_user = :id_user ";
			$params = array( ':id_user' => $this->User->id_user );
			 
			$result = $obj_bd->query( $query, $params );
			if ( $result === FALSE ){  
				$this->set_error( 'An error occured while querying the DB for the token. ', LOG_DB_ERR, 3 ); 
				throw new Exception('Database Error.');
			}  
			if (count($result) < 1 ) { 
				$query = "INSERT INTO " . PFX_MAIN_DB . "token ( tk_us_id_user, tk_token, tk_timestamp ) VALUES ( :tk_user, :tk_token, :tk_timestamp) ";
			} else {
				$query = "UPDATE " . PFX_MAIN_DB . "token SET tk_token = :tk_token, tk_timestamp = :tk_timestamp WHERE tk_us_id_user = :tk_user " ; 
			}
			  
			$params = array( ':tk_user' => $this->User->id_user, ':tk_token' => $token, ':tk_timestamp' => (time() + (86400 * 20) ) ); 
			$result = $obj_bd->execute( $query, $params );
			if ( !$result ) { 
				$this->set_error("An error occured while saving the token. " , LOG_DB_ERR, 3  );
				return FALSE;
			}
			else{  
				return $token;
			}
		} else {
			$this->set_error('Session error: user not logged in.', LOG_SESS_ERR, 3);
			throw new Exception('Session error: user not logged in.');
		}
	}
	
	/* PDV */
	protected function get_pdvs(){
		if (  $this->User->id_user > 0 ){
			if (!array_key_exists('pdv_id', $this->request) && is_numeric( $this->request['pdv_id'] ) && $this->request['pdv_id'] > 0 ) {
	 			$this->set_error('Invalid PDV ID', LOG_API_ERR, 2);
	            throw new Exception('Invalid PDV ID');
	        } 
			global $obj_bd;
			$id_pdv = $this->request['pdv_id']; 
			$query = "SELECT "
					. " id_pdv as pdv_id, " 
					. " pdv_jde, " 
					. " pdv_name, " 
					. " pdv_latitude, " 
					. " pdv_longitude, "
					. " CONCAT( ad_street, ' ', ad_ext_num, ' ', ad_int_num, ', ', ad_district, ', ', "
					. " ad_locality, ', ', ad_zipcode, ', ', IFNULL(ct_city, ''), ', ', st_state) AS pdv_address, " 
					. " pvc_phone_1 as pdv_phone_number " 
				. " FROM " . PFX_MAIN_DB . "pdv " 
					. " INNER JOIN " . PFX_MAIN_DB . "visit ON vi_pdv_id_pdv = id_pdv AND vi_us_id_user = :id_user "
														. " AND vi_scheduled_start >= :start AND vi_scheduled_start <= :end " 
					. " INNER JOIN " . PFX_MAIN_DB . "pdv_contact ON pvc_pdv_id_pdv = id_pdv "
					. " LEFT JOIN " . PFX_MAIN_DB . "address ON pdv_ad_id_address = id_address  "
					. " LEFT JOIN " . PFX_MAIN_DB . "state ON ad_st_id_state = id_state "
					. " LEFT JOIN " . PFX_MAIN_DB . "city ON ad_city = ct_code " ; 
					  
			$start = mktime( 0, 0, 0,date('m'),date('d'),date('Y'));
			$end   = mktime(23,59,59,date('m'),date('d'),date('Y'));
			$pdv = $obj_bd->query($query, array( ':id_user' => $this->User->id_user, ':start' => $start, ':end' => $end ));
			  
			if ( $pdv !== FALSE ){ 
				return array('success' =>  TRUE,  'resp' => "OK", 'pdvs' => $pdv ); 
			} else {
				throw new Exception('An error occurred while querying for PDVs.');
			}
		} else {
			throw new Exception('Invalid session info.' );
		} 
	}
	
	protected function get_pdv_info(){
		if (  $this->User->id_user > 0 ){
			if (!array_key_exists('pdv_id', $this->request) && is_numeric( $this->request['pdv_id'] ) && $this->request['pdv_id'] > 0 ) {
	 			$this->set_error('Invalid PDV ID', LOG_API_ERR, 2);
	            throw new Exception('Invalid PDV ID');
	        } 
			global $obj_bd;
			$id_pdv = $this->request['pdv_id']; 
			$query = "SELECT "
					. " id_pdv as pdv_id, " 
					. " pdv_jde, " 
					. " pdv_name, " 
					. " pdv_latitude, " 
					. " pdv_longitude, "
					. " CONCAT( ad_street, ' ', ad_ext_num, ' ', ad_int_num, ', ', ad_locality, ', ', "
					. " ad_locality, ', ', ad_zipcode, ', ', IFNULL(ct_city, ''), ', ', st_state) AS pdv_address, " 
					. " pvc_phone_1 as pdv_phone_number " 
				. " FROM " . PFX_MAIN_DB . "pdv " 
					. " INNER JOIN " . PFX_MAIN_DB . "pdv_contact ON pvc_pdv_id_pdv = id_pdv "
					. " LEFT JOIN " . PFX_MAIN_DB . "address ON pdv_ad_id_address = id_address  "
					. " LEFT JOIN " . PFX_MAIN_DB . "state ON ad_st_id_state = id_state "
					. " LEFT JOIN " . PFX_MAIN_DB . "city ON ad_city = ct_code "
				. " WHERE id_pdv = :id_pdv "; 
			$pdv = $obj_bd->query( $query, array( ':id_pdv' => $id_pdv ) );
			if ( $pdv !== FALSE ){ 
				return array('success' =>  TRUE,  'resp' => "OK", 'pdv' => $pdv ); 
			} else {
				throw new Exception('An error occurred while querying for PDV.');
			}
		} else {
			throw new Exception('Invalid session info.' );
		} 
	}
	 
	/* PRODUCTS */ 
	protected function get_products(){
		if (  $this->User->id_user > 0 ){ 
			global $obj_bd; 
			$query = "SELECT "
					. " id_product as prod_id, " 
					. " pd_jde as prod_jde, " 
					. " pd_sku as prod_sku, " 
					. " id_brand, ba_brand as brand, " 
					. " pd_product as prod_name, " 
					. " pd_description as prod_description, " 
					. " pri_price as prod_price,  "
					. " 0.15 as prod_tax " 
				. " FROM " . PFX_MAIN_DB . "product " 
					. " INNER JOIN " . PFX_MAIN_DB . "price ON pri_pd_id_product = id_product AND pri_pp_id_product_presentation = 1 "
					. " INNER JOIN " . PFX_MAIN_DB . "brand ON pd_ba_id_brand = id_brand "
				. " WHERE pd_status = 1 "; 
			$products = $obj_bd->query( $query );
			if ( $products !== FALSE ){ 
				return array('success' =>  TRUE,  'resp' => "OK", 'products' => $products ); 
			} else {
				throw new Exception('An error occurred while querying for products.');
			}
		} else {
			throw new Exception('Invalid session info.' );
		}  
	} 

	/* ORDERS  */
	protected function send_order(){
		return $this->set_order();
	}
	
	protected function set_order(){
		if (  $this->User->id_user > 0 ){ 
			if (!(array_key_exists('date_time', $this->request) && $this->request['date_time'] != "") ) {
	 			$this->set_error('Invalid Date', LOG_API_ERR, 2);
	            throw new Exception('Invalid Date');
	        }
			if (! (array_key_exists('pdv_id', $this->request ) && is_numeric( $this->request['pdv_id'] ) && $this->request['pdv_id'] > 0) ) {
	 			$this->set_error('Invalid PDV ID', LOG_API_ERR, 2);
	            throw new Exception('Invalid PDV ID');
	        } 
			if (!(array_key_exists('products', $this->request ) && is_array( $this->request['products'] ) && count($this->request['products']) > 0) ) {
				
				if ( trim($this->request['products']) == '' ){
		 			$this->set_error('Invalid Order Detail Info', LOG_API_ERR, 2);
		            throw new Exception('Invalid Order Detail Info ' ); 
				} else {
					try {
						$products = json_decode(   stripslashes($this->request['products']) , TRUE );
					} catch ( Exception $e){
			 			$this->set_error('Invalid Order Detail Info', LOG_API_ERR, 2);
			            throw new Exception('Invalid Order Detail Info: ' ); 
					}
					
				} 
	        } else $products = $this->request['products'] ;
			  
		 	if ( !class_exists('AdminOrder') ){
				require_once 'class.admin.order.php';
			} 
			
			$Order = new AdminOrder( 0 ); 
			$Order->id_pdv		= $this->request['pdv_id'];
			$Order->id_user 	= $this->User->id_user;
			$Order->id_visit 	= $this->request['visit_id'] > 0 ? $this->request['visit_id'] : NULL ; 
			$Order->folio 		= $this->request['folio'] ? $this->request['folio']: "" ;
			$Order->id_order_status = 1;
			
			$date_time	= $this->request['date_time'];
			list( $date, $time ) = explode( ' ', $date_time ); 
			$Order->date =  $this->get_date_timestamp( $date, $time ); 
			
			foreach ( $products as $key => $det) {
				$detail = new stdClass;  
				if (!array_key_exists('product_id', $det) && is_numeric( $det['product_id'] ) && $det['product_id'] > 0 ) {
		 			$this->set_error('Invalid Product ID detail line ' . $key . '.', LOG_API_ERR, 2);
		            throw new Exception('Invalid Product ID detail line ' . $key . '.');
				} 
				/*if (!array_key_exists('id_product_presentation', $det) && is_numeric( $det['id_product_presentation'] ) && $det['id_product_presentation'] > 0 ) {
		 			$this->set_error('Invalid Product Presentation ID detail line ' . $key . '.', LOG_API_ERR, 2);
		            throw new Exception('Invalid Product Presentation ID detail line ' . $key . '.');
				}*/
				if (!array_key_exists('quantity', $det) && is_numeric( $det['quantity'] ) && $det['quantity'] > 0 ) {
		 			$this->set_error('Invalid Product ID detail line ' . $key . '.', LOG_API_ERR, 2);
		            throw new Exception('Invalid Product ID detail line ' . $key . '.');
				} 
				if (!array_key_exists('price', $det) && is_numeric( $det['price'] ) && $det['price'] > 0 ) {
		 			$this->set_error('Invalid Product Presentation ID detail line ' . $key . '.', LOG_API_ERR, 2);
		            throw new Exception('Invalid Product Presentation ID detail line ' . $key . '.');
				}
				$detail->id_product		 = $det['product_id'];
				$detail->id_product_presentation =( $det['id_product_presentation'] > 1 ) ? $det['id_product_presentation'] : 1;  
				$detail->quantity		 = $det['quantity'];
				$detail->price			 = $det['price']; 
				
				$Order->detail[] = $detail;
			}
//throw new Exception('Info: ' . print_r($Order, TRUE) );
			$result = $Order->save(); 
			if ( $result !== FALSE ) {
				return array('success' =>  TRUE,  'resp' => "OK", "order_id" => $Order->id_order );
			} else {
				throw new Exception( 'An error occured while trying to save the record.' );
			} 
		} else {
			throw new Exception( 'Invalid session info.' );
		} 
	}
	
	protected function get_order(){
		if (  $this->User->id_user > 0 ){
			if (!array_key_exists('order_id', $this->request) && is_numeric( $this->request['order_id'] ) && $this->request['order_id'] > 0 ) {
	 			$this->set_error('Invalid Order ID', LOG_API_ERR, 2);
	            throw new Exception('Invalid Order ID');
	        } 
			global $obj_bd;
			$id_order = $this->request['order_id'];
			if ( !class_exists('Order') ){
				require_once 'class.order.php';
			}
			$order = new Order( $id_order );
			if ( count( $order->error ) > 0 ){
				return array('success' => FALSE, 'error' => $order->error[count( $order->error )-1] );
			} else {
				return array('success' =>  TRUE,  'resp' => "OK", 'order' => $order->get_array() );
			} 
		} else {
			throw new Exception('Invalid session info.' );
		}
	}
	
	/** Invoice **/
	protected function get_invoice_info()
	{
		if (!array_key_exists('invoice_id', $this->request) && is_numeric( $this->request['invoice_id'] ) && $this->request['invoice_id'] > 0 )
		{
			$this->set_error('Invalid Invoice ID', LOG_API_ERR, 2);
			throw new Exception('Invalid Invoice ID');
		}
		global $obj_bd;
		$id_invoice = $this->request['invoice_id'];
		
		$query 	= 	" SELECT id_invoice AS invoice_id, in_date, in_pdv_id_pdv AS pdv_id, in_folio, in_total, in_status ".
					" FROM " . PFX_MAIN_DB . "invoice ".
					" WHERE id_invoice = :id_invoice ";
		
		$info = $obj_bd->query( $query, array( ':id_invoice' => $id_invoice ) );
		
		if ( $info !== FALSE )
		{ 
			return array('success' =>  TRUE,  'resp' => "OK", 'info' => $info ); 
		}
		else
		{
			throw new Exception('An error occurred while querying for Invoices.');
		}
	}
	
	protected function get_invoices()
	{
		if (  $this->User->id_user > 0 )
		{
			 
			global $obj_bd;
			$id_pdv = $this->request['pdv_id'];
			
			$values = array(  ':id_user' => $this->User->id_user );
			
			$query 	= 	" SELECT id_pdv AS pdv_id, pdv_name, id_invoice AS invoice_id, in_folio AS folio, FROM_UNIXTIME(in_date) AS date, in_total  ".
						" FROM " . PFX_MAIN_DB . "invoice ".
							" INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = in_pdv_id_pdv ".
							" INNER JOIN " . PFX_MAIN_DB . "visit ON vi_pdv_id_pdv = in_pdv_id_pdv AND vi_us_id_user = :id_user ".
						" WHERE in_status = 1 AND id_invoice NOT IN ( SELECT py_in_id_invoice FROM " . PFX_MAIN_DB . "payment WHERE py_in_id_invoice > 0 ) ";
						
			if($id_pdv > 0)
			{
				$values[':id_pdv'] = $id_pdv;
				$query .= " AND id_pdv = :id_pdv ";
			}
			
			$invoice = $obj_bd->query( $query, $values );
			
			if ( $invoice !== FALSE )
			{ 
				return array('success' =>  TRUE,  'resp' => "OK", 'invoices' => $invoice ); 
			}
			else
			{
				throw new Exception('An error occurred while querying for Invoices.');
			}
		}
		else
		{
			throw new Exception('Invalid session info.' );
		}
	}
	
	/** Payment **/
	protected function send_payment(){
		return $this->save_payment();
	}
	
	protected function save_payment(){
		if (  $this->User->id_user > 0 ){ 
			if (!(array_key_exists('date', $this->request) && $this->request['date'] != "") ) {
	 			$this->set_error('Invalid Date', LOG_API_ERR, 2);
	            throw new Exception('Invalid Date');
	        }
			if (!(array_key_exists('pdv_id', $this->request ) && is_numeric( $this->request['pdv_id'] ) && $this->request['pdv_id'] > 0) ) {
	 			$this->set_error('Invalid PDV ID', LOG_API_ERR, 2);
	            throw new Exception('Invalid PDV ID');
	        } 
			if (!(array_key_exists('method_id', $this->request ) && is_numeric( $this->request['method_id'] ) && $this->request['method_id'] > 0) ) {
	 			$this->set_error('Invalid Payment Method.', LOG_API_ERR, 2);
	            throw new Exception('Invalid Payment Method.');
	        } 
			if (!(array_key_exists('total', $this->request ) && is_numeric( $this->request['total'] ) && $this->request['total'] > 0) ) {
	 			$this->set_error('Invalid Total.', LOG_API_ERR, 2);
	            throw new Exception('Invalid Total.');
	        }
			
			$payment = new stdClass; 
			$payment->id_pdv	= $this->request['pdv_id'];
			$payment->id_user 	= $this->User->id_user;
			$payment->id_visit 	= $this->request['visit_id'] > 0 ? $this->request['visit_id'] : NULL ;
			$payment->id_invoice= $this->request['invoice_id'] > 0 ? $this->request['invoice_id'] : NULL ;
			$payment->folio 	= $this->request['folio'] ? $this->request['folio']: "" ;
			$payment->date 		= $this->get_date_timestamp( $this->request['date'], date( "H:i:s" ));
			$payment->total 	= $this->request['total'];
			$payment->id_method = $this->request['method_id'];
			
			global $obj_bd;
			$query = "INSERT INTO " . PFX_MAIN_DB . "payment (py_pdv_id_pdv, py_us_id_user, py_date_payment, py_date, py_in_id_invoice, py_pm_id_payment_method, py_total, py_status, py_timestamp) "
						. " VALUES (:id_pdv, :id_user, :date, :date, :id_invoice, :id_method, :total, 1, :timestamp) "; 
			$params = array(
							':id_pdv' 		=> $payment->id_pdv, 
							':id_user' 		=> $payment->id_user, 
							':date' 		=> $payment->date, 
							':id_invoice' 	=> $payment->id_invoice, 
							':id_method' 	=> $payment->id_method, 
							':total' 		=> $payment->total, 
							':timestamp' 	=> time()  
						);
			
			$result = $obj_bd->execute($query , $params); 
			if ( $result !== FALSE ) {
				return array('success' =>  TRUE,  'resp' => "OK", "payment_id" => $obj_bd->get_last_id());
			} else {
				$this->set_error('Database Error while trying to save the payment.' , LOG_API_ERR, 2);
            	throw new Exception('Database Error while trying to save the payment.');
			} 
		} else {
			throw new Exception( 'Invalid session info.' );
		} 
	}

	/* DEPOSIT */
	protected function send_partial_settlement(){
		return $this->set_deposit();
	}
	
	protected function set_deposit(){
		if (  $this->User->id_user > 0 ){ 
			if (!(array_key_exists('date', $this->request) && $this->request['date'] != "") ) {
	 			$this->set_error('Invalid Date', LOG_API_ERR, 2);
	            throw new Exception('Invalid Date');
	        }
			if (!(array_key_exists('number', $this->request ) && $this->request['number'] != '') ) {
	 			$this->set_error('Invalid Folio (number)', LOG_API_ERR, 2);
	            throw new Exception('Invalid Folio (Number)');
	        }  
			if (!(array_key_exists('total', $this->request ) && is_numeric( $this->request['total'] ) && $this->request['total'] > 0) ) {
	 			$this->set_error('Invalid Payment Method.', LOG_API_ERR, 2);
	            throw new Exception('Invalid Payment Method.');
	        }
			if (!(array_key_exists('evidence', $this->request ) && $this->request['evidence'] != '') ) {
	 			$this->set_error('Invalid Evidence', LOG_API_ERR, 2);
	            throw new Exception('Invalid Evidence');
	        }  
			
			$deposit = new stdClass;  
			$deposit->id_user 	= $this->User->id_user;
			$deposit->date 		= $this->get_date_timestamp( $this->request['date'], date( "H:i:s" )); 
			$deposit->folio 	= $this->request['number'] ? $this->request['number']: "" ;
			$deposit->total 	= $this->request['total'];
			
			if ( !class_exists('FileManager') ){
				require_once 'class.file.manager.php';
			}
			$fmanager = new FileManager( );
			
			$deposit->id_evidence = $fmanager->save_evidence($this->request['evidence'] , "deposit_" . $deposit->folio . "_" . date('YmdHis') , 2);
			
			if ( $deposit->id_evidence !== FALSE ){
				global $obj_bd;
				$query = "INSERT INTO " . PFX_MAIN_DB . "deposit (dp_us_id_user, dp_folio, dp_date, dp_total, dp_status, dp_timestamp, dp_ev_id_evidence) "
							. " VALUES (:id_user, :folio, :date, :total, 1, :timestamp, :id_evidence) "; 
				$params = array( 
								':id_user' 		=> $deposit->id_user, 
								':date' 		=> $deposit->date, 
								':folio'	 	=> $deposit->folio, 
								':id_evidence' 	=> $deposit->id_evidence, 
								':total' 		=> $deposit->total, 
								':timestamp' 	=> time()  
							);
				
				$result = $obj_bd->execute($query , $params); 
				if ( $result !== FALSE ) {
					return array('success' =>  TRUE,  'resp' => "OK", "deposit_id" => $obj_bd->get_last_id());
				} else {
					$this->set_error('Database Error while trying to save deposit.', LOG_API_ERR, 2);
	            	throw new Exception('Database Error while trying to save deposit.' ); 
				} 
				
			} else {
				$this->set_error('Error saving evidence.', LOG_API_ERR, 2);
	            throw new Exception('Error saving evidence.');
			}
			
		} else {
			throw new Exception( 'Invalid session info.' );
		} 
	}
	
	/* PROSPECT */ 
	protected function set_prospect(){
		if (  $this->User->id_user > 0 ){ 
			if (!(array_key_exists('name', $this->request) && $this->request['name'] != "") ) {
	 			$this->set_error('Invalid Name', LOG_API_ERR, 2);
	            throw new Exception('Invalid Name');
	        }
			if (!(array_key_exists('rfc', $this->request ) && $this->request['rfc'] != "") ) {
	 			$this->set_error('Invalid RFC', LOG_API_ERR, 2);
	            throw new Exception('Invalid RFC');
	        }
			if ( !class_exists('Prospect') ){ 
				require_once "class.prospect.php"; 
			} 
			
			$pro = new Prospect( 0 );
			$pro->name			= $this->request['name']; 
			$pro->lastname		= $this->request['lastname']; 
			$pro->lastname2		= $this->request['lastname2'];
			$pro->route			= $this->request['route'];
			$pro->latitude		= $this->request['latitude']; 
			$pro->longitude		= $this->request['longitude']; 
			  
			$pro->channel		= $this->request['ch_channel'];   
			$pro->division		= $this->request['dv_division'];
			   
			$pro->rfc			= $this->request['rfc'];
			$pro->phone			= $this->request['phone'];
			$pro->curp			= $this->request['curp'];
			$pro->email			= $this->request['email'];  
			 
			$pro->street		= $this->request['street']; 
			$pro->ext_num		= $this->request['ext_num']; 
			$pro->int_num		= $this->request['int_num']; 
			$pro->district		= $this->request['district']; 
			$pro->locality		= $this->request['locality']; 
			$pro->city			= $this->request['city']; 
			$pro->state			= $this->request['state'];
			 
			$pro->id_user		= $this->User->id_user;
			$pro->route			= $this->User->route; 
			 
			$result = $pro->save(); 
			if ( $result !== FALSE ) {
				return array('success' =>  TRUE,  'resp' => "OK", "prospect_id" => $pro->id_prospect);
			} else {
				$this->set_error('Database Error while trying to save the prospect.' , LOG_API_ERR, 2);
            	throw new Exception('Database Error while trying to save the prospect.');
			} 
		} else {
			throw new Exception( 'Invalid session info.' );
		} 
	}
	
	
	/* VISITS */
	protected function validate_visit( $id_visit ){ 
		if ( is_numeric( $id_visit ) && $id_visit > 0 ){
			global $obj_bd; 
			if ( $this->User->id_profile == 4 ){
				$query = " SELECT id_visit FROM " . PFX_MAIN_DB . "visit " 
					. " WHERE vi_status = 1 AND id_visit = :id_visit AND vi_us_id_user IN ( SELECT usu_us_id_user FROM " . PFX_MAIN_DB . "user_supervisor WHERE usu_us_id_parent = :id_user ) ";
			} else {
				$query = " SELECT id_visit FROM " . PFX_MAIN_DB . "visit " 
					. " WHERE vi_status = 1 AND id_visit = :id_visit AND vi_us_id_user = :id_user ";
			} 
			$valid = $obj_bd->query( $query, array( ':id_visit' => $id_visit , ':id_user' => $this->User->id_user ) );
			if ( $valid !== FALSE ){
				if ( $valid[0]['id_visit'] == $id_visit )
					return TRUE;
				else
					return FALSE;
			} 
			else return FALSE;
		} 
		else return FALSE;
	}
	
	protected function get_visit_info(){
		if (  $this->User->id_user > 0 ){
			if (!array_key_exists('id_visit', $this->request) && is_numeric( $this->request['id_visit'] ) && $this->request['id_visit'] > 0 ) {
	 			$this->set_error('Invalid Visit ID', LOG_API_ERR, 2);
	            throw new Exception('Invalid Visit ID');
	        }  
			$id_visit = $this->request['id_visit'];
			$valid = $this->validate_visit($id_visit);
			if ( $valid !== FALSE ){ 
				if ( !class_exists('Visit') ){
					require_once 'class.visit.php';
				}
				$visit = new Visit( $id_visit );
				if ( count( $visit->error ) > 0 ){
					return array('success' => FALSE, 'error' => $visit->error[count( $visit->error )-1] );
				} else {
					return array('success' =>  TRUE,  'resp' => "OK", 'visit' => $visit->get_array() );
				}
			} else {
				throw new Exception('Invalid Visit.');
			}
		} else {
			throw new Exception('Invalid session info.' );
		} 
	}
	
	protected function send_start_visit(){
		return $this->start_visit();
	}
	
	protected function send_end_visit(){
		return $this->end_visit();
	}
	
	protected function start_visit(){
		if (  $this->User->id_user > 0 ){
			
			if (!array_key_exists('visit_id', $this->request) && is_numeric( $this->request['visit_id'] ) && $this->request['visit_id'] > 0 ) {
	 			$this->set_error('Invalid Visit ID', LOG_API_ERR, 2);
	            throw new Exception('Invalid Visit ID');
	        }  
			if (!array_key_exists('date_time', $this->request) && $this->request['date_time'] != "" ) {
	 			$this->set_error('Invalid Date', LOG_API_ERR, 2);
	            throw new Exception('Invalid Date');
	        }
			
			$id_visit 	= $this->request['visit_id'];
			$date_time	= $this->request['date_time'];
			list( $date, $time ) = explode( ' ', $date_time ); 
			$timestamp 	= $this->get_date_timestamp( $date, $time ); 
			
			$valid = $this->validate_visit( $id_visit );
			if ( $valid !== FALSE ){ 
				if ( !class_exists('VisitActivities') ){
					require_once 'class.visit.activities.php';
				} 
				$visit = new VisitActivities( $id_visit );
				$result = $visit->start_visit( $timestamp );
				if ( $result !== FALSE ) {
					return array('success' =>  TRUE,  'resp' => "OK" );
				} else {
					$this->error[] = array_merge( $this->error, $visit->error );
					return array('success' =>  FALSE, 'error' => $visit->error[ count( $visit->error ) - 1] );
				}
			} else {
				throw new Exception('Invalid Visit.');
			}
		} else {
			throw new Exception( 'Invalid session info.' );
		} 
	}
	
	protected function end_visit(){
		if (  $this->User->id_user > 0 ){
			
			if (!array_key_exists('visit_id', $this->request) && is_numeric( $this->request['visit_id'] ) && $this->request['visit_id'] > 0 ) {
	 			$this->set_error('Invalid Visit ID', LOG_API_ERR, 2);
	            throw new Exception('Invalid Visit ID');
	        }  
			if (!array_key_exists('date_time', $this->request) && $this->request['date_time'] != "" ) {
	 			$this->set_error('Invalid Date', LOG_API_ERR, 2);
	            throw new Exception('Invalid Date');
	        }
			
			$id_visit 	= $this->request['visit_id'];
			$date_time	= $this->request['date_time'];
			list( $date, $time ) = explode( ' ', $date_time ); 
			$timestamp 	= $this->get_date_timestamp( $date, $time ); 
			
			$valid = $this->validate_visit( $id_visit );
			if ( $valid !== FALSE ){ 
				if ( !class_exists('VisitActivities') ){
					require_once 'class.visit.activities.php';
				}
				
				$visit = new VisitActivities( $id_visit );
				$result = $visit->end_visit( $timestamp );
				if ( $result !== FALSE ) {
					return array('success' =>  TRUE,  'resp' => "OK" );
				} else {
					$this->error[] = array_merge( $this->error, $visit->error );
					return array('success' =>  FALSE, 'error' => $visit->error[ count( $visit->error ) - 1] );
				}
			} else {
				throw new Exception('Invalid Visit.');
			}
		} else {
			throw new Exception( 'Invalid session info.' );
		}
	} 
	
	protected function start_day(){
		
	}
	
	protected function end_day(){
		
	}
	
	protected function get_workplan(){
		if (  $this->User->id_user > 0 ){ 
			global $obj_bd; 
			$query = "SELECT id_visit FROM " . PFX_MAIN_DB . "visit " 
					. " WHERE vi_us_id_user = :id_user " 
						. " AND vi_scheduled_start >= :start AND vi_scheduled_start <= :end " ;
			$start = mktime( 0, 0, 0,date('m'),date('d'),date('Y'));
			$end   = mktime(23,59,59,date('m'),date('d'),date('Y'));
			$workplan = $obj_bd->query($query, array( ':id_user' => $this->User->id_user, ':start' => $start, ':end' => $end )); 
			if ( $workplan !== FALSE ){
				$visits = array();
				$errors = array();
				if ( !class_exists('Visit') ){
					require_once 'class.visit.php';
				} 
				foreach ( $workplan as $k => $vi ){
					$visit = new Visit( $vi['id_visit'] );
					if ( count( $visit->error ) > 0 ){
						$errors[] = $visit->error[count( $visit->error )-1];
					} else {
						$visits[] = $visit->get_array_api();
					} 
				} 
				$resp = array('success' =>  TRUE,  'resp' => "OK", 'date' => date('Y-m-d'), 'workplan' => $visits );
				if ( count( $errors ) > 0 )
					$resp['error'] = $errors;
				return $resp;
			} else {
				throw new Exception('An error occurred while querying for workplan.');
			}
		} else {
			throw new Exception('Invalid session info.' );
		}  
	}


	/* CATALOGUES */
	protected function get_cities(){
		if (  $this->User->id_user > 0 ){ 
			global $obj_bd; 
			$query = "SELECT * FROM " . PFX_MAIN_DB . "city "  ; 
                        
                        if(isset($this->request['code']) && $this->request['code'] != '')
                        {
                            $query .= " WHERE   ct_st_st_code='".$this->request['code']."' ";
                        }
                        
                        
			$cities = $obj_bd->query($query ); 
			if ( $cities !== FALSE ){ 
				return array('success' =>  TRUE,  'resp' => "OK", 'cities' => $cities ); 
			} else {
				throw new Exception('An error occurred while querying for states.');
			}
		} else {
			throw new Exception('Invalid session info.' );
		}  
	}
	
	protected function get_states(){
		if (  $this->User->id_user > 0 ){ 
			global $obj_bd; 
			$query = "SELECT * FROM " . PFX_MAIN_DB . "state "  ; 
			$states = $obj_bd->query($query ); 
			if ( $states !== FALSE ){ 
				return array('success' =>  TRUE,  'resp' => "OK", 'states' => $states ); 
			} else {
				throw new Exception('An error occurred while querying for states.');
			}
		} else {
			throw new Exception('Invalid session info.' );
		}  
	}

	protected function get_payment_method(){
		if (  $this->User->id_user > 0 ){ 
			global $obj_bd; 
			$query = "SELECT * FROM " . PFX_MAIN_DB . "payment_method "  ; 
			$pms = $obj_bd->query( $query ); 
			if ( $states !== FALSE ){ 
				return array('success' =>  TRUE,  'resp' => "OK", 'payment_methods' => $pms ); 
			} else {
				throw new Exception('An error occurred while querying for payment_methods.');
			}
		} else {
			throw new Exception('Invalid session info.' );
		}  
	}
	
	protected function get_date_timestamp( $date, $time ){
		try {
			list ($Y, $m, $d ) = explode('-', $date);
			list ($H, $i, $s ) = explode(':', $time); 
			return mktime( $H, $i, ($s > 0 ? $s : 0), $m, $d, $Y );
		} catch ( Exception $e ) {
			$this->set_error("Invalid Date, Time values. ", ERR);
		}
	}
	
        protected function set_stock()
        {
            if($this->User->id_user > 0)
            {                
                if(!(array_key_exists('id_visit', $this->request) && is_numeric($this->request['id_visit']) && $this->request['id_visit'] > 0))
                {
                    $this->set_error("Invalid Visit ID", LOG_API_ERR,2);
                    throw new Exception("Invalid Visit ID");
                }
                
                if(!(array_key_exists('id_product', $this->request)  && is_numeric($this->request['id_product']) && $this->request['id_product']  > 0))
                {
                    $this->set_error('Invalid Product ID', LOG_API_ERR, 2);
                    throw new Exception('Invalid Product ID');
                }
                
                if(!(array_key_exists('current', $this->request) && $this->request['current'] != ""))
                {
                    $this->set_error("Invalid Current", LOG_API_ERR, 2);
                    throw new Exception("Invalid Current");
                }
                
                if(!(array_key_exists('shelf', $this->request) && $this->request['shelf'] != ""))
                {
                    $this->set_error("Invalid Shelf", LOG_API_ERR, 2);
                    throw new Exception("Invalid Shelf");
                }
                
                if(!(array_key_exists('exhibition', $this->request) && $this->request['exhibition'] != ""))
                {
                    $this->set_error("Invalid Exhibition", LOG_API_ERR, 2);
                    throw new Exception("Invalid Exhibition");
                }
                
                if(!(array_key_exists('price', $this->request) && is_numeric($this->request['price']) && $this->request['price']  > 0))
                {
                    $this->set_error("Invalid Price", LOG_API_ERR, 2);
                    throw new Exception("Invalid Price");
                }
                
                if ( !class_exists('Stock') )
                { 
                    require_once "class.stock.php"; 
		} 
                
                $_stock = new Stock();
                
                $_stock->s_id_visit = $this->request['id_visit'];
                $_stock->s_id_product = $this->request['id_product'];
                $_stock->s_actual = $this->request['current'];
                $_stock->s_anaquel = $this->request['shelf'];
                $_stock->s_exhibicion = $this->request['exhibition'];
                $_stock->s_precio = $this->request['price'];
                
                $result= $_stock->save();
                
                if($result !== FALSE)
                {
                    return array('success' =>  TRUE,  'resp' => "OK");
                }
                else
                {
                    $this->set_error('Database Error while trying to save the stock.' , LOG_API_ERR, 2);
                    throw new Exception('Database Error while trying to save the stock.');
                }
                    
            }
            else
            {
                throw new Exception("Invalid session info");
            }
        }
        
        
}

?>