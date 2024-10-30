<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
			
	if(
	( isset($_POST['idTemplate']) && $_POST['idTemplate']>0)
	)
	{
		// on recupere le template
		$MyTemplate = $MyEMST->GetTemplateById($_POST['idTemplate']);
		// on en cree un nouveau
		$res = $MyEMST->AddTemplate(stripslashes($MyTemplate['name']. '(BIS)').'|||||'.date('Y-m-d').'T'.date('H:i:s'), stripslashes($MyTemplate['html']),stripslashes($MyTemplate['txt']),stripslashes($MyTemplate['subject']));
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