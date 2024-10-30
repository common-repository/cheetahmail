<?php
	$txt = '';
	$txt .= '<script language="javascript" type="text/javascript">';
			
		$txt .= 'var rsc_g_information = "'.__('rsc_js_g_information', DOMAIN_PLUGIN).'";'."\r\n"; // growl title info
		$txt .= 'var rsc_g_success = "'.__('rsc_js_g_success', DOMAIN_PLUGIN).'";'."\r\n"; // growl title successssss!!
		$txt .= 'var rsc_g_error = "'.__('rsc_js_g_error', DOMAIN_PLUGIN).'";'."\r\n"; // growl title error
		
		
		
		$txt .= 'var rsc_error = "'.__('rsc_js_error', DOMAIN_PLUGIN).'";'."\r\n"; // error standard
		$txt .= 'var rsc_params_error = "'.__('rsc_js_params_error', DOMAIN_PLUGIN).'";'."\r\n"; // error param manquant avec étoile ou valeur nok
		$txt .= 'var rsc_soap_error = "'.__('rsc_js_soap_error', DOMAIN_PLUGIN).'";'."\r\n"; // error standard soap
		$txt .= 'var rsc_camp_sheduled = "'.__('rsc_js_camp_sheduled', DOMAIN_PLUGIN).'";'."\r\n"; // campagne programmée
		$txt .= 'var rsc_installation_done = "'.__('rsc_js_installation_done', DOMAIN_PLUGIN).'";'."\r\n"; // 'Installation done, page reload in 2 seconds.'
		$txt .= 'var rsc_settings_saved = "'.__('rsc_js_settings_saved', DOMAIN_PLUGIN).'";'."\r\n"; // Paramètres sauvés
		
		$txt .= 'var rsc_structure_saved = "'.__('rsc_js_structure_saved', DOMAIN_PLUGIN).'";'."\r\n"; // structure sauvegardées	
		$txt .= 'var rsc_nl_settings_saved = "'.__('rsc_js_nl_settings_saved', DOMAIN_PLUGIN).'";'."\r\n"; // nl settings sauvegardées	

		
		$txt .= 'var rsc_nl_contents_load = "'.__('rsc_js_nl_contents_load', DOMAIN_PLUGIN).'";'."\r\n"; // erreur load nl contents
		$txt .= 'var rsc_nl_infos_load = "'.__('rsc_js_nl_infos_load', DOMAIN_PLUGIN).'";'."\r\n"; // erreur load nl informations
		$txt .= 'var rsc_subs_infos_load = "'.__('rsc_js_subs_infos_load', DOMAIN_PLUGIN).'";'."\r\n"; // erreur load subscribers informations
		$txt .= 'var rsc_nl_envelop_load = "'.__('rsc_js_nl_envelop_load', DOMAIN_PLUGIN).'";'."\r\n"; // erreur load nl envelopp	
		$txt .= 'var rsc_tpl_load = "'.__('rsc_js_tpl_load', DOMAIN_PLUGIN).'";'."\r\n"; // erreur load templates
		
		
		$txt .= 'var rsc_no_users = "'.__('rsc_js_no_users', DOMAIN_PLUGIN).'";'."\r\n"; // no users 
		$txt .= 'var rsc_users_sync = "'.__('rsc_js_users_sync', DOMAIN_PLUGIN).'";'."\r\n"; // users synchronized
		$txt .= 'var rsc_sync_done = "'.__('rsc_js_sync_done', DOMAIN_PLUGIN).'";'."\r\n"; //  synchronization done

		
		$txt .= 'var rsc_no_nl_topush = "'.__('rsc_js_no_nl_topush', DOMAIN_PLUGIN).'";'."\r\n"; // nl no NL to push
		$txt .= 'var rsc_nl_topush = "'.__('rsc_js_nl_topush', DOMAIN_PLUGIN).'";'."\r\n"; // NL push ok
		
		
		$txt .= 'var rsc_test_sent = "'.__('rsc_js_test_sent', DOMAIN_PLUGIN).'";'."\r\n"; //  test bien envoyé
		
		
		
		
		$txt .= 'var rsc_tpl_added = "'.__('rsc_js_tpl_added', DOMAIN_PLUGIN).'";'."\r\n"; //  template ajouté
		$txt .= 'var rsc_tpl_saved = "'.__('rsc_js_tpl_saved', DOMAIN_PLUGIN).'";'."\r\n"; //  template sauvegardé
		$txt .= 'var rsc_tpl_duplicated = "'.__('rsc_js_tpl_duplicated', DOMAIN_PLUGIN).'";'."\r\n"; //  template supprimé
		$txt .= 'var rsc_tpl_deleted = "'.__('rsc_js_tpl_deleted', DOMAIN_PLUGIN).'";'."\r\n"; //  template supprimé


		$txt .= 'var rsc_camp_notloaded = "'.__('rsc_js_camp_notloaded', DOMAIN_PLUGIN).'";'."\r\n"; //  camp non chargées
		$txt .= 'var rsc_camp_added = "'.__('rsc_js_camp_added', DOMAIN_PLUGIN).'";'."\r\n"; //  camp ajouté
		$txt .= 'var rsc_camp_saved = "'.__('rsc_js_camp_saved', DOMAIN_PLUGIN).'";'."\r\n"; //  camp sauvegardé
		$txt .= 'var rsc_camp_deleted = "'.__('rsc_js_camp_deleted', DOMAIN_PLUGIN).'";'."\r\n"; //  camp supprimé
		$txt .= 'var rsc_camp_duplicated = "'.__('rsc_js_camp_duplicated', DOMAIN_PLUGIN).'";'."\r\n"; //  camp supprimé
		

		$txt .= 'var rsc_target_notloaded = "'.__('rsc_js_target_notloaded', DOMAIN_PLUGIN).'";'."\r\n"; //  target non chargé
		$txt .= 'var rsc_target_added = "'.__('rsc_js_target_added', DOMAIN_PLUGIN).'";'."\r\n"; //  target ajouté
		$txt .= 'var rsc_target_saved = "'.__('rsc_js_target_saved', DOMAIN_PLUGIN).'";'."\r\n"; //  target sauvegardé
		

		$txt .= 'var rsc_config_saved = "'.__('rsc_js_config_saved', DOMAIN_PLUGIN).'";'."\r\n"; //  config sauvée
		
		
		
		$txt .= 'var rsc_wy_elt_added = "'.__('rsc_js_wy_elt_added', DOMAIN_PLUGIN).'";'."\r\n"; // WYSIWYG élément ajouté au contenu
		$txt .= 'var rsc_wy_fld_added = "'.__('rsc_js_wy_fld_added', DOMAIN_PLUGIN).'";'."\r\n"; // WYSIWYG champ user ajouté au contenu
		$txt .= 'var rsc_wy_img_added = "'.__('rsc_js_wy_img_added', DOMAIN_PLUGIN).'";'."\r\n"; // WYSIWYG image ajouté au contenu






		
		$txt .= 'var rsc_wy_add_article = "'.__('rsc_js_wy_add_article', DOMAIN_PLUGIN).'";'."\r\n"; // WYSIWYG titre 
		$txt .= 'var rsc_wy_add_userfield = "'.__('rsc_js_wy_add_userfield', DOMAIN_PLUGIN).'";'."\r\n"; // WYSIWYG titre
		$txt .= 'var rsc_wy_add_img = "'.__('rsc_js_wy_add_img', DOMAIN_PLUGIN).'";'."\r\n"; // WYSIWYG titre
				
		
		
		
		$txt .= 'var rsc_user_subscribed = "'.__('rsc_js_user_subscribed', DOMAIN_PLUGIN).'";'."\r\n"; // X est abonné
		$txt .= 'var rsc_user_unsubscribed = "'.__('rsc_js_user_unsubscribed', DOMAIN_PLUGIN).'";'."\r\n"; // X est désabonné
		$txt .= 'var rsc_user_updated = "'.__('rsc_js_user_updated', DOMAIN_PLUGIN).'";'."\r\n"; // user maj ok
		$txt .= 'var rsc_user_deleted = "'.__('rsc_js_user_deleted', DOMAIN_PLUGIN).'";'."\r\n"; // user deletion ok
				






		
		
	$txt .= '</script>';	
	return $txt;
?>