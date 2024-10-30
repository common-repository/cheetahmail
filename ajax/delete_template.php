<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	// on recup toute la config JSON
	$tab_config_values = getVarWithoutSession();

	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];

	// on instancie notre client
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
			
	if(isset($_POST['idTemplate']) && strlen($_POST['idTemplate'])>0){
		// on ajoute le template
		$res = $MyEMST->DeleteTemplateById($_POST['idTemplate']);
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