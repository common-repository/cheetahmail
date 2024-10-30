<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
			
	if(isset($_POST['TemplateId']) && $_POST['TemplateId']>0)
	{
		// on ajoute le template
		$MyTemplate = $MyEMST->GetTemplateById($_POST['TemplateId']);
		$jHtml =array();
		$jHtml['name'] = $MyTemplate['name'];
		$jHtml['subject'] = $MyTemplate['subject'];
		$jHtml['html'] = $MyTemplate['html'];
		$jHtml['txt'] = $MyTemplate['txt'];
		header('HTTP/1.1 200 OK');	
		echo json_encode($jHtml);			
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>