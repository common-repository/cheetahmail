<?php
	// on inclue les API
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
	$oFrequency = $tab_config_values['CMFR__nl_frequency'];
	
	$oNlTop = $tab_config_values['CMFR__wrapper_top_nl'];
	$oNlBottom = $tab_config_values['CMFR__wrapper_bottom_nl'];
	
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	
	$oNLElementsInfos = $MyEMST->getListPagesForNL($tab_config_values['CMFR__nl_date_last_sent'],$tab_config_values['CMFR__nl_type_elements'],$tab_config_values['CMFR__nl_nb_elements'],$tab_config_values['CMFR__nl_order_elements']);	
	$oNLElementsConfig = $MyEMST->GetConfigById($oConfig);
	$html_header = $oNLElementsConfig->htmlHeader;	if($html_header == "-2"){$html_header = '';}
	$txt_header = $oNLElementsConfig->txtHeader; 	if($txt_header == "-2"){$txt_header = '';}
	$html_footer = $oNLElementsConfig->htmlFooter;	if($html_footer == "-2"){$html_footer = '';}
	$txt_footer = $oNLElementsConfig->txtFooter;	if($txt_footer == "-2"){$txt_footer = '';}
	$html_unsubs = $oNLElementsConfig->htmlUnsubs;	if($html_unsubs == "-2"){$html_unsubs = '';}
	$txt_unsubs = $oNLElementsConfig->txtUnsubs;	if($txt_unsubs == "-2"){$txt_unsubs = '';}
		
	$oNLElementsContentTxt = $tab_config_values['CMFR__txt_nl'];
	$oNLElementsContentHtml = $tab_config_values['CMFR__html_nl'];
	$delay = 0;
	$return_txt = '';
	$counter_elt = 0;
	$limit_elt = $tab_config_values['CMFR__nl_nb_elements'];

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
	// si on doit faire un envoi
	if(floor(((transToTimeStamp($now) - transToTimeStamp($oLastNLSent)) / 3600) /24) > $delay || (!empty($oNLElementsInfos) && count($oNLElementsInfos)>0) )
	{
		// le délai d'envoi est dépassé il faut essayer de pousser une NL

		
		// si on a bien des resultats 
		if(!empty($oNLElementsInfos) && count($oNLElementsInfos)>0)
		{		
			if($_GET['type'] == 'html') 	// si on veut l'html
			{
			// ON AJOUTE LE HEADER
				$return_txt .= $MyEMST->getPreviewContent($html_header);
				$return_txt .= $MyEMST->getPreviewContent($oNLElementsContentHtml);			
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
				

				$return_txt .= $MyEMST->getPreviewContent($oNlTop);
				// plusieurs resultats
				foreach($oNLElementsInfos as $line)
				{
					if( $counter_elt < $limit_elt){ 
						$return_txt .= '<table width=100%" cellpadding="5" cellspacing="0" border="0">';			
							$return_txt .= '<tr>';
								if($tab_config_values['CMFR__nl_image'] == 1 ){
									$return_txt .= '<td colspan="2">';
								}else{
									$return_txt .= '<td>';
								}
									$return_txt .= '<span style="'.$style_title.'">'.$line['name'].' - '.transFromISOToDate($line['date']).'</span>';
								$return_txt .= '</td>';
							$return_txt .= '</tr>';


							if($tab_config_values['CMFR__nl_link'] == 1){
								// que si le lien est activé
								$return_txt_link = '<br /><a href="'.$line['link'].'" target="_blank" style="'.$style_link.'"> '.$tab_config_values['CMFR__nl_link_defaulttext'].'</a>';
							}else{
								$return_txt_link = '';
							}
								
							$return_txt .= '<tr>';
								if($tab_config_values['CMFR__nl_image'] == 1  ){
									if($tab_config_values['CMFR__nl_image'] == 1  && $line['img'] != "" ){
									$return_txt .= '<td width="20%" align="center"><img src="'.$line['img'].'" /></td>';
									}else{
									$return_txt .= '<td width="100" align="center"><img src="../img/_big_default_img.png" /></td>';
									}
									$return_txt .= '<td>';
									$return_txt .= '<span style="'.$style_content.'">'.substr(strip_tags($line['content']),0,400).'</span>';
									$return_txt .= $return_txt_link;
									$return_txt .= '</td>';
								}else{
									$return_txt .= '<td colspan="2">';
									$return_txt .= '<span style="'.$style_content.'">'.substr(strip_tags($line['content']),0,400).'</span>';
									$return_txt .= $return_txt_link;
									$return_txt .= '</td>';
								}						
								
							$return_txt .= '</tr>';
							
							if($tab_config_values['CMFR__nl_coment'] > 0 ){
								$return_txt .= '<tr>';
									$return_txt .= '<td ';
									if($tab_config_values['CMFR__nl_image'] == 1 ){
										$return_txt .= ' colspan="2" ';	
									}
									$return_txt .= '>';
									
									// on récupère les commentaires
									$comments = get_comments('post_id='.$line['id'],'number=' . $tab_config_values['CMFR__nl_coment']);
									
									if(count($comments)>0){
										foreach($comments as $comment){
											$txt = '';
											if(strlen($comment->comment_author)>0)
											{
												$txt .= '<div style="'.$style_coment.'">';
												$txt .= '<strong>' . $comment->comment_author . '</strong>';
												$txt .= ' (' . transFromISOToDate($comment->comment_date_gmt) . ')';
												$txt .= '<br />';
												$txt .= $comment->comment_content;
												$txt .= '<br /><br />';
												$txt .= '</div>';
												$return_txt .=  $txt;
											}
										}								
									}
									$return_txt .= '</td>';
								$return_txt .= '</tr>';	
							}
							$return_txt .= '<tr>';
								$return_txt .= '<td height="10">&nbsp;</td>';
							$return_txt .= '</tr>';						
						$return_txt .= '</table>';
						$counter_elt++;
					}
					else{
						// on a atteint la limite d'elements
					}
				
				}				
				$return_txt .= $MyEMST->getPreviewContent($oNlBottom);
				$return_txt .= $MyEMST->getPreviewContent($html_footer);
				$return_txt .= $MyEMST->getPreviewContent($html_unsubs);
				header('HTTP/1.1 200 OK');
				echo $return_txt;
			}
			else if($_GET['type'] == 'txt') 	// si on veut le txt
			{
				
				// on inclue le header
				$return_txt .= $MyEMST->getPreviewContent($txt_header) . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($oNLElementsContentTxt) . "\r\n";	

				// plusieurs resultats
				foreach($oNLElementsInfos as $line){
					if( $counter_elt <= $limit_elt){ 
						$return_txt .= "\r\n\r\n".$line['name']."\r\n".transFromISOToDate($line['date'])."\r\n";
						$return_txt .= substr(strip_tags($line['content']),0,400)."\r\n";
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
						$counter_elt++;
					}
					else{
						// on a atteint la limite d'elements
					}
				}				
				
				// on inclue le footer
				$return_txt .= $MyEMST->getPreviewContent($txt_footer) . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($txt_unsubs);
				header('HTTP/1.1 200 OK');	
				echo nl2br(htmlentities(strip_tags($return_txt)));
			}	
		}
		else
		{			
			if($_GET['type'] == 'html')
			{
				$return_txt .= $MyEMST->getPreviewContent($html_header) . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($html_footer) . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($html_unsubs);
				header('HTTP/1.1 200 OK');	
				echo $return_txt;
			}
			else if($_GET['type'] == 'txt') 
			{
				$return_txt .= $MyEMST->getPreviewContent($txt_header) . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($txt_footer) . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($txt_unsubs);	
				header('HTTP/1.1 200 OK');	
				echo nl2br(htmlentities(strip_tags($return_txt)));			
			}
		}	
	}else{
		 // pas d'envoi à faire il est trop tôt et il n'y a aucun element : NL vide !!
			if($_GET['type'] == 'html')
			{
				$return_txt .= $MyEMST->getPreviewContent($html_header) . "\r\n";
				$return_txt .= '<p><img src="../img/error.png" />' . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($html_footer) . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($html_unsubs);
				header('HTTP/1.1 200 OK');	
				echo $return_txt;
			}
			else if($_GET['type'] == 'txt') 
			{
				$return_txt .= $MyEMST->getPreviewContent($txt_header) . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($txt_footer) . "\r\n";
				$return_txt .= $MyEMST->getPreviewContent($txt_unsubs);	
				header('HTTP/1.1 200 OK');	
				echo nl2br(htmlentities(strip_tags($return_txt)));			
			}			
	}			
?>