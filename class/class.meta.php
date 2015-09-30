<?php

/**
 * class Meta
 *  
 */
class Meta extends Object {
	
	public $options = array();
	public $error 	= array();
	
	protected $type = "";
	protected $template = "";
	
	function __construct( ) {
		
	}
	 
	public function get_option( $id ){
		foreach ($this->options as $k => $option) {
			if ( $option->id_option == $id )
				return $option;
		}
		return FALSE;
	}
	
	public function get_frm_control( $option, $pfx = "inp_", $css = "" ){
		$resp = "";
		switch ( $option->id_data_type ){
			case 1: //Binary 
				$resp .= "<div class='row'><div class='col-xs-12'><div class='input-group col-xs-5 pull-left'><span class='input-group-addon'> "
							. " <input type='radio' name='" . $this->type . "_option_" . $option->id_option . "' id='" . $pfx . "" . $this->type . "_option_" . $option->id_option . "_t' "
							. " value='true' " . ( $option->value ? "checked='checked'" : "" ) . " />" 
						. "</span><label class='form-control'> Verdadero </label></div>" 
					  	. "<div class='input-group col-xs-5 pull-right'><span class='input-group-addon'> "
							. " <input type='radio' name='" . $this->type . "_option_" . $option->id_option . "' id='" . $pfx . "" . $this->type . "_option_" . $option->id_option . "_f' "
							. " value='false' " . ( $option->value === false ? "checked='checked'" : "" ) . " />" 
						. " </span><label class='form-control'> Falso </label></div></div></div>";
				break;
			case 2: //Text
			case 3: //Number
			case 4: //Date
			case 5: //Email
			case 6: //Float
				$resp = "<input type='" . strtolower( $option->data_type ) . "' id='" . $pfx . "" . $this->type . "_option_" . $option->id_option . "' name='" . $this->type . "_option_" . $option->id_option . "' "
								. " class='form-control " . $css . "' value='" . $option->value . "' />";
				break;
			case 7: //RadioOption
				$opts = explode( ';', $option->options );
				foreach ($opts as $k => $op) {
					$resp .= "<div class='input-group'><span class='input-group-addon'> "
								. " <input type='radio' name='" . $this->type . "_option_" . $option->id_option . "' id='" . $pfx . "" . $this->type . "_option_" . $option->id_option . "_" . $k . "' "
								. " value='" . $op . "' " . ( $option->value ? "checked='checked'" : "" ) . " />" 
							. " </span><label class='form-control'>" . $op . "</label></div>"; 
				}  
				break;
			case 8: //CheckOption
				$opts = explode( ';', $option->options );
				$vals = explode( ';', $option->value );
				foreach ($opts as $k => $op) {
					$resp .= "<div class='input-group'><span class='input-group-addon'> "
								. " <input type='checkbox' name='" . $this->type . "_option_" . $option->id_option . "[]' id='" . $pfx . "" . $this->type . "_option_" . $option->id_option . "_" . $k . "' "
										. " value='" . $op . "' " . ( in_array($option->value, $opts) ? "checked='checked'" : "" ) . " />"  
							. " </span><label class='form-control'>" . $op . "</label></div>"; 
				}   
				break;
			case 9:
				$opts = explode( ';', $option->options );
				$resp = "<select id='" . $pfx . "" . $this->type . "_option_" . $option->id_option . "' name='" . $this->type . "_option_" . $option->id_option . "'"
						. " class='form-control " . $css . "' >";
				$resp .= "<option value='' " . ( $option->value == '' ? "selected='selected' " : "" ) . "> --- </option>";
				foreach ($opts as $k => $op) {
					$resp .= "<option value='" . $op . "' " . ( $option->value == $op ? "selected='selected' " : " " ) . ">" . $op . "</option>";
				}
				$resp .= "</select>";
				break;
			default:
				$resp = "";
				break;
		}
			
		return $resp;
	}
	
	public function get_frm_html( $pfx = "inp_", $div_css = "row", $inp_css = "" ){
		$resp = "";
		$last = count( $this->options ) - 1;
		foreach ($this->options as $key => $option) {
			$resp .= (($key%2 == 0) ? "<div class='row'>" : "") 
					. "<div class='" . $div_css . "' >"
					. "<label class='control-label'>" . $option->label .  "</label>"
					. $this->get_frm_control( $option, $pfx, $inp_css ) 
					. "</div>"
					. (( $key%2>0 || $key == $last ) ? "</div>" : "") ;
		}
		return $resp;
	}
	
	public function get_options_list_html( $edit = FALSE ){
		$resp = "";
		$li_css = "row";
		foreach ($this->options as $k => $option) {
			require DIRECTORY_VIEWS . "/lists/lst.meta_option.php"; 
		} 
		return $resp;
	}

	public function get_values_list( $div_css = 'col-xs-12 col-sm-6', $lbl_css = 'col-xs-4', $val_css = ''  ){
		$resp = "";
		$li_css = "row";
		foreach ($this->options as $k => $option) {
			$resp .= " <div class='" . $div_css . "'><p>"
					. "<label class='" . $lbl_css . "'>" . $option->label .  ":</label>"
					. "<span class='" . $val_css . "'>" . $option->value .  "</span>"
					. "</p></div>"; 
		} 
		return $resp;
	}
}
?>