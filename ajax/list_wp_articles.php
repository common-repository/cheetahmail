<?php
	require('../../../../wp-blog-header.php');
	include('../fn/fn.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['api_idmlist'];
	$oLogin = $tab_config_values['api_login'];
	$oPassword = $tab_config_values['api_password'];
	$txt_return = '';	
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	// n articles
	$oArticles_wp = $MyEMST->getListPagesforEditor();
	
	foreach( $oArticles_wp as $page )
	{
		
		$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($page['id']),'thumbnail', true);
		$url_img = $image_url[0];
			
			
			
			
			
			
		$txt_return_full = '';
		$txt_return_full .=  '<table border="0" cellpadding="10">';
		
			$txt_return_full .=  '<tr>';
				$txt_return_full .=  '<td ';
				if(strlen($url_img) > 1){
					$txt_return_full .=  'colspan="2"';
				}
				$txt_return_full .=  '>';
					$txt_return_full .= $page['name'];
				$txt_return_full .=  '</td>';
			$txt_return_full .=  '</tr>';
			
			$txt_return_full .=  '<tr>';
				if(strlen($url_img) > 1){
					$txt_return_full .=  '<td>';
						$txt_return_full .=  '<img src="' . $url_img .'" />';
					$txt_return_full .=  '</td>';
				}
				$txt_return_full .=  '<td>';
					$txt_return_full .= $page['content'];
					$txt_return_full .= '<br />';
					$txt_return_full .= $page['date'] ;
				$txt_return_full .= '</td>';
			$txt_return_full .=  '</tr>';
			
		$txt_return_full .=  '</table>';	
			





			
		$txt_return .= '<div class="element_wp_to_add ';
		if($page['date'] == 0){
			// page
			$txt_return .= 'i_page';
		}else{
			// post
			$txt_return .= 'i_post';
		}
		$txt_return .= '" id="'. $page['id'] .'">';
		
			$txt_return .=  '<table border="0" cellpadding="10">';
			
				$txt_return .=  '<tr>';
					$txt_return .=  '<td ';
					if(strlen($url_img) > 1){
						$txt_return .=  'colspan="2"';
					}
					$txt_return .=  '>';
						$txt_return .= '<strong>' . $page['name'] . '</strong>';
					$txt_return .=  '</td>';
				$txt_return .=  '</tr>';

				$txt_return .=  '<tr>';
					if(strlen($url_img) > 1){
						$txt_return .=  '<td>';
							$txt_return .=  '<img src="' . $url_img .'" />';
						$txt_return .=  '</td>';
					}
					$txt_return .=  '<td valign="top">';
						$txt_return .= substr(strip_tags($page['content']),0,100);
						$txt_return .= '<br />';
						$txt_return .= '<span class="note"> ' . $page['date'] .'</span>' ;
					$txt_return .= '</td>';

			$txt_return .=  '</table>';
			$txt_return .=  '<input type="hidden" class="full_content" value="' . htmlspecialchars($txt_return_full) . '" />';
		$txt_return .= '</div>';
		
	}
	
	header('HTTP/1.1 200 OK');		
	echo $txt_return;
?>