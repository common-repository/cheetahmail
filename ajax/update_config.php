<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oDkimName = $tab_config_values['CMFR__api_dkim_label'];
	$r = array();
	if($_POST['type'] == 1){
		$oConfig = $tab_config_values['CMFR__idconf_subs'];
		$oConfig_n = CONFIG_SUBS_NAME;
	}else if($_POST['type'] == 2){
		$oConfig = $tab_config_values['CMFR__idconf_unsubs'];
		$oConfig_n = CONFIG_UNSUBS_NAME;
	}else if($_POST['type'] == 3){
		$oConfig = $tab_config_values['CMFR__idconf_nl'];
		$oConfig_n = CONFIG_NL_NAME;			
	}else if($_POST['type'] == 4){
		$oConfig = $tab_config_values['CMFR__idconf_campaign'];
		$oConfig_n = CONFIG_EMAILING_NAME;
	}
	// on instancie notre client
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);			
	if(
	( isset($_POST['ws_from']) && strlen($_POST['ws_from'])>0) &&
	( isset($_POST['ws_mailfromaddr']) && strlen($_POST['ws_mailfromaddr'])>0 ) &&
	strpos($_POST['ws_mailfromaddr'],'@')===false &&
	( isset($_POST['ws_mailnpai']) && strlen($_POST['ws_mailnpai'])>0 ) &&
	filter_var($_POST['ws_mailnpai'],FILTER_VALIDATE_EMAIL,array()) &&	
	( isset($_POST['ws_mailreply']) && strlen($_POST['ws_mailreply'])>0 ) &&
	filter_var($_POST['ws_mailreply'],FILTER_VALIDATE_EMAIL,array()) &&		
	( isset($_POST['ws_subject']) && strlen($_POST['ws_subject'])>0 ) &&
	isset($_POST['ws_html_header'])&&
	isset($_POST['ws_txt_header']) &&
	( isset($_POST['ws_html_body']) && strlen($_POST['ws_html_body'])>0 ) &&
	( isset($_POST['ws_txt_body']) && strlen($_POST['ws_txt_body'])>0 ) &&
	isset($_POST['ws_html_footer']) &&
	isset($_POST['ws_txt_footer'])		
	)
	{
		if($_POST['type']>2) {
		
			if($tab_config_values['CMFR__url_desabo'] == ''){
				$uri = '$H(2)';
			}else{
				$uri = $tab_config_values['CMFR__url_desabo'];
			}
			$link_html = stripslashes($MyEMST->TrackHTMLLinks($tab_config_values['CMFR__unsubs_text_top'].'<a href="'.$uri.'" target="_blank">'.$tab_config_values['CMFR__unsubs_text_link'].'</a>'.$tab_config_values['CMFR__unsubs_text_bottom'],true));			
			$link_txt = stripslashes($MyEMST->TrackHTMLLinks(strip_tags($tab_config_values['CMFR__unsubs_text_top']).' ' . $uri .' ' . $tab_config_values['CMFR__unsubs_text_link'] .' ' . strip_tags($tab_config_values['CMFR__unsubs_text_bottom']),false));
		}else{
			$link_html = ''; 
			$link_txt = '';
		}	


		$html_header = str_replace('&quot;','"',stripslashes($MyEMST->TrackHTMLLinks($_POST['ws_html_header'],true)));
		$html_footer = str_replace('&quot;','"',stripslashes($MyEMST->TrackHTMLLinks($_POST['ws_html_footer'],true)));
		$txt_header = str_replace('&quot;','"',stripslashes($MyEMST->TrackHTMLLinks($_POST['ws_txt_header'],false)));
		$txt_footer = str_replace('&quot;','"',stripslashes($MyEMST->TrackHTMLLinks($_POST['ws_txt_footer'],false)));
		
		if($html_header == "-2"){$html_header = '';}
		if($html_footer == "-2"){$html_footer = '';}
		if($txt_header == "-2"){$txt_header = '';}
		if($txt_footer == "-2"){$txt_footer = '';}
		
		// on maj la conf
		 $res = $MyEMST->UpdateConfigs(
			$oIdlist,
			$oConfig,
			$oConfig_n,
			stripslashes($_POST['ws_from']), 
			$_POST['ws_mailfromaddr'].'@'.$oDkimName,
			$_POST['ws_mailnpai'],
			$_POST['ws_mailreply'],
			$link_html,
			$link_txt,
			$html_footer,
			$txt_footer,
			$html_header,
			$txt_header
			);
		// on met à jour les fichiers html sur le serveur
		if($_POST['type'] == 1){
			update_option('CMFR__subject_subs',str_replace('&quot;','"',stripslashes($_POST['ws_subject'])));
			update_option('CMFR__html_subs',str_replace('&quot;','"',stripslashes($_POST['ws_html_body'])));
			update_option('CMFR__txt_subs',str_replace('&quot;','"',stripslashes($_POST['ws_txt_body'])));
		}else if($_POST['type'] == 2){
			update_option('CMFR__subject_unsubs',str_replace('&quot;','"',stripslashes($_POST['ws_subject'])));
			update_option('CMFR__html_unsubs',str_replace('&quot;','"',stripslashes($_POST['ws_html_body'])));
			update_option('CMFR__txt_unsubs',str_replace('&quot;','"',stripslashes($_POST['ws_txt_body'])));
		}else if($_POST['type'] == 3){
			update_option('CMFR__subject_nl',str_replace('&quot;','"',stripslashes($_POST['ws_subject'])));
			update_option('CMFR__wrapper_top_nl',str_replace('&quot;','"',stripslashes($_POST['ws_html_body'])));
			update_option('CMFR__wrapper_bottom_nl',str_replace('&quot;','"',stripslashes($_POST['ws_txt_body'])));
		}else if($_POST['type'] == 4){
			update_option('CMFR__subject_email',str_replace('&quot;','"',stripslashes($_POST['ws_subject'])));
			update_option('CMFR__html_email',str_replace('&quot;','"',stripslashes($_POST['ws_html_body'])));
			update_option('CMFR__txt_email',str_replace('&quot;','"',stripslashes($_POST['ws_txt_body'])));
		}
		header('HTTP/1.1 200 OK');			
		echo  0;			
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>