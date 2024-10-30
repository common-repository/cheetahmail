<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	
	if(
	( isset($_POST['type']) && $_POST['type']>0 ) &&
	( isset($_POST['at_user']) && strlen($_POST['at_user'])>0)	
	){		
		// on est ok sur les params
		$type = $_POST['type'];
		$email = $_POST['at_user'];
		$res = $MyEMST->UpdateByEmail($email,$type);	
		header('HTTP/1.1 200 OK');			
		echo $res;						
	}
	else if(
	( isset($_POST['type']) && $_POST['type'] == -1 ) &&
	( isset($_POST['at_user']) && strlen($_POST['at_user'])>0)
	)
	{
		// on le delete
		$email = $_POST['at_user'];
		$res = $MyEMST->DeleteByEmail($email);	
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