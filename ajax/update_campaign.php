<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];			
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	
	if(
	( isset($_POST['campaignId']) && $_POST['campaignId']>0 ) &&
	( isset($_POST['target']) && $_POST['target']>0) &&
	( isset($_POST['campaignName']) && strlen($_POST['campaignName'])>0) &&
	( isset($_POST['SourceHTML']) && strlen($_POST['SourceHTML'])>0 ) &&
	( isset($_POST['SourceTXT']) && strlen($_POST['SourceTXT'])>0 ) &&
	( isset($_POST['subject']) && strlen($_POST['subject'])>0 )	
	)
	{
		if($_POST['target']>0){
			$oTarget = $_POST['target'];
		}else{
			$oTarget = $tab_config_values['CMFR__idquery_campaign'];
		}
		// on modifie la campagne
		$res = $MyEMST->UpdateCampaignById($_POST['campaignId'],$tab_config_values['CMFR__prefix_email'].stripslashes($_POST['campaignName']),stripslashes($_POST['subject']),stripslashes($_POST['SourceHTML']),stripslashes($_POST['SourceTXT']),$oTarget);
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