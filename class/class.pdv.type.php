<?php
/**
* PDV Type CLass
* 
* @package		Ragasa
* @since        6/2/2015
* @author		ignacio.cerda
* 
*/ 
class PDVType extends Object {
	 
	public $id_pdv_type;
	public $pdv_type;
	
	public $task_types = array();
	
	public $timestamp;
	
	function __construct( $id_pdv_type = 0 )
	{
		global $obj_bd;
		$this->class = 'PDVType';
		$this->error = array();
		$this->clean();
		
		if ( $id_pdv_type > 0 )
		{
			$query = 	" SELECT id_pdv_type, pvt_pdv_type, pvt_timestamp ".
						" FROM " . PFX_MAIN_DB . "pdv_type ".
						" WHERE id_pdv_type = :id_pvt ";
					
			$info = $obj_bd->query( $query, array( ':id_pvt' => $id_pdv_type ) );
			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$pvt = $info[0];
					$this->id_pdv_type 	= $pvt['id_pdv_type'];
					$this->pdv_type 	= $pvt['pvt_pdv_type'];
					$this->timestamp 	= $pvt['pvt_timestamp'];
					
					$this->set_task_types();
				}
				else
				{
					$this->set_error( "PDV Type not found (" . $id_pdv_type . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}   
	}
	
	public function get_array()
	{
		$values = array(
							'id_pdv_type'	=> $this->id_pdv_type,
							'pdv_type'		=> $this->pdv_type,
							'timestamp'		=> $this->timestamp
						);
		
		return $values;
	}
	
	private function clean()
	{
		$this->id_pdv_type 	= 0;
		$this->pdv_type 	= '';
		$this->timestamp 	= 0;
		$this->task_types	= array();
	}
	
	public function get_task_type_info__html()
	{
		$html  = "";
		$pvt = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "pdv/info.pdv.type.task.type.php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
	
	private function set_task_types()
	{
		global $obj_bd;
		$query =	" SELECT ptt_pvt_id_pdv_type, pvt_pdv_type, ptt_tt_id_task_type, tt_task_type ".
					" FROM " . PFX_MAIN_DB . "pdv_type_task_type ".
					" INNER JOIN " . PFX_MAIN_DB . "pdv_type ON id_pdv_type = ptt_pvt_id_pdv_type ".
					" INNER JOIN " . PFX_MAIN_DB . "task_type ON id_task_type = ptt_tt_id_task_type ".
					" WHERE ptt_pvt_id_pdv_type = :id_pvt ";
					
		$info = $obj_bd->query( $query, array( ':id_pvt' => $this->id_pdv_type ) );
			
		if ( $info !== FALSE )
		{
			foreach($info as $k => $row )
			{
				$pvtask = array();
				$pvtask['id_task_type'] 	= $row['ptt_tt_id_task_type'];
				$pvtask['task_Type'] 		= $row['tt_task_type'];
				
				$this->task_types[] = $pvtask;
			}
		}
		else
		{ 
			$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
		} 
	}
	
	public function get_task_type_html()
	{	
		$html = '';
		foreach($this->task_types as $ttype)
		{
			$html .= '<tr><td>'.$ttype['id_task_type'].'</td> <td>'.$ttype['task_Type'].'</td> </tr>';
		}
		
		return $html;
	}
}

?>