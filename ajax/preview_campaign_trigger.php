<?php
	// on inclue les constantes & le FWK WP
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');

	if(isset($_POST['type']) && $_POST['type']>0)
	{
		$tab_config_values = getVarWithoutSession();	
		$oIdlist = $tab_config_values['CMFR__api_idmlist'];
		$oLogin = $tab_config_values['CMFR__api_login'];
		$oPassword = $tab_config_values['CMFR__api_password'];
		$oDkim = $tab_config_values['CMFR__api_dkim_label'];
		$oTargetBAT = $tab_config_values['CMFR__idquery_bat_emails'];		
		$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
		$type = $_POST['type'];
		
		if($type == 1)
		{
			$oConfigSub = $tab_config_values['CMFR__idconf_subs'];
			$oChronoSub = $tab_config_values['CMFR__idchrono_subs'];
			$subject = $tab_config_values['CMFR__subject_subs'];
		}
		else if($type ==2)
		{
			$oConfigSub = $tab_config_values['CMFR__idconf_unsubs'];
			$oChronoSub = $tab_config_values['CMFR__idchrono_unsubs'];	
			$subject = $tab_config_values['CMFR__subject_unsubs'];
		}		
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);		
		$MyCampaign_config = $MyEMST->GetConfigById($oConfigSub);
		
		$jHtml = '';
		


			// on regarde les @ voire s'il faut splitter etc
			$mustbesplit = strpos($oTargetBAT,chr(10));
			$oTargetBAT_tab = array();
			
			if($mustbesplit){
				$oTargetBAT_tab = explode(chr(10),$oTargetBAT);
			}else{
				$oTargetBAT_tab[] = $oTargetBAT;
			}
			$oTargetBAT_text = '';
			
			foreach($oTargetBAT_tab as $email){
				if(strlen($email)>0){
					$oTargetBAT_text .= '<span class="at_unit">&lt;'.$email.'&gt;</span> ';
				}
			}	
			
			$jHtml .= '<div class="cadre">';
				$jHtml .= '<p class="ic"><img src="../wp-content/plugins/cheetahmail/img/_big_bat.png" /></p>';
				$jHtml .= '<p class="c-min">'. $oTargetBAT_text . '</p>';			
				$jHtml .= '<p class="c-but">' ;		
				$jHtml .= '<span class="valid"><input class="sendbat" type="button" value="'.$oResources->rsc_email_sendbat.'" id="send_bat_trigger" title="'.$type.'" /></span>';
				$jHtml .= '</p>';											
			$jHtml .= '</div>';
			

			$jHtml .= '<div class="cadre">';
				$jHtml .= '<p class="ic"><img src="../wp-content/plugins/cheetahmail/img/_big_envelop.png" /></p>';
				$jHtml .= '<p class="c">';
				$jHtml .= '<strong>'.$oResources->rsc_config_emailfrom.' </strong>'.$MyCampaign_config->mailFrom.' &lt;' . $MyCampaign_config->mailFromAddr. '@' .$oDkim .'&gt;<br />';
				$jHtml .= '<strong>'.$oResources->rsc_config_emailreply.' </strong>'.$MyCampaign_config->mailReply.'<br />';			
				$jHtml .= '<strong>'.$oResources->rsc_config_subject.' </strong>'.$MyEMST->getPreviewContent($subject).'<br />';			
				$jHtml .= '</p>';
			$jHtml .= '</div>';	


			$jHtml .= '<p><label class="switcher active" id="1">HTML</label><label class="switcher" id="2">TXT</label></p>';
			$jHtml .= '<p class="switch" id="1"><iframe src="../wp-content/plugins/cheetahmail/preview/campaign_trigger_preview.php?type=html&t='.$type.'" /></p>';
			$jHtml .= '<p class="switch" id="2" style="display:none"><iframe src="../wp-content/plugins/cheetahmail/preview/campaign_trigger_preview.php?type=txt&t='.$type.'" /></p>';		

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