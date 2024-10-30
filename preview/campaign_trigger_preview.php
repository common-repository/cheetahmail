<?php
	// on inclue les API
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');

	// on recup toute la config
	$tab_config_values = getVarWithoutSession();
	
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	
	$oConfig = $tab_config_values['CMFR__idconf_campaign'];
	$oDkim = $tab_config_values['CMFR__api_dkim_label'];

	if($_GET['t'] == 1)
	{
		$oConfig = $tab_config_values['CMFR__idconf_subs'];
		$html = $tab_config_values['CMFR__html_subs'];
		$txt = $tab_config_values['CMFR__txt_subs'];
		$subject = $tab_config_values['CMFR__subject_subs'];
	}
	else if($_GET['t'] == 2)
	{
		$oConfig = $tab_config_values['CMFR__idconf_unsubs'];
		$html = $tab_config_values['CMFR__html_unsubs'];
		$txt = $tab_config_values['CMFR__txt_unsubs'];
		$subject = $tab_config_values['CMFR__subject_unsubs'];
	}	
		
	// on instancie notre client
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$MyCampaign_config = $MyEMST->GetConfigById($oConfig);
	
	$html_header = $MyCampaign_config->htmlHeader;	if($html_header == "-2"){$html_header = '';}
	$txt_header = $MyCampaign_config->txtHeader; 	if($txt_header == "-2"){$txt_header = '';}
	$html_footer = $MyCampaign_config->htmlFooter;	if($html_footer == "-2"){$html_footer = '';}
	$txt_footer = $MyCampaign_config->txtFooter;	if($txt_footer == "-2"){$txt_footer = '';}
	$html_unsubs = $MyCampaign_config->htmlUnsubs;	if($html_unsubs == "-2"){$html_unsubs = '';}
	$txt_unsubs = $MyCampaign_config->txtUnsubs;	if($txt_unsubs == "-2"){$txt_unsubs = '';}
	
	if($_GET['type'] == 'html'){
		header('HTTP/1.1 200 OK');	
		echo $MyEMST->getPreviewContent($html_header . $html . $html_footer . $html_unsubs);
	}else if($_GET['type'] == 'txt'){
		header('HTTP/1.1 200 OK');	
		echo nl2br($MyEMST->getPreviewContent($txt_header . "\r\n" . $txt .  "\r\n" . $txt_footer .  "\r\n" . $txt_unsubs));
	}
		
?>