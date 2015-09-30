<?php 
/**/ 
class Index {
	var $js;
	var $content;
	var $title;
	var $css;
	var $ajax;
	var $link;
	var $command;
	var $modals;
	
	function Index() {
		$this->js 		= array();
		$this->content 	= "";
		$this->title 	= "";
		$this->css		= array();
		$this->modals	= array();
		$this->ajax		= "";
		$this->command	= "";
	}

	function get_title() {
		global $Session;
		return $Session->settings->title . " | " . $this->title;
	}

	function get_content(){
		return $this->content;
	}
 
	function get_css(){
		$resp = "";
		if ( is_array( $this->css ) && count( $this->css ) > 0 )
			foreach ($this->css as $k => $file) {
				$resp .= "<link href='css/estilo.css' type='text/css' rel='stylesheet' />"; 
			}
		return $resp;
	}

	function get_js(){
		$resp = "";
		if ( is_array( $this->js ) && count( $this->js ) > 0 ){
			foreach ($this->js as $k => $file) {
				$script = "";
				if ( stripos( $file , "admin" ) ) {
					global $Session;
					if ( $Session->is_admin() )
						$script = "<script src='js/" . $file . "' type='text/javascript'></script>";
					else if ( stripos( $file , "pry" ) )
						if ( $Session->is_proyect_admin() )
							$script = "<script src='js/" . $file . "' type='text/javascript'></script>"; 	 
				} else {
					$script = "<script src='js/" . $file . "' type='text/javascript'></script>";
				}
				$resp .= $script;
			}
		}
		return $resp;
	}
	
	function get_modals(){ 
		if ( is_array( $this->modals ) && count( $this->modals ) > 0 ){
			foreach ($this->modals as $k => $file) { 
				if ( stripos( $file , "admin" ) ) {
					global $Session;
					if ( $Session->is_admin() )
						require_once( DIRECTORY_VIEWS . "modals/"  . $file );
					else if ( stripos( $file , "pry" ) )
						if ( $Session->is_proyect_admin() )
							require_once( DIRECTORY_VIEWS . "modals/"  . $file ); 	 
				} else {
					require_once( DIRECTORY_VIEWS . "modals/"  . $file );
				} 
			} 
		}
	}

	function get_ajax(){
		return $this->ajax;
	}
	
	function get_command(){
		return $this->command;
	}
	
	function get_menu(){
		global $config_menu; 
		return $this->loop_menu( $config_menu ); 
	}
	 
	function loop_menu( $link ){ 
		$resp = ""; 
		if ( is_array( $link ) && count( $link ) > 0 ){
			if ( $link['cmd'] == 'root' ){
				$resp .= "<ul class='nav main-menu'>"; 
				foreach ($link['lnk'] as $k => $lnk) {
					$resp .= $this->loop_menu( $lnk );
				}
			} else {
				if ( $link['cmd'] == '#'  ){
					$active = $this->is_active_link( $link );
					$resp .= "<li class='dropdown'>"
							. "<a href='#' class='dropdown-toggle " . ( $active ? "active-parent active" : "$active" ) . "'>" 
							. "<i class='fa " . $link['ico'] . "'></i> <span class='hidden-xs'>" . $link['lbl'] . "</span></a>"
							. "<ul class='dropdown-menu' " . ( $active ? " style='display:block;' " : "" ) . "> ";
							foreach ($link['lnk'] as $k => $lnk) {
								$resp .= $this->loop_menu( $lnk );
							} 
					$resp .= "</ul>"		
							. "</li>"; 
				} else { 
					$active  = ( $this->command == strtok($link['cmd'], '&') ) ? TRUE : FALSE;
					$resp .= "<li><a href='index.php?command=" . $link['cmd'] . "' " . ( $active ? "class='active'" : "" ) . " >" 
								. "<i class='fa " . $link['ico'] . "'></i> <span class='hidden-xs'>" . $link['lbl'] . "</span></a>"
							. "</li>";
				} 
			} 
			$resp .= ( $link['cmd'] != 'root' ) ? "</li>" : "</ul>"; 
		}
		return $resp;
	}
	
	function is_active_link( $link ){
		if ( count( $link ) > 0 ){
			if ( strtok($link['cmd'], '&') == $this->command ){
				return TRUE;
			} else {
				if ( count( $link['lnk'] ) > 0 ){
					foreach ($link['lnk'] as $k => $lnk){
						if ( $this->is_active_link($lnk) )
							return TRUE;
					} 
				} 
			}
		}
		return FALSE;
	}

	function logic( $command ){
		global $uiCommand;
        global $Session;
		
		if($Session->logged_in() && !isset($uiCommand[$command])) {
           $command = ERR_404; 
        } 
        if(!in_array($Session->get_level(),$uiCommand[$command][0])) {
            $command = LOGIN; 
        }
		$this->title      = $uiCommand[$command]['1'];
		$this->content    = $uiCommand[$command]['2'];
		$this->js         = $uiCommand[$command]['3'];
		$this->css        = $uiCommand[$command]['4'];
        $this->ajax       = $uiCommand[$command]['5'];
        $this->modals     = $uiCommand[$command]['6'];
        $this->command    = $command;
		
		$this->link 	= "index.php?command=" . $command ;
	}
}
?>