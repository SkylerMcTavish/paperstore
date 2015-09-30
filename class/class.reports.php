<?php

class Report extends Object{
	
	public $name;
	
	private $query;
	private $sidx;
	
	
	function __construct($data){
		global $obj_bd;
		$this->error = array();
		$this->class = "Report";
		$this->configure($data);
	}
	/*Step 1, configure report*/
	private function configure($data)
	{
		$this->name = $data->name;
		$this->set_query();
	}
	
	/*Step 2, generate it*/
	public function generate_report()
	{
		if ( (int)method_exists($this, $this->endpoint) > 0)
		{
        	
            return $this->_response($this->{$this->endpoint}($this->args));
        }
        //return array( "No Endpoint: ". $this->endpoint , 404);
		return FALSE;
	}
	
	/*Step 3, get the html*/
	public function get_info_html()
	{
	 	$html  = "";
		$data = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "reports/info.".$this->name.".php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	 }
	 
	 /*Report specific functions*/
	private function set_query()
	{
		switch($this->name)
		{
			case 'Balance de Productos':
				$this->query = 	"SELECT id_product, pd_product, sp_current, sp_supplied, sp_timestamp ".
								"FROM ".PFX_MAIN_DB."supply ".
								"INNER JOIN ".PFX_MAIN_DB."product ON sp_pd_id_product = id_product ";
			break;
		}
	}	
}

?>