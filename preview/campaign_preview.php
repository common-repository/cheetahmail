<?php
	// on inclue les API
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];	
	$oConfig = $tab_config_values['CMFR__idconf_campaign'];
	$oDkim = $tab_config_values['CMFR__api_dkim_label'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$MyCampaign_contents = $MyEMST->GetContentsCampaign($_GET['idc']);
	$MyCampaign_config = $MyEMST->GetConfigById($oConfig);
				
	if($_GET['type'] == "html"){
		header('HTTP/1.1 200 OK');	
		echo $MyEMST->getPreviewContent($MyCampaign_config->htmlHeader . $MyCampaign_contents->htmlsrc . $MyCampaign_config->htmlFooter . $MyCampaign_config->htmlUnsubs);
	}else if($_GET['type'] == "txt"){
		header('HTTP/1.1 200 OK');	
		echo nl2br($MyEMST->getPreviewContent($MyCampaign_config->txtHeader . "\r\n" . $MyCampaign_contents->txtsrc . "\r\n" . $MyCampaign_config->txtFooter . "\r\n" . $MyCampaign_config->txtUnsubs));
	}		
?>