<?php
/**
 * Set les temps de cron pour l'envoi de newsletter*
 * @return array $schedules
 */
function cron_add_schedule($schedules)
{
    // Pour la correspondance des noms voir dans la classe newsletter manager
    $time = ( 60 * 60 * 24 ); // Journee
    $schedules[ "cheetahmail_nl_daily" ] = array( "interval"=>$time, "display"=>__( "Once Daily" ) );
 	return $schedules;
}
add_filter( "cron_schedules", "cron_add_schedule" );

function newsletter_send_cron_task()
{
   // si la date de dernier envoi est infèrieure à la date courante dans son interval :: on a une NL à envoyer
   // s'il y a des éléments, sinon rien
   // on recupere les infos de conf
   // on cree la NL
  	
	
/*********************************************************************************************
	on recup toute la config 
*********************************************************************************************/

	$tab_config_values = getVarWithoutSession();	
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oConfig = $tab_config_values['CMFR__idconf_nl'];
	$oTarget = $tab_config_values['CMFR__idquery_nl'];
	$oSubject = $tab_config_values['CMFR__subject_nl'];
	$oDkim = $tab_config_values['CMFR__api_dkim_label'];
	$oNLActivation = $tab_config_values['CMFR__nl_activation'];
	$oLastNLSent = $tab_config_values['CMFR__nl_date_last_sent'];
	$oFrequency = $tab_config_values['CMFR__nl_frequency'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	
	
	$oNLElementsInfos = $MyEMST->getListPagesForNL($tab_config_values['CMFR__nl_date_last_sent'],$tab_config_values['CMFR__nl_type_elements'],$tab_config_values['CMFR__nl_nb_elements'],$tab_config_values['CMFR__nl_order_elements']);	
	$oNLElementsContentWrapperTop = $tab_config_values['CMFR__wrapper_top_nl'];
	$oNLElementsContentWrapperBottom = $tab_config_values['CMFR__wrapper_bottom_nl'];
	$delay = 0;
	$return_txt = '';
	$counter_elt = 0;
	$limit_elt = $tab_config_values['CMFR__nl_nb_elements'];

	
	
/*********************************************************************************************
	ON GENERE LE CONTENU
*********************************************************************************************/	



	switch($limit_elt){
		case "0" : $limit_elt = 5; break; 
		case "1" : $limit_elt = 10; break;
		case "2" : $limit_elt = 20; break;
		case "3" : $limit_elt = 50; break;
		case "4" : $limit_elt = 100; break;
	}	
	$now = date('Y-m-d').'T'.date('H:i:s');
	
	if($oFrequency == 0){
		$delay = 0;
	}else if($oFrequency == 1){
		$delay = 7;
	}else if($oFrequency == 2){
		$delay = 30;
	}
	// le délai d'envoi est dépassé il faut essayer de pousser une NL
	if(floor(((transToTimeStamp($now) - transToTimeStamp($oLastNLSent)) / 3600) /24) > $delay && $oNLActivation == 1)
	{
		// si on a bien des resultats 
		if(!empty($oNLElementsInfos) && count($oNLElementsInfos)>0)
		{	
			// GESTION DES STYLES DU TITRE
			$style_title = '';
			if($tab_config_values['CMFR__nl_title_fontface'] == 0){
				$style_title .= 'font-family:Arial; ';
			}else if($tab_config_values['CMFR__nl_title_fontface'] == 1){
				$style_title .= 'font-family:Verdana; ';
			}else if($tab_config_values['CMFR__nl_title_fontface'] == 2){
				$style_title .= 'font-family:Helvetica; ';
			}
			
			if(strlen($tab_config_values['CMFR__nl_title_color']) == 7){
				$style_title .= 'color:'.$tab_config_values['CMFR__nl_title_color'].'; ';
			}
			
			if($tab_config_values['CMFR__nl_title_size'] > 0){
				$style_title .= 'font-size:'.$tab_config_values['CMFR__nl_title_size'].'px; ';
			}
			
			if($tab_config_values['CMFR__nl_title_underline'] == 1){
				$style_title .= 'text-decoration:underline; ';
			}		

			if($tab_config_values['CMFR__nl_title_bold'] == 1){
				$style_title .= 'font-weight:bold; ';
			}
			if($tab_config_values['CMFR__nl_title_italic'] == 1){
				$style_title .= 'font-style:italic; ';
			}		
			if($tab_config_values['CMFR__nl_title_uppercase'] == 1){
				$style_title .= 'text-transform:uppercase; ';
			}		
			
			// GESTION DES STYLES DU CONTENU
			$style_content = '';
			if($tab_config_values['CMFR__nl_content_fontface'] == 0){
				$style_content .= 'font-family:Arial; ';
			}else if($tab_config_values['CMFR__nl_content_fontface'] == 1){
				$style_content .= 'font-family:Verdana; ';
			}else if($tab_config_values['CMFR__nl_content_fontface'] == 2){
				$style_content .= 'font-family:Helvetica; ';
			}
			
			if(strlen($tab_config_values['CMFR__nl_content_color']) == 7){
				$style_content .= 'color:'.$tab_config_values['CMFR__nl_content_color'].'; ';
			}
			
			if($tab_config_values['CMFR__nl_content_size'] > 0){
				$style_content .= 'font-size:'.$tab_config_values['CMFR__nl_content_size'].'px; ';
			}
			
			if($tab_config_values['CMFR__nl_content_underline'] == 1){
				$style_content .= 'text-decoration:underline; ';
			}		

			if($tab_config_values['CMFR__nl_content_bold'] == 1){
				$style_content .= 'font-weight:bold; ';
			}
			if($tab_config_values['CMFR__nl_content_italic'] == 1){
				$style_content .= 'font-style:italic; ';
			}		
			if($tab_config_values['CMFR__nl_content_uppercase'] == 1){
				$style_content .= 'text-transform:uppercase; ';
			}		

			// GESTION DES STYLES DU LIEN
			$style_link = '';
			if($tab_config_values['CMFR__nl_link_fontface'] == 0){
				$style_link .= 'font-family:Arial; ';
			}else if($tab_config_values['CMFR__nl_link_fontface'] == 1){
				$style_link .= 'font-family:Verdana; ';
			}else if($tab_config_values['CMFR__nl_link_fontface'] == 2){
				$style_link .= 'font-family:Helvetica; ';
			}
			
			if(strlen($tab_config_values['CMFR__nl_link_color']) == 7){
				$style_link .= 'color:'.$tab_config_values['CMFR__nl_link_color'].'; ';
			}
			
			if($tab_config_values['CMFR__nl_link_size'] > 0){
				$style_link .= 'font-size:'.$tab_config_values['CMFR__nl_link_size'].'px; ';
			}
			
			if($tab_config_values['CMFR__nl_link_underline'] == 1){
				$style_link .= 'text-decoration:underline; ';
			}		

			if($tab_config_values['CMFR__nl_link_bold'] == 1){
				$style_link .= 'font-weight:bold; ';
			}
			if($tab_config_values['CMFR__nl_link_italic'] == 1){
				$style_link .= 'font-style:italic; ';
			}		
			if($tab_config_values['CMFR__nl_link_uppercase'] == 1){
				$style_link .= 'text-transform:uppercase; ';
			}		

			// GESTION DES STYLES DU COMMENTAIRE
			$style_coment = '';
			if($tab_config_values['CMFR__nl_coment_fontface'] == 0){
				$style_coment .= 'font-family:Arial; ';
			}else if($tab_config_values['CMFR__nl_coment_fontface'] == 1){
				$style_coment .= 'font-family:Verdana; ';
			}else if($tab_config_values['CMFR__nl_coment_fontface'] == 2){
				$style_coment .= 'font-family:Helvetica; ';
			}
			
			if(strlen($tab_config_values['CMFR__nl_coment_color']) == 7){
				$style_coment .= 'color:'.$tab_config_values['CMFR__nl_coment_color'].'; ';
			}
			
			if($tab_config_values['CMFR__nl_coment_size'] > 0){
				$style_coment .= 'font-size:'.$tab_config_values['CMFR__nl_coment_size'].'px; ';
			}
			
			if($tab_config_values['CMFR__nl_coment_underline'] == 1){
				$style_coment .= 'text-decoration:underline; ';
			}		

			if($tab_config_values['CMFR__nl_coment_bold'] == 1){
				$style_coment .= 'font-weight:bold; ';
			}
			if($tab_config_values['CMFR__nl_coment_italic'] == 1){
				$style_coment .= 'font-style:italic; ';
			}		
			if($tab_config_values['CMFR__nl_coment_uppercase'] == 1){
				$style_coment .= 'text-transform:uppercase; ';
			}		
			

			
			// GESTION DU CONTENU DYNAMIQUE			
			foreach($oNLElementsInfos as $line)
			{
				if( $counter_elt < $limit_elt){
					$return_html .= '<table width=100%" cellpadding="5" cellspacing="0" border="0">';			
						$return_html .= '<tr>';
							if($tab_config_values['CMFR__nl_image'] == 1){ // && $line['img'] != '' && !strpos($line['img'],'default.png')
								$return_html .= '<td colspan="2">';
							}else{
								$return_html .= '<td>';
							}
								$return_html .= '<span style="'.$style_title.'">'.$line['name'].' - '.transFromISOToDate($line['date']).'</span>';
							$return_html .= '</td>';
						$return_html .= '</tr>';


						if($tab_config_values['CMFR__nl_link'] == 1){
							// que si le lien est activé
							$return_html_link = '<br /><a href="'.$line['link'].'" target="_blank" style="'.$style_link.'"> > See more ...</a>';
						}else{
							$return_html_link = '';
						}
							
						$return_html .= '<tr>';
							if($tab_config_values['CMFR__nl_image'] == 1){ // && $line['img'] != '' && !strpos($line['img'],'default.png') 
								if($line['img'] != ''){
								$return_html .= '<td><img src="'.$line['img'].'" /></td>';
								}else{
								$return_html .= '<td><img src="'.EXPERIAN_PLUGIN_URL.'/img/default.png" /></td>';
								}
								$return_html .= '<td>';
								$return_html .= '<span style="'.$style_content.'">'.substr($line['content'],0,400).'</span>';
								$return_html .= $return_html_link;
								$return_html .= '</td>';
							}else{
								$return_html .= '<td colspan="2">';
								$return_html .= '<span style="'.$style_content.'">'.substr($line['content'],0,400).'</span>';
								$return_html .= $return_html_link;
								$return_html .= '</td>';
							}						
							
						$return_html .= '</tr>';
						
						if($tab_config_values['CMFR__nl_coment'] > 0 ){
							$return_html .= '<tr>';
								$return_html .= '<td ';
								if($tab_config_values['CMFR__nl_image'] == 1 ){ // && $line['img'] != '' && !strpos($line['img'],'default.png')
									$return_html .= ' colspan="2" ';	
								}
								$return_html .= '>';
								
								// on récupère les commentaires
								$comments = get_comments('post_id='.$line['id'],'number=' . $tab_config_values['CMFR__nl_coment']);
								
								if(count($comments)>0){
									foreach($comments as $comment){
										$html = '';
										if(strlen($comment->comment_author)>0)
										{
											$html .= '<div style="'.$style_coment.'">';
											$html .= '<strong>' . $comment->comment_author . '</strong>';
											$html .= ' (' . transFromISOToDate($comment->comment_date_gmt) . ')';
											$html .= '<br />';
											$html .= $comment->comment_content;
											$html .= '<br /><br />';
											$html .= '</div>';
											$return_html .=  $html;
										}
									}								
								}
								$return_html .= '</td>';
							$return_html .= '</tr>';	
						}
						$return_html .= '<tr>';
							$return_html .= '<td height="10">&nbsp;</td>';
						$return_html .= '</tr>';						
					$return_html .= '</table>';
					
					
					
					
					$return_txt .= "\r\n\r\n".$line['name']." (".transFromISOToDate($line['date']).")\r\n";
					$return_txt .= substr($line['content'],0,400)."\r\n";
					if($tab_config_values['CMFR__nl_link'] == 1){
						// que si le lien est activé
						$return_txt .= $return_txt_link."\r\n\r\n";
					}
										
					if($tab_config_values['CMFR__nl_coment'] > 0 ){
						// on récupère les commentaires
						$comments = get_comments('post_id='.$line['id'],'number=' . $tab_config_values['CMFR__nl_coment']);
						if(count($comments)>0){
							foreach($comments as $comment){								
								$txt = '';
								if(strlen($comment->comment_author)>0)
								{
									$txt .= $comment->comment_author . ' (' . transFromISOToDate($comment->comment_date_gmt) . ") \r\n";
									$txt .= $comment->comment_content."\r\n\r\n";
									$return_txt .=  "\r\n" . $txt;
								}									
							}								
						}				
					}

					// on incremente
					$counter_elt++;
				}
				else{
					// on a atteint la limite d'elements
				}
			
			}				


	
			// VARIABLES FINALES DE LA NL
			$_wishdate=date('Y-m-d').'T'.date('H:i:s');
			$_wishdate_temp = '0001-01-01T00:00:00';
			$_name = $tab_config_values['CMFR__prefix_nl'] . 'Newsletter : ' . transFromISOToDate($_wishdate);
			$_config = $oConfig;
			$_target = $oTarget;
			$_subject = $oSubject;
			$_format = 3;
			$_ea = 0;
			$_html_body = $oNLElementsContentWrapperTop . $return_html . $oNLElementsContentWrapperBottom;
			$_txt_body =htmlentities(strip_tags( $oNLElementsContentWrapperTop . $return_txt . $oNLElementsContentWrapperBottom));	
			
			// ENVOI DE LA NL
			
			// on cree la camp en etat préparation
			$new_camp = $MyEMST -> AddCamp($_name,$_target,$_config,$_wishdate_temp,$_subject,$_format,stripslashes($_html_body),stripslashes($_txt_body),$_ea);			

			// DOUBLE TRACKING OU PAS

			if($tab_config_values['CMFR__api_doubletracking_enabled'] && $tab_config_values['CMFR__api_doubletracking_id'] > 0)
			{
				// mode double tracking
				$_html_body = $MyEMST->TrackHTMLLinks($_html_body,true,1,$tab_config_values['CMFR__api_doubletracking_id'],$new_camp);
				$_txt_body = $MyEMST->TrackHTMLLinks($_txt_body,false,1,$tab_config_values['CMFR__api_doubletracking_id'],$new_camp);
			}
			else
			{
				// mode simple tracking
				$_html_body = $MyEMST->TrackHTMLLinks($_html_body,true);
				$_txt_body = $MyEMST->TrackHTMLLinks($_txt_body,false);
			}

			$up = $MyEMST -> UpdateCampaignById($new_camp,$_name,$_subject,$_html_body,$_txt_body,$_target);
			print_r($up);
			$st = $MyEMST -> _campaigns -> Start(array('campaignId' => $new_camp));
			print_r($st);
			update_option('CMFR__nl_date_last_sent',$_wishdate);
		}
		else
		{
			// pas d'elements
		}		
	}
	else
	{
		 // pas d'envoi à faire il est trop tôt
	}	

}
add_action( "newsletter_send_cron_task_hook","newsletter_send_cron_task" );

// Désactiver le cron
register_deactivation_hook( __FILE__, 'cheetahmail_uninstall' ); 
function cheetahmail_uninstall() 
{
	// on desactive le cron hook
	$timestamp = wp_next_scheduled( 'newsletter_send_cron_task_hook' );
	wp_clear_scheduled_hook('newsletter_send_cron_task_hook');
	wp_unschedule_event($timestamp, 'newsletter_send_cron_task_hook' );
}

// Activer le cron
$is_installed = get_option( 'CMFR__is_configured', '1' );	
if($is_installed == 0){$test_install = true;}
else{$test_install = false;}	
if (!wp_next_scheduled( "newsletter_send_cron_task_hook" ) && $test_install){ wp_schedule_event( time(), "cheetahmail_nl_daily", "newsletter_send_cron_task_hook" );}

?>