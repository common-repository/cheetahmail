<?php
	// on inclue les API
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);	
	try{
		
		$obj = $MyEMST->_chronocontact->GetTemplate(array('templateId'=> $_GET['idt']))->GetTemplateResult;
		
		if($_GET['type'] == "html"){
			header('HTTP/1.1 200 OK');	
			echo $MyEMST->getPreviewContent($obj -> htmlSource);
		}else if($_GET['type'] == "txt"){
			header('HTTP/1.1 200 OK');	
			echo nl2br($MyEMST->getPreviewContent($obj -> txtSource));
		}else if($_GET['type'] == "subject"){
			header('HTTP/1.1 200 OK');	
			echo $MyEMST->getPreviewContent($obj -> subject);
		}
	} catch ( Exception $e ) {
		header('HTTP/1.1 200 OK');	
		echo -1;
	}  
?>