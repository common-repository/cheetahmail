<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oDkimId = $tab_config_values['CMFR__api_dkim_id'];
	$oDkimLabel = $tab_config_values['CMFR__api_dkim_label'];
	// recup ids configs
	$oSubsConfig = $tab_config_values['CMFR__idconf_subs'];
	$oUnsubsConfig = $tab_config_values['CMFR__idconf_unsubs'];
	$oNLConfig = $tab_config_values['CMFR__idconf_nl'];
	$oCampaignConfig = $tab_config_values['CMFR__idconf_campaign'];
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
		
	// on instancie notre client
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);

	// on est ok sur les params
	$def_bdd = $MyEMST->testConnexion();
	// les soap fonctionnent tous	
	$return_txt = '';	
	if( $def_bdd == 1){
	
	$oSubsConfig = $tab_config_values['CMFR__idconf_subs'];
	$oUnsubsConfig = $tab_config_values['CMFR__idconf_unsubs'];
	$oNLConfig = $tab_config_values['CMFR__idconf_nl'];
	$oCampaignConfig = $tab_config_values['CMFR__idconf_campaign'];
		

		if($_GET['type'] == 1)
		{
			$html = $tab_config_values['CMFR__html_subs'];
			$txt = $tab_config_values['CMFR__txt_subs'];
			$subject = $tab_config_values['CMFR__subject_subs'];
			$oConfigsInfos = $MyEMST -> GetConfigById($oSubsConfig);
		}
		else if($_GET['type'] == 2)
		{
			$html = $tab_config_values['CMFR__html_unsubs'];
			$txt = $tab_config_values['CMFR__txt_unsubs'];
			$subject = $tab_config_values['CMFR__subject_unsubs'];
			$oConfigsInfos = $MyEMST -> GetConfigById($oUnsubsConfig);
		}
		else if($_GET['type'] == 3)
		{
			$html = $tab_config_values['CMFR__wrapper_top_nl'];		// il s'agit du wrapper top NL
			$txt = $tab_config_values['CMFR__wrapper_bottom_nl'];	// il s'agit du wrapper bottom NL
			$subject = $tab_config_values['CMFR__subject_nl'];
			$oConfigsInfos = $MyEMST -> GetConfigById($oNLConfig);
		}
		else if($_GET['type'] == 4)
		{
			$html = $tab_config_values['CMFR__html_email'];
			$txt = $tab_config_values['CMFR__txt_email'];
			$subject = $tab_config_values['CMFR__subject_email'];
			$oConfigsInfos = $MyEMST -> GetConfigById($oCampaignConfig);
		}


$return_txt .= '<div class="filter-menu-container">';
	
	$return_txt .= '<ul class="filter-menu frequencies-filter heading">';
			
		$return_txt .= '<li class="heading_elt active" id="elt_1"><img src="../wp-content/plugins/cheetahmail/img/_icon_envelop.png" />  '.strtoupper($oResources->rsc_submenu_envelop).'</li>';
		$return_txt .= '<li class="heading_elt" id="elt_2"><img src="../wp-content/plugins/cheetahmail/img/_icon_header.png" /> '.strtoupper($oResources->rsc_submenu_header).'</li>';
		if($_GET['type'] == 3){
		$return_txt .= '<li class="heading_elt" id="elt_3"><img src="../wp-content/plugins/cheetahmail/img/_icon_body.png" /> '.strtoupper($oResources->rsc_submenu_wrapper).'</li>';
		}else{
		$return_txt .= '<li class="heading_elt" id="elt_3"><img src="../wp-content/plugins/cheetahmail/img/_icon_body.png" /> '.strtoupper($oResources->rsc_submenu_body).'</li>';
		}
		$return_txt .= '<li class="heading_elt" id="elt_4"><img src="../wp-content/plugins/cheetahmail/img/_icon_footer.png" /> '.strtoupper($oResources->rsc_submenu_footer).'</li>';
		if($_GET['type'] >2){
		$return_txt .= '<li class="heading_elt" id="elt_5"><img src="../wp-content/plugins/cheetahmail/img/_icon_unsubscribe.png" /> '.strtoupper($oResources->rsc_submenu_unsubs).'</li>';
			}
		if($_GET['type'] == 1 || $_GET['type'] == 2)
		{
			$return_txt .= '<li class="heading_elt" id="elt_0"><img src="../wp-content/plugins/cheetahmail/img/_icon_preview.png" /> '.strtoupper($oResources->rsc_submenu_preview).'</li>';
		}
	
	$return_txt .= '</ul>';								
$return_txt .= '</div>';



$return_txt .= '<div class="list-container" id="listContainer">';


	if($_GET['type'] == 1)
	{
		$return_txt .= '<div id="referred_0" class="toggelize" style="display:none">';	
				$return_txt .= '<div id="return_preview_subs"></div>';		
		$return_txt .= '</div>';
	}
	else if($_GET['type'] == 2)
	{
		$return_txt .= '<div id="referred_0" class="toggelize" style="display:none">';	
				$return_txt .= '<div id="return_preview_unsubs"></div>';		
		$return_txt .= '</div>';
	}


				
	$return_txt .= '<div id="referred_1" class="toggelize">';
	
		
		 


		$return_txt .= '<p>';
			$return_txt .= '<label for="ws_from">'.$oResources->rsc_config_from.' <span class="required"> *</span></label>';
			$return_txt .= '<input class="tipsyer" original-title="'.$oResources->rsc_config_tooltip_from.'" type="text" id="ws_from" tabindex="1" value="'.htmlspecialchars($oConfigsInfos -> mailFrom).'" />';
		$return_txt .= '</p>'; 
		
		$return_txt .= '<p>';
			$return_txt .= '<label for="ws_mailfromaddr">'.$oResources->rsc_config_emailfrom.' <span class="required"> *</span></label>';
			// $return_txt .= ' <span class="decoration">@ ' . $oDkimLabel . '</span> ';
			
			$return_txt .= ' <input class="decoration mini" disabled="disabled" type="text" value="'.$oDkimLabel.'"  />';
			$return_txt .= ' <span class="decoration"> @ </span> ';
			$return_txt .= '<input class="tipsyer mini" original-title="'.$oResources->rsc_config_tooltip_emailfrom.'" type="text" id="ws_mailfromaddr" tabindex="2"  value="'.$oConfigsInfos -> mailFromAddr.'"  />';
			
		$return_txt .= '</p>'; 		

	
		$return_txt .= '<p>';
			$return_txt .= '<label for="ws_mailnpai">'.$oResources->rsc_config_npai.' <span class="required"> *</span></label>';
			$return_txt .= '<input class="tipsyer"  original-title="'.$oResources->rsc_config_tooltip_npai.'" type="text" id="ws_mailnpai" tabindex="3"  value="'.$oConfigsInfos -> mailRetNpai.'" />';
		$return_txt .= '</p>';  		
	
	
	
		$return_txt .= '<p>';
			$return_txt .= '<label for="ws_mailreply">'.$oResources->rsc_config_emailreply.' <span class="required"> *</span></label>';
			$return_txt .= '<input class="tipsyer"  original-title="'.$oResources->rsc_config_tooltip_emailreply.'" type="text" id="ws_mailreply" tabindex="4"  value="'.$oConfigsInfos -> mailReply.'" />';
		$return_txt .= '</p>';  		


		
		$return_txt .= '<p>';
			$return_txt .= '<label for="ws_subject">'.$oResources->rsc_config_subject.' <span class="required"> *</span></label>';
			$return_txt .= '<input class="tipsyer" type="text" original-title="'.$oResources->rsc_config_tooltip_subject.'" tabindex="5"  id="ws_subject" value="'.htmlspecialchars($subject).'" />';
			if($_GET['type'] == 3){
				// if nl 
				$return_txt .= '<br /><em>'.$oResources->rsc_config_date_sentence.'</em>';
			}
			
		$return_txt .= '</p>';  
		
		// bouton soumission
		$return_txt .= '<p>';
			$return_txt .= '<span class="valid"><input class="validation" type="button" value="'.$oResources->rsc_btn_update.'" id="submit_conf"  title="'.$_GET['type'].'" /></span>';
		$return_txt .= '</p>';	
	
	$return_txt .= '</div>';
	
	
	
	
	
	
	
	
	
	
	
	

	$return_txt .= '<div id="referred_2" style="display:none" class="toggelize">';
	
		$return_txt .= '<div class="alternate_style_full">';
			$return_txt .= '<p><label for="ws_html_header_'.$_GET['type'].'" class="full">'.$oResources->rsc_config_html_header.'</label></p>';
			$return_txt .= '<textarea class="half rich-editor ws_html_header" tabindex="6" id="ws_html_header_'.$_GET['type'].'" name="ws_html_header_'.$_GET['type'].'">'.$oConfigsInfos -> htmlHeader.'</textarea>';
		$return_txt .= '</div>';   

		$return_txt .= '<p><span class="valid"><input type="button" class="load" value="'.$oResources->rsc_config_htmltotxt.'" id="generate_txt_config_header"></span></p>';
		$return_txt .= '<p class="alternate_style_full">';
				$return_txt .= '<label for="ws_txt_header" class="full">';
					$return_txt .= $oResources->rsc_config_txt_header;
				$return_txt .= '</label>';
			$return_txt .= '<textarea class="half" tabindex="7" id="ws_txt_header">'.$oConfigsInfos -> txtHeader.'</textarea>';
		$return_txt .= '</p>'; 
		
		// bouton soumission
		$return_txt .= '<p>';
			$return_txt .= '<span class="valid"><input class="validation" type="button" value="'.$oResources->rsc_btn_update.'" id="submit_conf"  title="'.$_GET['type'].'" /></span>';
		$return_txt .= '</p>';	
		
	$return_txt .= '</div>';	
		
	// sous nav
		
	$return_txt .= '<div id="referred_3" style="display:none" class="toggelize">';	
	if($_GET['type'] == 3){
		// mode NL on 
		$return_txt .= '<p class="alternate_style_full">';
			$return_txt .= '<label for="ws_html_nl_top" class="full">';
				$return_txt .= $oResources->rsc_config_wrapper_top;
			$return_txt .= '</label>';		
			$return_txt .= '<textarea class="half ws_html_body" tabindex="8" id="ws_html_body"  readonly="readonly" name="ws_html_body_'.$_GET['type'].'">'.$html.'</textarea>';
		$return_txt .= '</p>'; 		

		$return_txt .= '<p class="alternate_style_full">';
			$return_txt .= '<label for="ws_txt_body">';
				$return_txt .= $oResources->rsc_config_wrapper_bottom;
			$return_txt .= '</label>';
			$return_txt .= '<textarea class="half" readonly="readonly" tabindex="9" id="ws_txt_body">'.$txt.'</textarea>';
		$return_txt .= '</p>'; 		
	}else{
	// mode normal
		$return_txt .= '<div class="alternate_style_full">';
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_html_body_'.$_GET['type'].'" class="full">';
					$return_txt .= $oResources->rsc_config_body_html .'<span class="required"> *</span>';
				$return_txt .= '</label>';
			$return_txt .= '</p>';
		
			$return_txt .= '<textarea class="half rich-editor ws_html_body" tabindex="8" id="ws_html_body_'.$_GET['type'].'"  name="ws_html_body_'.$_GET['type'].'">'.$html.'</textarea>';
		$return_txt .= '</div>'; 	

		$return_txt .= '<p><span class="valid"><input type="button" class="load" value=" '.$oResources->rsc_config_htmltotxt .'" id="generate_txt_config_body"></span></p>';			

		$return_txt .= '<p class="alternate_style_full">';
			$return_txt .= '<label for="ws_txt_body">';
				$return_txt .= $oResources->rsc_config_body_txt .' <span class="required"> *</span>';
			$return_txt .= '</label>';
			$return_txt .= '<textarea class="half" tabindex="9" id="ws_txt_body">'.$txt.'</textarea>';
		$return_txt .= '</p>'; 
	}		
		// bouton soumission
		$return_txt .= '<p>';
			$return_txt .= '<span class="valid"><input class="validation" type="button" value="'.$oResources->rsc_btn_update.'" id="submit_conf"  title="'.$_GET['type'].'" /></span>';
		$return_txt .= '</p>';	

	$return_txt .= '</div>';					
		
		
	

	$return_txt .= '<div id="referred_4" style="display:none" class="toggelize">';	

		$return_txt .= '<p class="alternate_style_full">';
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_html_footer_'.$_GET['type'].'" class="full">';
					$return_txt .= $oResources->rsc_config_html_footer;
				$return_txt .= '</label>';
			$return_txt .= '</p>';
			$return_txt .= '<textarea class="tipsyer half rich-editor ws_html_footer" original-title="10" tabindex="10" id="ws_html_footer_'.$_GET['type'].'"  name="ws_html_footer_'.$_GET['type'].'">'.$oConfigsInfos -> htmlFooter.'</textarea>';
		$return_txt .= '</p>'; 	

		$return_txt .= '<p><span class="valid"><input type="button" class="load" value="Generate TXT from HTML" id="generate_txt_config_footer"></span></p>';
				
		$return_txt .= '<p class="alternate_style_full">';
			$return_txt .= '<label for="ws_txt_footer">'.$oResources->rsc_config_txt_footer.'</label>';
			$return_txt .= '<textarea class="tipsyer half" original-title="11" tabindex="11" id="ws_txt_footer">'.$oConfigsInfos -> txtFooter.'</textarea>';
		$return_txt .= '</p>'; 
		
		// bouton soumission
		$return_txt .= '<p>';
			$return_txt .= '<span class="valid"><input class="validation" type="button" value="'.$oResources->rsc_btn_update.'" id="submit_conf"  title="'.$_GET['type'].'" /></span>';
		$return_txt .= '</p>';	
	$return_txt .= '</div>';


	if($tab_config_values['CMFR__url_desabo'] == ''){
		$uri = '$H(2)';
	}else{
		$uri = $tab_config_values['CMFR__url_desabo'];
	}
	
		
	

	$link_html = $tab_config_values['CMFR__unsubs_text_top'].'<a href="'.$uri.'" target="_blank">'.$tab_config_values['CMFR__unsubs_text_link'].'</a>'.$tab_config_values['CMFR__unsubs_text_bottom'];
	
	$link_txt = strip_tags($tab_config_values['CMFR__unsubs_text_top']).' ' . $uri .' ' . $tab_config_values['CMFR__unsubs_text_link'] .' ' . strip_tags($tab_config_values['CMFR__unsubs_text_bottom']);
	
	$return_txt .= '<div id="referred_5" style="display:none" class="toggelize">';	

			$return_txt .= '<h4 class="title_alone">';
			$return_txt .= $oResources->rsc_config_html_unsubs;
			$return_txt .= '</h4>';
			$return_txt .= '<div>'.$link_html.'</div>';

			$return_txt .= '<h4 class="title_alone">';
			$return_txt .= $oResources->rsc_config_txt_unsubs;
			$return_txt .= '</h4>';
			$return_txt .= '<div>'.$link_txt.'</div>';
		
	$return_txt .= '</div>';

	
	
	
	
	$return_txt .= '<div class="loading_temp_maj" style="display:none"><span class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></span></div>';

$return_txt .= '</div>';




		} // fin abo
		// on ramene le contenu
		header('HTTP/1.1 200 OK');	
		echo $return_txt;
?>