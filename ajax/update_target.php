<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);			
	if( isset($_POST['idtarget']) && $_POST['idtarget'] > 0 && isset($_POST['criterias']) )
	{		
		$array_criterias = json_decode(stripslashes($_POST['criterias']),true);
		$res = $MyEMST->UpdateTarget($_POST['idtarget'], $array_criterias);
		// echo 0;	
		header('HTTP/1.1 200 OK');			
		echo $res;			
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>