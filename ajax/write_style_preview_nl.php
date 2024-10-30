<?php
	// on inclue les constantes & le FWK WP
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();

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

	$return_html .= '<table width=100%" cellpadding="5" cellspacing="0" border="0">';			
		$return_html .= '<tr>';
			if($tab_config_values['CMFR__nl_image'] == 1 ){
				$return_html .= '<td colspan="2">';
			}else{
				$return_html .= '<td>';
			}
				$return_html .= '<span style="'.$style_title.'"> Lorem ipsum - DATE</span>';
			$return_html .= '</td>';
		$return_html .= '</tr>';


		if($tab_config_values['CMFR__nl_link'] == 1){
			// que si le lien est activé
			$return_html_link = '<br /><a href="#" target="_blank" style="'.$style_link.'">'.$tab_config_values['CMFR__nl_link_defaulttext'].'</a>';
		}else{
			$return_html_link = '';
		}
			
		$return_html .= '<tr>';
			if($tab_config_values['CMFR__nl_image'] == 1 ){
				$return_html .= '<td><img src="../wp-content/plugins/cheetahmail/img/_big_default_img.png" /></td>';
				$return_html .= '<td>';
					$return_html .= '<span style="'.$style_content.'">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget dolor dolor. Vivamus eget risus ut lacus vehicula consequat. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec et elit sed eros molestie cursus. Nam velit tellus, ultricies ut aliquam et, tristique a magna. Proin ac semper velit. Etiam turpis arcu, cursus a dictum nec, suscipit et nullam. </span>';
					$return_html .= $return_html_link;
				$return_html .= '</td>';
			}else{
				$return_html .= '<td colspan="2">';
					$return_html .= '<span style="'.$style_content.'">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget dolor dolor. Vivamus eget risus ut lacus vehicula consequat. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec et elit sed eros molestie cursus. Nam velit tellus, ultricies ut aliquam et, tristique a magna. Proin ac semper velit. Etiam turpis arcu, cursus a dictum nec, suscipit et nullam. </span>';
					$return_html .= $return_html_link;
				$return_html .= '</td>';
			}						
			
		$return_html .= '</tr>';
		
		if($tab_config_values['CMFR__nl_coment'] > 0 ){
			$return_html .= '<tr>';
				$return_html .= '<td ';
				if($tab_config_values['CMFR__nl_image'] == 1 ){
					$return_html .= ' colspan="2" ';	
				}
				$return_html .= '>';							
					$return_html .= '<div style="'.$style_coment.'">';
						$return_html .= '<strong>AUTHOR</strong> (DATE)';
						$return_html .= '<br />';
						$return_html .= 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ';
						$return_html .= '<br /><br />';
					$return_html .= '</div>';							
				$return_html .= '</td>';
			$return_html .= '</tr>';	
		}
		$return_html .= '<tr>';
			$return_html .= '<td height="10">&nbsp;</td>';
		$return_html .= '</tr>';						
	$return_html .= '</table>';
	
	
	
	
	$return_txt .= "Lorem ipsum (DATE)\r\n\r\n";
	$return_txt .= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget dolor dolor. Vivamus eget risus ut lacus vehicula consequat. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec et elit sed eros molestie cursus. Nam velit tellus, ultricies ut aliquam et, tristique a magna. Proin ac semper velit. Etiam turpis arcu, cursus a dictum nec, suscipit et nullam. \r\n";
	if($tab_config_values['CMFR__nl_link'] == 1){
		// que si le lien est activé
		$return_txt .= "LINK \r\n\r\n";
	}
						
	$return_txt .=  "\r\n";
	if($tab_config_values['CMFR__nl_coment'] > 0 ){
		$return_txt .= "AUTHOR (DATE) \r\n";
		$return_txt .= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. \r\n\r\n";
	}	





	header('HTTP/1.1 200 OK');	
	echo '<h4 class="title_alone">HTML VERSION</h4>';
	echo $return_html;
	echo '<h4 class="title_alone">TXT VERSION</h4>';
	echo '<p>' . nl2br($return_txt).'</p>';
?>