<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oConfig = $tab_config_values['CMFR__idconf_nl'];
	$oDkim = $tab_config_values['CMFR__api_dkim_label'];	
	$oNLActivation = $tab_config_values['CMFR__nl_activation'];
	$oLastNLSent = $tab_config_values['CMFR__nl_date_last_sent'];
	$oTargetBAT = $tab_config_values['CMFR__idquery_bat_emails'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
	$delay = 0;
	
	$oNLElementsInfos = $MyEMST->getListPagesForNL(
		$tab_config_values['CMFR__nl_date_last_sent'],
		$tab_config_values['CMFR__nl_type_elements'],
		$tab_config_values['CMFR__nl_nb_elements']
	);	
	$oNLElementsConfig = $MyEMST->GetConfigById($oConfig);
	$oNLSubject = $tab_config_values['CMFR__subject_nl'];

	if($oFrequency == 0){
		$delay = 0;
	}else if($oFrequency == 1){
		$delay = 7;
	}else if($oFrequency == 2){
		$delay = 30;
	}
	
	$now = date('Y-m-d').'T'.date('H:i:s');
		
		$return_txt ='';
		
		



		

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

		$return_txt .= '<div class="cadre">';
			$return_txt .= '<p class="ic"><img src="../wp-content/plugins/cheetahmail/img/_big_bat.png" /></p>';
			$return_txt .= '<p class="c-min">'. $oTargetBAT_text . '</p>';			
			$return_txt .= '<p class="c-but">' ;
			$return_txt .= '<span class="valid"><input class="sendbat" type="button" value="'.$oResources->rsc_content_nl_sendbat .'" id="send_bat_nl" title="'.$type.'" ';
			// if( floor(((transToTimeStamp($now) - transToTimeStamp($oLastNLSent)) / 3600) /24) <= $delay )
			// {			
				// $return_txt .= ' disabled="disabled" ';
			// }
			$return_txt .= ' /></span>';		
			$return_txt .= '</p>';
		$return_txt .= '</div>';
		
		$return_txt .= '<div class="cadre">';
			$return_txt .= '<p class="ic"><img src="../wp-content/plugins/cheetahmail/img/_last_sent_nl.png" /></p>';
			$return_txt .= '<p class="c-min">';
			$return_txt .= '<strong> '.$oResources->rsc_content_nl_last_nl .' </strong>'.transFromISOToDate($tab_config_values['CMFR__nl_date_last_sent'],$tab_config_values['CMFR__api_date_lang']).'<br />';		
			$return_txt .= '</p>';
			$return_txt .= '<p class="c-but">' ;		
			$return_txt .= '<span class="valid"><input type="button" ';
			if( floor(((transToTimeStamp($now) - transToTimeStamp($oLastNLSent)) / 3600) /24) <= $delay )
			{
				$return_txt .= ' disabled="disabled" ';
			}
			$return_txt .= ' value="'.$oResources->rsc_content_nl_send .'" class="send" id="send_nl_nl" /></span>';
			$return_txt .= '</p>';		
		$return_txt .= '</div>';
		
		
		$return_txt .= '<div class="cadre">';
			$return_txt .= '<p class="ic"><img src="../wp-content/plugins/cheetahmail/img/_big_envelop.png" /></p>';
			$return_txt .= '<p class="c">';
			$return_txt .= '<strong>'.$oResources->rsc_config_from .'</strong>&quot;'.$oNLElementsConfig->mailFrom.'&quot; &nbsp; &lt;' . $oNLElementsConfig->mailFromAddr. '@' .$oDkim .'&gt;<br />';
			$return_txt .= '<strong>'.$oResources->rsc_config_reply .' </strong>'.$oNLElementsConfig->mailReply.'<br />';			
			$return_txt .= '<strong>'.$oResources->rsc_config_subject .' </strong>'.$MyEMST->getPreviewContent($oNLSubject).'<br />';			
			$return_txt .= '</p>';
		$return_txt .= '</div>';				

		$return_txt .= '<p><label id="1" class="switcher active">HTML</label><label id="2" class="switcher">TXT</label></p>';

		
		$return_txt .= '<p id="1" class="switch"><iframe width="100%" height="300px" src="../wp-content/plugins/cheetahmail/preview/nl_preview.php?type=html" /></p>';	
		$return_txt .= '<p id="2" class="switch" style="display:none"><iframe width="100%" height="300px" src="../wp-content/plugins/cheetahmail/preview/nl_preview.php?type=txt" /></p>';
		header('HTTP/1.1 200 OK');	
		echo $return_txt;

?>