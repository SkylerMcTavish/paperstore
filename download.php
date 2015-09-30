<?php
	require_once 'init.php';
	$which = $_POST['which'];
	
	switch($which)
	{
		case 'apk_file':
			header('Content-Disposition: attachment;filename=' . $name . '' );
			header('Cache-Control: max-age=0');
			
			$content = file_get_contents(DIRECTORY_UPLOADS.'/apk/sftracker.apk');
			if ( $content )
				echo $content;
			else
			{
			} 
		break;
	}

?>