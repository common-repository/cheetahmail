<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
		
	if( isset($_POST['s']) && strlen($_POST['s'])>0){
		// on instancie notre client
		update_option("CMFR__db_mapping",stripslashes($_POST['s']));
		header('HTTP/1.1 200 OK');	
		echo 0;	
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>