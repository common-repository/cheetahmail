<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);			
	if( isset($_POST['description']) && strlen($_POST['description']) > 0 && isset($_POST['criterias']) )
	{		
		$array_criterias = json_decode(stripslashes($_POST['criterias']),true);
		$res = $MyEMST->AddTargetUser($tab_config_values['CMFR__prefix_target'].stripslashes($_POST['description']), $array_criterias);
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