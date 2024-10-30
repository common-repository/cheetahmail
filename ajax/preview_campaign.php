<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oConfig = $tab_config_values['CMFR__idconf_campaign'];
	$oDkim = $tab_config_values['CMFR__api_dkim_label'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
			
	if( isset($_POST['id_campaign']) && $_POST['id_campaign']>0)
	{
		// on recup les infos
		$MyCampaign = $MyEMST->GetCampaignByd($_POST['id_campaign']);
		$MyCampaign_contents = $MyEMST->GetContentsCampaign($_POST['id_campaign']);
		$MyCampaign_config = $MyEMST->GetConfigById($oConfig);
		
		$jHtml = '';
		$jHtml .= '<h2>'.$MyCampaign->description.' <div class="shut">X</div></h2>';
		//headers			
		$jHtml .= '<div>';
		$jHtml .= '<p>'. $oResources->rsc_config_from.' '.$MyCampaign_config->mailFrom.' &lt;' . $MyCampaign_config->mailFromAddr. '@' .$oDkim .'&gt;</p>';
		$jHtml .= '<p>'. $oResources->rsc_config_reply.' '.$MyCampaign_config->mailReply.'</p>';			
		$jHtml .= '<p>'.$MyEMST->getPreviewContent($MyCampaign_contents->subject).'</p>';
		
		$jHtml .= '<p><label class="switcher active" id="1">HTML</label><label class="switcher" id="2">TXT</label></p>';
		$jHtml .= '<p class="switch" id="1"><iframe src="../wp-content/plugins/cheetahmail/preview/campaign_preview.php?type=html&idc='. $MyCampaign->id .'" /></p>';
		$jHtml .= '<p class="switch" id="2" style="display:none"><iframe src="../wp-content/plugins/cheetahmail/preview/campaign_preview.php?type=txt&idc=' .$MyCampaign->id. '" /></p>';		
		$jHtml .= '</div>';	
		header('HTTP/1.1 200 OK');			
		echo($jHtml);			
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>