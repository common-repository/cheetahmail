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
			
	if(isset($_POST['id_campaign']) && strlen($_POST['id_campaign'])>0)
	{
		// on duplique
		$res = $MyEMST->_campaigns->DuplicateCampaign(array('campaignId'=>$_POST['id_campaign']))->DuplicateCampaignResult;
				
		$table_datas_campaign = $MyEMST->GetCampaignByd($res);
		$table_contents_campaign = $MyEMST->GetContentsCampaign($res);
		
		$desc = $table_datas_campaign ->description;
		$desc = str_replace($tab_config_values['CMFR__prefix_nl'],'',$desc);
		$desc = str_replace($tab_config_values['CMFR__prefix_bat'],'',$desc);
		$desc = str_replace($tab_config_values['CMFR__prefix_email'],'',$desc);
		$desc = $tab_config_values['CMFR__prefix_email'] . $desc;
		$subject = $table_contents_campaign->subject;
		$subject = str_replace($tab_config_values['CMFR__prefix_bat'],'',$subject);
		$html = $table_contents_campaign->htmlsrc;
		$txt = $table_contents_campaign->txtsrc;
		$format = $table_contents_campaign->format;
		
		$Params_campaign = array('campaignId' => $res,'parameters' => array('isPrivate' => false,'description'=>$desc,'filters'=>array('behavioralFilterId'=>0,'fieldFilterId' => $tab_config_values['CMFR__idquery_campaign'],'sqlQueryFilterId' => 0, 'targetId' => 0),'folderId' => 0 ) );
		$update_params_campaign = $MyEMST -> _campaigns ->UpdateCampaign ($Params_campaign) -> UpdateCampaignResult;
		
		
		$Params_sent = array('campaignId' => $res,'parameters' => array('subject' =>$subject,'format'=>$format,'priority'=>3,'htmlSrc' => $MyEMST -> TrackHTMLLinks($html,true),'txtSrc' => $MyEMST -> TrackHTMLLinks($txt, false) ) );
		$update_params_sent = $MyEMST -> _campaigns ->UpdateMessage($Params_sent) -> UpdateMessageResult;


		header('HTTP/1.1 200 OK');		
		echo $res;				
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>