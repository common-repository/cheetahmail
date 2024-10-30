<?php
	// on inclue les constantes & le FWK WP
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	// on instancie notre client
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
			
	if(
	( isset($_POST['TemplateId']) && $_POST['TemplateId']>0 ) &&
	( isset($_POST['TemplateName']) && strlen($_POST['TemplateName'])>0) &&
	( isset($_POST['SourceHTML']) && strlen($_POST['SourceHTML'])>0 ) &&
	( isset($_POST['SourceTXT']) && strlen($_POST['SourceTXT'])>0 ) &&
	( isset($_POST['subject']) && strlen($_POST['subject'])>0 )	
	){		
		// on ajoute le template
		$array_template = array('IdTemplate'=>$_POST['TemplateId'],'TemplateName'=>stripslashes($_POST['TemplateName']).'|||||'.date('Y-m-d H:i:s'),'SourceHTML'=>stripslashes($_POST['SourceHTML']),'SourceTXT'=>stripslashes($_POST['SourceTXT']),'subject'=>stripslashes($_POST['subject']));
		$res = $MyEMST->_chronocontact->ModifyTemplate($array_template);
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