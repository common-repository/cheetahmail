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

	if( isset($_POST['id_campaign']) && $_POST['id_campaign']>0 ){		
		// on recup les infos
		$MyCampaign = $MyEMST->GetCampaignByd($_POST['id_campaign']);
		$MyCampaign_contents = $MyEMST->GetContentsCampaign($_POST['id_campaign']);		
		$MyCampaign_stats = $MyEMST->GetStats($_POST['id_campaign']);
		if($MyCampaign_stats ->Envelope > 0){
			$oConfig = $MyCampaign_stats -> Envelope;
		}
		$MyCampaign_config = $MyEMST->GetConfigById($oConfig);
		
		$jHtml = '';
		$jHtml .= '<h2>'.$MyCampaign->description.' <div class="shut">X</div></h2>';
		$jHtml .= '<div>';
			$jHtml .= '<p>';
			if($MyCampaign_stats ->Recipients > 0){
				$jHtml .= '<label class="switcher" id="1">'.strtoupper($oResources->rsc_camp_html).'</label>';
				$jHtml .= '<label class="switcher" id="2">'.strtoupper($oResources->rsc_camp_txt).'</label>';
				$jHtml .= '<label class="switcher" id="3">'.strtoupper($oResources->rsc_camp_envelopp).'</label>';				
				$jHtml .= '<label class="switcher active" id="4">'.strtoupper($oResources->rsc_camp_recipients).'</label>';
				$jHtml .= '<label class="switcher" id="5">'.strtoupper($oResources->rsc_camp_bounces).'</label>';
				$jHtml .= '<label class="switcher" id="6">'.strtoupper($oResources->rsc_camp_performance).'</label>';
			}
			else
			{
				$jHtml .= '<label class="switcher active" id="1">'.strtoupper($oResources->rsc_camp_html).'</label>';
				$jHtml .= '<label class="switcher" id="2">'.strtoupper($oResources->rsc_camp_txt).'</label>';
				$jHtml .= '<label class="switcher" id="3">'.strtoupper($oResources->rsc_camp_envelopp).'</label>';				
			}
			$jHtml .= '</p>';
			
			// html version
			if($MyCampaign_stats ->Recipients > 0){
				$jHtml .= '<p class="switch" id="1" style="display:none">';
			}else{
				$jHtml .= '<p class="switch" id="1">';
			}
				$jHtml .= '<iframe src="../wp-content/plugins/cheetahmail/preview/campaign_preview.php?type=html&idc='. $MyCampaign->id .'" />';
			$jHtml .= '</p>';
			
			// txt version
			$jHtml .= '<p class="switch" id="2" style="display:none">';
				$jHtml .= '<iframe src="../wp-content/plugins/cheetahmail/preview/campaign_preview.php?type=txt&idc=' .$MyCampaign->id. '" />';
			$jHtml .= '</p>';
			
			// config
			$jHtml .= '<div class="switch" id="3" style="display:none">';
				$jHtml .= '<p><strong> '.$oResources->rsc_camp_sentdate.' </strong>' . transFromISOToDate($MyCampaign_stats ->SendDate,$tab_config_values['CMFR__api_date_lang']) .'</p>';
				$jHtml .= '<p><strong>'.$oResources->rsc_config_emailfrom.' </strong>'.$MyCampaign_config->mailFrom.' &lt;' . $MyCampaign_config->mailFromAddr. '@' .$oDkim .'&gt;</p>';
				$jHtml .= '<p><strong>'.$oResources->rsc_config_reply.' </strong>'.$MyCampaign_config->mailReply.'</p>';
				$jHtml .= '<p><strong>'.$oResources->rsc_config_tooltip_subject.' </strong>'.$MyCampaign_contents->subject.'</p>';
			$jHtml .= '</div>';

			if($MyCampaign_stats ->Recipients > 0){
				// repartition des recipients
				$jHtml .= '<div class="switch" id="4">';			
					$jHtml .= '<div id="graphik_1" class="graph_chart"></div>';				
					$jHtml .= '<table class="cm">';
						$jHtml .= '<tr>';
							$jHtml .= '<th>'.$oResources->rsc_camp_recipients.'</th>';
							$jHtml .= '<th>'.$oResources->rsc_table_filtered.'</th>';
							$jHtml .= '<th>'.$oResources->rsc_table_bounces.'</th>';
							$jHtml .= '<th>'.$oResources->rsc_table_delivered.'</th>';
							$jHtml .= '<th>'.$oResources->rsc_table_unsubs.'</th>';
						$jHtml .= '</tr>';
						$jHtml .= '<tr>';
							$jHtml .= '<td id="tbl_stats_recipients">'.$MyCampaign_stats ->Recipients.'</td>';
							$jHtml .= '<td id="tbl_stats_filtered">'.$MyCampaign_stats ->Filtered.'</td>';
							$jHtml .= '<td id="tbl_stats_bounces">'.$MyCampaign_stats ->Bounces.'</td>';
							$jHtml .= '<td id="tbl_stats_delivered">'.$MyCampaign_stats ->Delivered.'</td>';
							$jHtml .= '<td id="tbl_stats_unsubs">'.$MyCampaign_stats ->Unsubs.'</td>';
						$jHtml .= '</tr>';
						$jHtml .= '<tr>';
							$jHtml .= '<td>100%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Filtered / $MyCampaign_stats ->Recipients) * 100),0) .'%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Bounces / $MyCampaign_stats ->Recipients) * 100),0).'%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Delivered / $MyCampaign_stats ->Recipients) * 100),0) .'%</td>';	
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Unsubs / $MyCampaign_stats ->Recipients) * 100),0) .'%</td>';	
						$jHtml .= '</tr>';						
					$jHtml .= '</table>';			
				$jHtml .= '</div>';	
				
				// repartition des bounces			
				$jHtml .= '<div class="switch" id="5" style="display:none">';
				if($MyCampaign_stats -> Bounces > 0){
					$jHtml .= '<div id="graphik_2" class="graph_chart"></div>';
					$jHtml .= '<table class="cm">';
						$jHtml .= '<tr>';
							$jHtml .= '<th>'.$oResources -> rsc_table_recipients.'</th>';
							$jHtml .= '<th>'.$oResources -> rsc_table_bounces.'</th>';
							$jHtml .= '<th>'.$oResources -> rsc_table_hardbounces.'</th>';
							$jHtml .= '<th>'.$oResources -> rsc_table_softbounces.'</th>';
							// $jHtml .= '<th style="display:none">Complaints</th>';
						$jHtml .= '</tr>';
						$jHtml .= '<tr>';
							$jHtml .= '<td id="tbl_stats_recipients">'.$MyCampaign_stats ->Recipients.'</td>';
							$jHtml .= '<td id="tbl_stats_bounces">'.$MyCampaign_stats ->Bounces.'</td>';
							$jHtml .= '<td id="tbl_stats_hardbounces">'.$MyCampaign_stats ->HardBounces.'</td>';
							$jHtml .= '<td id="tbl_stats_softbounces">'.$MyCampaign_stats ->SoftBounces.'</td>';
							// $jHtml .= '<td id="tbl_stats_complaints" style="display:none">'.$MyCampaign_stats ->Complaints.'</td>';
						$jHtml .= '</tr>';
						$jHtml .= '<tr>';
							$jHtml .= '<td>100%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Bounces / $MyCampaign_stats ->Recipients) * 100),0) .'%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->HardBounces / $MyCampaign_stats ->Bounces) * 100),0).'%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->SoftBounces / $MyCampaign_stats ->Bounces) * 100),0) .'%</td>';	
						$jHtml .= '</tr>';						
					$jHtml .= '</table>';
				}else{
					$jHtml .= '<p>'.$oResources -> rsc_camp_nostats.'</p>';
				}				
				$jHtml .= '</div>';	
				
				// repartition des clicks 
				$jHtml .= '<div class="switch" id="6" style="display:none">';
					$jHtml .= '<div id="graphik_3" class="graph_chart"></div>';
					$jHtml .= '<table class="cm">';
						$jHtml .= '<tr>';
							$jHtml .= '<th>'.$oResources -> rsc_table_recipients.'</th>';
							$jHtml .= '<th>'.$oResources -> rsc_table_openers.'</th>';
							$jHtml .= '<th>'.$oResources -> rsc_table_openings.'</th>';
							$jHtml .= '<th>'.$oResources -> rsc_table_clickers.'</th>';
							$jHtml .= '<th>'.$oResources -> rsc_table_clicks.'</th>';
							$jHtml .= '<th>'.$oResources -> rsc_table_unsubs.'</th>';
						$jHtml .= '</tr>';
						$jHtml .= '<tr>';
							$jHtml .= '<td id="tbl_stats_recipients">'.$MyCampaign_stats ->Recipients.'</td>';
							$jHtml .= '<td id="tbl_stats_openers">'.$MyCampaign_stats ->Openers.'</td>';
							$jHtml .= '<td id="tbl_stats_openings">'.$MyCampaign_stats ->Openings.'</td>';
							$jHtml .= '<td id="tbl_stats_clickers">'.$MyCampaign_stats ->Clickers.'</td>';
							$jHtml .= '<td id="tbl_stats_clicks">'.$MyCampaign_stats ->Clicks.'</td>';
							$jHtml .= '<td  id="tbl_stats_unsubs">'.$MyCampaign_stats ->Unsubs.'</td>';	
						$jHtml .= '</tr>';
						$jHtml .= '<tr>';
							$jHtml .= '<td>100%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Openers / $MyCampaign_stats ->Recipients) * 100),0) .'%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Openings / $MyCampaign_stats ->Recipients) * 100),0).'%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Clickers / $MyCampaign_stats ->Recipients) * 100),0).'%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Clicks / $MyCampaign_stats ->Recipients) * 100),0).'%</td>';
							$jHtml .= '<td>'.number_format((($MyCampaign_stats ->Unsubs / $MyCampaign_stats ->Recipients) * 100),0) .'%</td>';	
						$jHtml .= '</tr>';					
					$jHtml .= '</table>';					
				$jHtml .= '</div>';	
		}	
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