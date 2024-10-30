<?php
	// on inclue les constantes & le FWK WP
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
/*********************************************************************************************
	on recup toute la config 
*********************************************************************************************/
	$tab_config_values = getVarWithoutSession();	
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oConfig = $tab_config_values['CMFR__idconf_nl'];
	if($_GET['type'] == "send"){
		$oTarget = $tab_config_values['CMFR__idquery_nl'];
	}
	else {
		$oTarget = $tab_config_values['CMFR__idquery_bat'];
	}
	$oSubject = $tab_config_values['CMFR__subject_nl'];
	$oDkim = $tab_config_values['CMFR__api_dkim_label'];
	$oNLActivation = $tab_config_values['CMFR__nl_activation'];
	$oLastNLSent = $tab_config_values['CMFR__nl_date_last_sent'];
	$oFrequency = $tab_config_values['CMFR__nl_frequency'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);	
	$oNLElementsInfos = $MyEMST->getListPagesForNL($tab_config_values['CMFR__nl_date_last_sent'],$tab_config_values['CMFR__nl_type_elements'],$tab_config_values['CMFR__nl_nb_elements'],$tab_config_values['CMFR__nl_order_elements']);	
	$oNLElementsContentWrapperTop = $tab_config_values['CMFR__wrapper_top_nl'];
	$oNLElementsContentWrapperBottom = $tab_config_values['CMFR__wrapper_bottom_nl'];
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
						if($tab_config_values['CMFR__nl_image'] == 1 && $line['img'] != '' && !strpos($line['img'],'default.png') ){
							$return_html .= '<td colspan="2">';
						}else{
							$return_html .= '<td>';
						}
							$return_html .= '<span style="'.$style_title.'">'.$line['name'].' - '.transFromISOToDate($line['date'],$tab_config_values['CMFR__api_date_lang']).'</span>';
						$return_html .= '</td>';
					$return_html .= '</tr>';


					if($tab_config_values['CMFR__nl_link'] == 1){
						// que si le lien est activé
						$return_html_link = '<br /><a href="'.$line['link'].'" target="_blank" style="'.$style_link.'">'.$tab_config_values['CMFR__nl_link_defaulttext'].'</a>';
					}else{
						$return_html_link = '';
					}
						
					$return_html .= '<tr>';
						if($tab_config_values['CMFR__nl_image'] == 1 && $line['img'] != '' && !strpos($line['img'],'default.png') ){
							$return_html .= '<td><img src="'.$line['img'].'" /></td>';
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
							if($tab_config_values['CMFR__nl_image'] == 1 && $line['img'] != '' && !strpos($line['img'],'default.png') ){
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
										$html .= ' (' . transFromISOToDate($comment->comment_date_gmt,$tab_config_values['CMFR__api_date_lang']) . ')';
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
				
				
				
				
				$return_txt .= "\r\n\r\n".$line['name']." (".transFromISOToDate($line['date'],$tab_config_values['CMFR__api_date_lang']).")\r\n";
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
								$txt .= $comment->comment_author . ' (' . transFromISOToDate($comment->comment_date_gmt,$tab_config_values['CMFR__api_date_lang']) . ") \r\n";
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


		// on gère la page mirroir
			$mirror = '';
			$mirror .= $tab_config_values['CMFR__mirror_text_top'];
			$mirror .= '<a href="$H(1)" target="_blank">'.$tab_config_values['CMFR__mirror_text_link'].'</a>';
			$mirror .= $tab_config_values['CMFR__mirror_text_bottom'];
			
		// VARIABLES FINALES DE LA NL
		$_wishdate=date('Y-m-d').'T'.date('H:i:s');
		$_wishdate_temp = '0001-01-01T00:00:00';
		
		if($_GET['type'] == "send"){
			$_name = $tab_config_values['CMFR__prefix_nl'] . 'Newsletter : ' . transFromISOToDate($_wishdate,$tab_config_values['CMFR__api_date_lang']);
		}
		else {
			$_name = $tab_config_values['CMFR__prefix_nl'] . ' Newsletter : ' . transFromISOToDate($_wishdate,$tab_config_values['CMFR__api_date_lang']). ' (TEST)';
		}
	
		$_name = $tab_config_values['CMFR__prefix_nl'] . 'Newsletter : ' . transFromISOToDate($_wishdate,$tab_config_values['CMFR__api_date_lang']);
		$_config = $oConfig;
		$_target = $oTarget;
		$_subject = $oSubject;
		$_format = 3;
		$_ea = 0;
		$_html_body = $oNLElementsContentWrapperTop . $return_html . $oNLElementsContentWrapperBottom;
		$_txt_body = htmlentities(strip_tags($oNLElementsContentWrapperTop . $return_html . $oNLElementsContentWrapperBottom));	
		// ENVOI DE LA NL
		
		
		// on met la camp en etat préparation
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


		
		if($_GET['type'] == "send"){
			update_option('CMFR__nl_date_last_sent',$_wishdate);
		}
		else {
			// on ne met pas à jour l'option car bat
		}
		header('HTTP/1.1 200 OK');	
		echo 0;
	}
	else
	{
		// pas d'elements
		header('HTTP/1.1 200 OK');	
		echo -1;
	}	
?>