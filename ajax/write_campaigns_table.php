<?php
	// on inclue les constantes & le FWK WP
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	// on recup toute la config JSON
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oPrefixEmailing = $tab_config_values['CMFR__prefix_email'];
	$oPrefixNL = $tab_config_values['CMFR__prefix_nl'];
	$oPrefixBAT = $tab_config_values['CMFR__prefix_bat'];
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);
	
	if($_GET['type']>0)
	{
		// on instancie notre client
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);

		// on recupere les infos de la config Email
		$oEmailCampaignInfos_ep = $MyEMST->GetCampaignsList('EN_PREPARATION');
		$oEmailCampaignInfos_t = $MyEMST->GetCampaignsList('TERMINE');
		// die(var_dump($oEmailTemplatesInfos));

		$return_txt ='';
		$type = $_GET['type'];
		if($type == 1)
		{
			// cas des camps en preparation
			$return_txt .= '<p><input type="text" class="search_in" value="" id="_prepared_camps" /></p>';
			$return_txt .= '<table class="cm" id="tbl_prepared_camps">';
				$return_txt .= '<tr>';
					$return_txt .= '<th width="40px">';
						$return_txt .= '';
					$return_txt .= '</th>';
					
					$return_txt .= '<th width="5%">';
						$return_txt .= $oResources->rsc_table_id;
					$return_txt .= '</th>';							
					
					$return_txt .= '<th>';					
						$return_txt .= $oResources->rsc_table_name;
					$return_txt .= '</th>';	
						
					$return_txt .= '<th width="50">';
						$return_txt .= $oResources->rsc_table_actions;
					$return_txt .= '</th>';							
				$return_txt .= '</tr>';

				if(count($oEmailCampaignInfos_ep->CampaignsListDetails)>1){
					// plusieurs resultats
					
					foreach($oEmailCampaignInfos_ep->CampaignsListDetails as $line){
						// on enleve le prefixe EMAILING
						$oDesc = $line->description;			
						if(strpos($oDesc,$oPrefixEmailing) !== false ){								
							$oDesc_temp = explode($oPrefixEmailing,$oDesc);	
							$oDesc = $oDesc_temp[1];	
							$wishdate = $MyEMST->_campaigns->GetCampaign(array('campaignId'=>$line->id)) -> GetCampaignResult ->sents ->SentDetails -> wishdate;
							
							$return_txt .= '<tr id="'.$line->id.'">';
						
								$return_txt .= '<td>';
								if($wishdate == "0001-01-01T00:00:00"){
									$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/state_not_sent.png" />';
								}else{
									$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/state_sent.png" /> ' ;
								}
								$return_txt .= '</td>';
								$return_txt .= '<td>';
									$return_txt .= $line->id;
								$return_txt .= '</td>';								
								$return_txt .= '<td>';
									$return_txt .= $oDesc. '<span style="display:none">'.strtolower($oDesc).' ('. transFromISOToDate($wishdate).')</span>';
								$return_txt .= '</td>';	
								$return_txt .= '<td>';
									$return_txt .= '<div class="actions_switcher"> </div>';						
									$return_txt .= '<div id="'.$line->id.'" class="partial_buttons" style="display:none">';
										$return_txt .= '<span class="action_campaign preview" id="preview">'.$oResources->rsc_table_action_preview.'</span>';
										if($wishdate == "0001-01-01T00:00:00"){
											$return_txt .= '<span class="action_campaign edit" id="edit">'.$oResources->rsc_table_action_edit.'</span>';
											$return_txt .= '<span class="action_campaign send" id="send">'.$oResources->rsc_table_action_send.'</span>';
											$return_txt .= '<span class="action_campaign bat" id="sendbat">'.$oResources->rsc_table_action_sendtest.'</span>';
											$return_txt .= '<span class="action_campaign duplicate" id="duplicate">'.$oResources->rsc_table_action_duplicate.'</span>';
											$return_txt .= '<span class="action_campaign delete" id="delete">'.$oResources->rsc_table_action_delete.'</span>';
										}
									$return_txt .= '</div>';
									$return_txt .= '<div style="display:none" class="partial_loading"><img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif" /></div>';
								$return_txt .= '</td>';								
							$return_txt .= '</tr>';	
						}
					}
				}
				else if(count($oEmailCampaignInfos_ep->CampaignsListDetails)>=1)
				{
					// on enleve le prefixe EMAILING
					$oDesc = $oEmailCampaignInfos_ep->CampaignsListDetails->description;			
					if(strpos($oDesc,$oPrefixEmailing) !== false ){								
						$oDesc_temp = explode($oPrefixEmailing,$oDesc);
						$oDesc = $oDesc_temp[1];
					}	
					$wishdate = $MyEMST->_campaigns->GetCampaign(array('campaignId'=>$oEmailCampaignInfos_ep->CampaignsListDetails->id)) -> GetCampaignResult ->sents ->SentDetails -> wishdate;

					$return_txt .= '<tr id="'.$oEmailCampaignInfos_ep->CampaignsListDetails->id.'">';

						$return_txt .= '<td>';						
							if($wishdate == "0001-01-01T00:00:00"){
								$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/state_not_sent.png" />';
							}else{
								$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/state_sent.png" /> ' ;
							}			
						$return_txt .= '</td>';
						$return_txt .= '<td>';
							$return_txt .= $oEmailCampaignInfos_ep->CampaignsListDetails->id;
						$return_txt .= '</td>';
						$return_txt .= '<td>';
							$return_txt .= $oDesc . '<span style="display:none">'.strtolower($oDesc).' (sent '. transFromISOToDate($wishdate,$tab_config_values['CMFR__api_date_lang']).')</span>';
						$return_txt .= '</td>';	
						$return_txt .= '<td>';
							$return_txt .= '<div class="actions_switcher"> </div>';						
							$return_txt .= '<div id="'.$oEmailCampaignInfos_ep->CampaignsListDetails->id.'" class="partial_buttons" style="display:none">';
							$return_txt .= '<span class="action_campaign preview" id="preview">'.$oResources->rsc_table_action_preview.'</span>';
							$return_txt .= '<span class="action_campaign edit" id="edit">'.$oResources->rsc_table_action_edit.'</span>';
							$return_txt .= '<span class="action_campaign send" id="send">'.$oResources->rsc_table_action_send.'</span>';
							$return_txt .= '<span class="action_campaign bat" id="sendbat">'.$oResources->rsc_table_action_sendtest.'</span>';
							$return_txt .= '<span class="action_campaign duplicate" id="duplicate">'.$oResources->rsc_table_action_duplicate.'</span>';
							$return_txt .= '<span class="action_campaign delete" id="delete">'.$oResources->rsc_table_action_delete.'</span>';
							$return_txt .= '</div>';
							$return_txt .= '<div style="display:none" class="partial_loading"><img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif" /></div>';
						$return_txt .= '</td>';								
					$return_txt .= '</tr>';							
				}
		}
		else if($type >= 2)
		{
			// cas des camps deja envoyées			
			$return_txt .= '<p><input type="text" class="search_in" value="" id="_finished_camps" /></p>';
			$return_txt .= '<table class="cm" id="tbl_finished_camps">';		
			$return_txt .= '<tr>';
				$return_txt .= '<th width="40px">';
					$return_txt .= '';
				$return_txt .= '</th>';
				$return_txt .= '<th width="5%">';
					$return_txt .= $oResources->rsc_table_id;
				$return_txt .= '</th>';
	
				$return_txt .= '<th>';
					$return_txt .= $oResources->rsc_table_name;
				$return_txt .= '</th>';	
				$return_txt .= '<th width="50">';
					$return_txt .= $oResources->rsc_table_actions;
				$return_txt .= '</th>';							
			$return_txt .= '</tr>';
			// si plusieurs campagnes	
			if(count($oEmailCampaignInfos_t->CampaignOverview)>1)
			{
				foreach($oEmailCampaignInfos_t->CampaignOverview as $line){
					$test = 0;	
					$oDesc = $line->Description;
					
					if($type == 2)
					{
						// si on est en mode EMAILING
						if(strpos($oDesc,$oPrefixEmailing)!== false){
							$oDesc_temp = explode($oPrefixEmailing,$oDesc);							
							$oDesc = $oDesc_temp[1];							
							$test = 1;									
						}							
					}
					
					if($type == 4)
					{
						// si on est en mode EMAILING : BAT
						if(strpos($oDesc,$oPrefixBAT)!== false){
							$oDesc_temp = explode($oPrefixBAT,$oDesc);							
							$oDesc = $oDesc_temp[1];							
							$test = 1;									
						}							
					}
					
					if($type == 3)
					{
						// si on est en mode NL
						// on enleve le prefixe NL
						if(strpos($oDesc,$oPrefixNL)!== false){
							$oDesc_temp = explode($oPrefixNL,$oDesc);							
							$oDesc = $oDesc_temp[1];							
							$test = 1;									
						}
					}
					if($test == 1 && $line->Id>0)
					{
						$return_txt .= '<tr id="'.$line->Id.'">';
							$return_txt .= '<td>';
							if($type == 4)
							{
								$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/state_bat_finished.png" /> ' ;
							}else{
								$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/state_finished.png" /> ' ; 
							}						
							$return_txt .= '</td>';	
							$return_txt .= '<td>';
								$return_txt .= $line->Id;
							$return_txt .= '</td>';
											
							$return_txt .= '<td>';
								$return_txt .= $oDesc. '<span style="display:none">'.strtolower($oDesc).'</span>';
							$return_txt .= '</td>';																		
							$return_txt .= '<td>';
							$return_txt .= '<div class="actions_switcher"> </div>';						
							$return_txt .= '<div id="'.$line->Id.'" class="partial_buttons" style="display:none">';
									$return_txt .= '<span class="action_campaign stats" id="stats">'.$oResources->rsc_table_action_seedetails.'</span>';
									if($type < 4){
									$return_txt .= '<span class="action_campaign duplicate" id="duplicate">'.$oResources->rsc_table_action_duplicate.'</span>';											
									}
								$return_txt .= '</div>';
								$return_txt .= '<div style="display:none" class="partial_loading"><img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif" /></div>';
							$return_txt .= '</td>';							
						$return_txt .= '</tr>';
					}							
				}
			} // fin des plusieurs campagnes
			else
			{
			// une seule campagne
				$test = 0;	
				$oDesc =  $oEmailCampaignInfos_t->CampaignOverview->Description;			
				if($type == 2)
				{
					// si on est en mode EMAILING
					if(strpos($oDesc,$oPrefixEmailing) !== false){
						$oDesc_temp = explode($oPrefixEmailing,$oDesc);							
						$oDesc = $oDesc_temp[1];							
						$test = 1;									
					}							
				}
				else if($type == 3)
				{
					// si on est en mode NL
					// on enleve le prefixe NL
					if(strpos($oDesc,$oPrefixNL) !== false){
						$oDesc_temp = explode($oPrefixNL,$oDesc);							
						$oDesc = $oDesc_temp[1];							
						$test = 1;									
					}
				}else if($type == 4)
				{
					// si on est en mode EMAILING : BAT
					if(strpos($oDesc,$oPrefixBAT)!== false){
						$oDesc_temp = explode($oPrefixBAT,$oDesc);							
						$oDesc = $oDesc_temp[1];							
						$test = 1;									
					}							
				}else{

				}				
				
				if($test == 1)
				{
					$return_txt .= '<tr id="'.$oEmailCampaignInfos_t->CampaignOverview->Id.'">';
						$return_txt .= '<td>';
						if($type == 4)
						{
							$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/state_bat_finished.png" /> ' ;
						}else{
							$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/state_finished.png" /> ' ; 
						}						
						$return_txt .= '</td>';	
						$return_txt .= '<td>';
							$return_txt .= $oEmailCampaignInfos_t->CampaignOverview->Id;
						$return_txt .= '</td>';
					
						$return_txt .= '<td>';
							$return_txt .= $oDesc. '<span style="display:none">'.strtolower($oDesc).'</span>';
						$return_txt .= '</td>';	
						$return_txt .= '<td>';
							$return_txt .= '<div class="actions_switcher"> </div>';						
							$return_txt .= '<div id="'.$line->id.'" class="partial_buttons" style="display:none">';
								$return_txt .= '<span class="action_campaign stats" id="stats">'.$oResources->rsc_table_action_seedetails.'</span>';
							$return_txt .= '</div>';
							$return_txt .= '<div style="display:none" class="partial_loading" style="text-align:center"><img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif" /></div>';
						$return_txt .= '</td>';							
					$return_txt .= '</tr>';
				}
			}
			$return_txt .= '</table>'; 
		}
		
		// var_dump( $oEmailCampaignInfos_ep);
		$return_txt .= '</table>'; 
		header('HTTP/1.1 200 OK');	
		echo $return_txt;	
	}else{
		// appel NOK : manque paramètres
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>