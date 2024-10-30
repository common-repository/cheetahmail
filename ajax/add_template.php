<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];

	// on instancie notre client
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
			
	if(
	( isset($_POST['TemplateName']) && strlen($_POST['TemplateName'])>0) &&
	( isset($_POST['SourceHTML']) && strlen($_POST['SourceHTML'])>0 ) &&
	( isset($_POST['SourceTXT']) && strlen($_POST['SourceTXT'])>0 ) &&
	( isset($_POST['subject']) && strlen($_POST['subject'])>0 )	
	){
		// on ajoute le template
		$res = $MyEMST->AddTemplate(stripslashes($_POST['TemplateName']).'|||||'.date('Y-m-d').'T'.date('H:i:s'), stripslashes($_POST['SourceHTML']),stripslashes($_POST['SourceTXT']),stripslashes($_POST['subject']));
		header('HTTP/1.1 200 OK');	
		// echo stripslashes($_POST['TemplateName']).'|||||'.date('Y-m-d').'T'.date('H:i:s');
		echo $res;			
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>