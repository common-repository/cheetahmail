<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');					
if(
	( isset($_POST['i']) && strlen($_POST['i'])>0  && is_numeric($_POST['i'])) 
	&&
	( isset($_POST['l']) && strlen($_POST['l'])>0 ) 
	&&
	( isset($_POST['p']) && strlen($_POST['p'])>0 ) 
	&&
	( isset($_POST['lang']) && $_POST['lang'] >= 0 ) 	
	&&
	( isset($_POST['dkim_id']) && $_POST['dkim_id'] > 0 ) 	
	&&
	( isset($_POST['dkim_label']) && strlen($_POST['dkim_label'])>0 ) 		
	&&
	( isset($_POST['prefix_email']) && strlen($_POST['prefix_email'])>0 ) 
	&&
	( isset($_POST['prefix_nl']) && strlen($_POST['prefix_nl'])>0 ) 
	&&
	( isset($_POST['prefix_bat']) && strlen($_POST['prefix_bat'])>0 ) 
	&&
	( isset($_POST['prefix_target']) && strlen($_POST['prefix_target'])>0 ) 
	&&
	( isset($_POST['batquery_emails']) && strlen($_POST['batquery_emails'])>0 ) 	
	&&
	( isset($_POST['id_desabo']) && strlen($_POST['id_desabo'])>0 ) 
	&&
	( isset($_POST['txt_desabo']) && strlen($_POST['txt_desabo'])>0 ) 
	&&	
	( isset($_POST['url_abo']) && strlen($_POST['url_abo'])>0 ) 
	&&
	( isset($_POST['ea']) && strlen($_POST['ea'])>0 )
	&&
	( isset($_POST['wa_enabled']) && strlen($_POST['wa_enabled'])>0 )
	&&
	( isset($_POST['wa_id']) && $_POST['wa_id']>=0 )
	&&
	( isset($_POST['shortcodes_style']) && strlen($_POST['shortcodes_style'])>0 )	
)
{
	// on est ok sur les params
	$MyEMST = new emst($_POST['i'],$_POST['l'],$_POST['p']);
	$def_bdd = $MyEMST->testConnexion();
	if( $def_bdd == 1){
		
		if($_POST['id_desabo'] == -1 || $_POST['url_desabo'] == ""){
			$track_link_ems = '$H(2)';
			$track_link_wp = $_POST['id_desabo'];
		}else{
			$track_link_ems = '$H('.$MyEMST->TrackUnitLink($_POST['url_desabo']).')';
			$track_link_wp = $_POST['id_desabo'];
		}
			
		// TOUT EST OK ON ECRIT LE FICHIER DE CONFIGURATION 
		$array_config_installed_to_json = array();
		$sr = $MyEMST->getVar('');
		$array_config_installed_to_json["CMFR__is_configured"] = $sr['CMFR__is_configured'];	
		$array_config_installed_to_json["CMFR__api_idmlist"] = $sr['CMFR__api_idmlist'];
		$array_config_installed_to_json["CMFR__api_login"] = $sr['CMFR__api_login'];
		$array_config_installed_to_json["CMFR__api_password"] = $_POST['p'];
		$array_config_installed_to_json["CMFR__api_date_lang"] = $_POST['lang'];	
		$array_config_installed_to_json["CMFR__api_dkim_id"] = $_POST['dkim_id'];
		$array_config_installed_to_json["CMFR__api_dkim_label"] = $_POST['dkim_label'];

		$array_config_installed_to_json["CMFR__api_doubletracking_enabled"] = $_POST['wa_enabled'];
		$array_config_installed_to_json["CMFR__api_doubletracking_id"] = $_POST['wa_id'];
		
		$array_config_installed_to_json["CMFR__prefix_email"] = $_POST['prefix_email'];
		$array_config_installed_to_json["CMFR__prefix_bat"] = $_POST['prefix_bat'];
		$array_config_installed_to_json["CMFR__prefix_nl"] = $_POST['prefix_nl'];	
		$array_config_installed_to_json["CMFR__prefix_target"] = $_POST['prefix_target'];	
		$array_config_installed_to_json["CMFR__idconf_subs"] = $sr['CMFR__idconf_subs'];
		$array_config_installed_to_json["CMFR__idconf_unsubs"] = $sr['CMFR__idconf_unsubs'];
		$array_config_installed_to_json["CMFR__idconf_nl"] = $sr['CMFR__idconf_nl'];
		$array_config_installed_to_json["CMFR__idconf_campaign"] = $sr['CMFR__idconf_campaign'];	
		$array_config_installed_to_json["CMFR__idchrono_subs"] = $sr['CMFR__idchrono_subs'];			
		$array_config_installed_to_json["CMFR__idchrono_unsubs"] = $sr['CMFR__idchrono_unsubs'];
		
		$array_config_installed_to_json["CMFR__idcamp_subs"] = $sr['CMFR__idcamp_subs'];			
		$array_config_installed_to_json["CMFR__idcamp_unsubs"] = $sr['CMFR__idcamp_unsubs'];
		
		$array_config_installed_to_json["CMFR__idquery_nl"] = $sr['CMFR__idquery_nl'];
		$array_config_installed_to_json["CMFR__idquery_bat"] = $sr['CMFR__idquery_bat'];
		$array_config_installed_to_json["CMFR__idquery_campaign"] = $sr['CMFR__idquery_campaign'];	
		$array_config_installed_to_json["CMFR__idquery_unsubs"] = $sr['CMFR__idquery_unsubs'];	
		$array_config_installed_to_json["CMFR__idquery_bat_emails"] = $_POST['batquery_emails'];
		$array_config_installed_to_json["CMFR__email_preview"] = $_POST['email_preview']; // email preview		
		$array_config_installed_to_json["CMFR__id_tracked_ems_link"] = $track_link_ems; // url trackée
		$array_config_installed_to_json["CMFR__id_tracked_wp_link"] = $track_link_wp; // url trackée
		$array_config_installed_to_json["CMFR__url_desabo"] = $_POST['url_desabo']; // url WP
		$array_config_installed_to_json["CMFR__url_abo"] = $_POST['url_abo']; // url abo WP
		$array_config_installed_to_json["CMFR__unsubs_text_top"] = stripslashes($_POST['txtbefore_desabo']); // url abo WP
		$array_config_installed_to_json["CMFR__unsubs_text_link"] = $_POST['txt_desabo']; // url abo WP
		$array_config_installed_to_json["CMFR__unsubs_text_bottom"] = stripslashes($_POST['txtafter_desabo']); // url abo WP	
					
		$array_config_installed_to_json["CMFR__ea"] = $_POST['ea']; // ea			
		$array_config_installed_to_json["CMFR__shortcodes_style"] = $_POST['shortcodes_style']; // shortcodes_style
		
		$MyEMST->setVars($array_config_installed_to_json);

		// on met à jour les configs : partie DKIM
		$MyEMST->setTheDomain($sr['CMFR__idconf_subs'],$_POST['dkim_id']);
		$MyEMST->setTheDomain($sr['CMFR__idconf_unsubs'],$_POST['dkim_id']);
		$MyEMST->setTheDomain($sr['CMFR__idconf_nl'],$_POST['dkim_id']);
		$MyEMST->setTheDomain($sr['CMFR__idconf_campaign'],$_POST['dkim_id']);
		
		if($_POST['url_desabo'] == "")
		{
			$urldesabo = '$H(2)';
		}
		else
		{
			if(strpos($_POST['url_desabo'],'?') !== false){
				$urldesabo = $_POST['url_desabo'].'&email=$U(1)';
			}else{
				$urldesabo = $_POST['url_desabo'].'?email=$U(1)';
			}			
		}
		
		// on met à jour les configs : partie UNSUBS
		$html_unsubs = $_POST['txtbefore_desabo'] . '<a href="'.$urldesabo.'" target="_blank">'.$_POST['txt_desabo'].'</a>'.$_POST['txtafter_desabo'];
		$txt_unsubs = $_POST['txtbefore_desabo'] . ' ' . $urldesabo .' '.$_POST['txtafter_desabo'];

		// config NL
		$conf_nl_infos = $MyEMST->GetConfigById($sr['CMFR__idconf_nl']);
		
		$MyEMST->UpdateConfigs(
			$conf_nl_infos->idMlist,
			$conf_nl_infos->idConf,
			$conf_nl_infos->name,
			$conf_nl_infos->mailFrom,
			$conf_nl_infos->mailFromAddr,
			$conf_nl_infos->mailRetNpai,	
			$conf_nl_infos->mailReply,		
			$html_unsubs,
			$txt_unsubs,		
			$conf_nl_infos->htmlFooter,
			$conf_nl_infos->txtFooter,
			$conf_nl_infos->htmlHeader,
			$conf_nl_infos->txtHeader
		);
		
		// config EMAIL
		$conf_email_infos = $MyEMST->GetConfigById($sr['CMFR__idconf_campaign']);
		
		$MyEMST->UpdateConfigs(
			$conf_email_infos->idMlist,
			$conf_email_infos->idConf,
			$conf_email_infos->name,
			$conf_email_infos->mailFrom,
			$conf_email_infos->mailFromAddr,
			$conf_email_infos->mailRetNpai,	
			$conf_email_infos->mailReply,		
			$html_unsubs,
			$txt_unsubs,		
			$conf_email_infos->htmlFooter,
			$conf_email_infos->txtFooter,
			$conf_email_infos->htmlHeader,
			$conf_email_infos->txtHeader
		);
		
		
		// on gère l'@ de preview ajout si inexistante
		if($_POST['email_preview'] != ""){
			$test_ep_synthax = preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#",$_POST['email_preview'] );
			if($test_ep_synthax){
				$MyEMST->AddByEmail($_POST['email_preview']);
			}
		}
	
		// on splitte les @ et on les ajoute une par une en db si elles n'existent pas déjà		
		$mustbesplit = strpos($_POST['batquery_emails'],chr(10));
		$tab_emails_bat = array();
		
		if($mustbesplit){
			$tab_emails_bat = explode(chr(10),$_POST['batquery_emails']);
		}else{
			$tab_emails_bat[] = $_POST['batquery_emails'];
		}
		
		$new_emails = '';
		
		foreach($tab_emails_bat as $email){
			$test_email_synthax = preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#",$email );
				if($test_email_synthax){
					$MyEMST->AddByEmail($email);
					$new_emails .= $email.';';
				}
		}
		
		
		$re = $MyEMST->UpdateBatTarget($new_emails);
		// il nous reste à mettre à jour les 2 configs NL et EMAIL
		header('HTTP/1.1 200 OK');	
		echo 0;
	}else{
		// erreur API
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
					
}
else
{
	// paramètres NOK
	header('HTTP/1.1 200 OK');	
	echo -2;
}

?>