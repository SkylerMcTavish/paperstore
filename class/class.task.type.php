<?php
/**
* Task CLass
* 
* @package		Ragasa
* @since        5/2/2015
* @author		ignacio.cerda
* 
*/ 
class TaskType extends Object {
	 
	public $id_task_type;
	public $task_type;
	public $description;
	
	public $activities = array();
	
	public $timestamp;
	
	function __construct( $id_task_type = 0 )
	{
		global $obj_bd;
		$this->class = 'TaskType';
		$this->error = array();
		$this->clean();
		
		if ( $id_task_type > 0 )
		{
			$query = 	" SELECT id_task_type, tt_task_type, tt_description, tt_timestamp ".
						" FROM ". PFX_MAIN_DB ."task_type ".
						" WHERE id_task_type = :id_task_type ";
					
			$info = $obj_bd->query( $query, array( ':id_task_type' => $id_task_type ) );
			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$act = $info[0];
					$this->id_task_type 	= $act['id_task_type'];
					$this->task_type 		= $act['tt_task_type'];
					$this->description 		= $act['tt_description'];
					$this->timestamp 		= $act['tt_timestamp'];
					
					$this->set_activities();
				}
				else
				{
					$this->set_error( "Task Type not found (" . $id_task_type . "). ", ERR_DB_NOT_FOUND, 2 ); 
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
							'id_task_type'	=> $this->id_task_type,
							'task_type'		=> $this->task_type,
							'description'	=> $this->description,
							'timestamp'		=> $this->timestamp
						);
		
		return $values;
	}
	
	private function clean()
	{
		$this->id_task_type 	= 0;
		$this->task_type 		= '';
		$this->description 		= '';
		$this->timestamp 		= 0;
		$this->activities = array();
	}
	
	public function get_activities_info__html()
	{
		$html  = "";
		$ttype = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "activity/info.tasktype.activity.php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
	
	private function set_activities()
	{
		global $obj_bd;
		$query =	" SELECT tta_tt_id_task_type, tta_ac_id_activity, ac_activity ".
					" FROM ". PFX_MAIN_DB . "task_type_activities ".
					" INNER JOIN ". PFX_MAIN_DB . "activity ON id_activity = tta_ac_id_activity ".
					" WHERE tta_tt_id_task_type = :id_ttype ";
					
		$info = $obj_bd->query( $query, array( ':id_ttype' => $this->id_task_type ) );
			
		if ( $info !== FALSE )
		{
			foreach($info as $k => $row )
			{
				$act = array();
				$act['id_activity'] 	= $row['tta_ac_id_activity'];
				$act['activity'] 		= $row['ac_activity'];
				
				$this->activities[] = $act;
			}
		}
		else
		{ 
			$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
		} 
	}
	
	public function get_activities_html()
	{	
		$html = '';
		foreach($this->activities as $activity)
		{
			$html .= '<tr><td>'.$activity['id_activity'].'</td> <td>'.$activity['activity'].'</td> </tr>';
		}
		
		return $html;
	}
}

?>