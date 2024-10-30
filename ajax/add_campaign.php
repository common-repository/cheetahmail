<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];	
	$oConfig = $tab_config_values['CMFR__idconf_campaign'];
	
	// cible
	if(isset($_POST['target']) && strlen($_POST['target'])>1){
		$oTarget = $_POST['target'];
	}
	else
	{
		$oTarget = $tab_config_values['CMFR__idquery_campaign'];
	}
	
	$oEA = $tab_config_values['CMFR__ea'];
	$wishdate = $_POST['wishdate'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
			
	if(
	( isset($_POST['description']) && strlen($_POST['description'])>0) &&
	( isset($_POST['htmlSrc']) && strlen($_POST['htmlSrc'])>0 ) &&
	( isset($_POST['txtSrc']) && strlen($_POST['txtSrc'])>0 ) &&
	( isset($_POST['subject']) && strlen($_POST['subject'])>0 )	
	){
		// on ajoute la campagne
		$res = $MyEMST->AddCamp($tab_config_values['CMFR__prefix_email'] . stripslashes($_POST['description']),$oTarget,$oConfig,$wishdate,stripslashes($_POST['subject']), 3 ,stripslashes($_POST['htmlSrc']),stripslashes($_POST['txtSrc']),$oEA);
		if($res>0){
			header('HTTP/1.1 200 OK');	
			echo 0;	
		}else{
			header('HTTP/1.1 200 OK');	
			echo -2;
		}	
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>