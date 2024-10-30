<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
			
	if(isset($_POST['id_campaign']) && strlen($_POST['id_campaign'])>0 && isset($_POST['type']) && $_POST['type']>0){
		// on est ok sur les params
		if($_POST['type'] ==1  && strlen($_POST['wishdate'])>=8){
			// envoi campagne réel			
			$res = $MyEMST->SendCampaign($_POST['id_campaign'],$_POST['wishdate']);
			header('HTTP/1.1 200 OK');	
			echo 0;			
		}else if($_POST['type'] == 2){
			// envoi campagne BAT
			$res = $MyEMST->SendCampaignBAT($_POST['id_campaign']);
			header('HTTP/1.1 200 OK');	
			echo 0;			
		}
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>