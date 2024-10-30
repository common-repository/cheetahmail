<?php
// on inclue les API
include('../fn/fn.php');
require('../../../../wp-blog-header.php');

if(
	( isset($_POST['i']) && strlen($_POST['i'])>0  && is_numeric($_POST['i'])) 
	&&
	( isset($_POST['l']) && strlen($_POST['l'])>0 ) 
	&&
	( isset($_POST['p']) && strlen($_POST['p'])>0 ) 
)
{
	// on est ok sur les params
	$obj = new emst($_POST['i'],$_POST['l'],$_POST['p']);
	
	// test de connexion de tous les WS 
	$def_bdd = $obj->testConnexion();
	
	if( $def_bdd == 1)
	{	
			

		$default_unsubs_html  = LINK_UNSUBS_UP . '<a href="'.TRACKED_LINK_URL.'" target="_blank">'.LINK_UNSUBS_TEXT.'</a>'. LINK_UNSUBS_DOWN;
		
		$default_unsubs_txt  = LINK_UNSUBS_UP . ' '.TRACKED_LINK_URL.' '. LINK_UNSUBS_DOWN;		
		
		// 1 création des configs							
		// ON RECUPERE LE PREMIER DOMAINE
		$domain = $obj->GetFirstDomain('id');
		$domain_tab = explode('|', $domain);
		$id_first_domain = $domain_tab[0];
		$name_first_domain = $domain_tab[1];
		
		// SUBSCRIPTION
		$conf_subs = $obj->AddConfig($_POST['i'],CONFIG_SUBS_NAME,MAILFROM, MAILFROMADDRESS.$name_first_domain,MAILNPAI,MAILREPLY,MAILTO,MAILDEP,'','',HTML_FOOTER,TXT_FOOTER,HTML_HEADER,TXT_HEADER,$id_first_domain);
		
		// SUBSCRIPTION
		$conf_unsubs = $obj->AddConfig($_POST['i'],CONFIG_UNSUBS_NAME,MAILFROM, MAILFROMADDRESS.$name_first_domain,MAILNPAI,MAILREPLY,MAILTO,MAILDEP,'','',HTML_FOOTER,TXT_FOOTER,HTML_HEADER,TXT_HEADER,$id_first_domain);

		// NEWSLETTER
		$conf_nl = $obj->AddConfig($_POST['i'],CONFIG_NL_NAME,MAILFROM, MAILFROMADDRESS.$name_first_domain,MAILNPAI,MAILREPLY,MAILTO,MAILDEP,$default_unsubs_html,$default_unsubs_txt,HTML_FOOTER,TXT_FOOTER,HTML_HEADER,TXT_HEADER,$id_first_domain);
		
		// EMAIL ET BAT
		$conf_emails = $obj->AddConfig($_POST['i'],CONFIG_EMAILING_NAME,MAILFROM, MAILFROMADDRESS.$name_first_domain,MAILNPAI,MAILREPLY,MAILTO,MAILDEP,$default_unsubs_html,$default_unsubs_txt,HTML_FOOTER,TXT_FOOTER,HTML_HEADER,TXT_HEADER,$id_first_domain);

		// 2 création des filters

		$target_emails = $obj->AddTarget(FILTER_EMAILING_NAME,0);
		$target_nl = $obj->AddTarget(FILTER_NL_NAME,0);
		$target_bat = $obj->AddTarget(FILTER_BAT_NAME,0,DEFAULT_BAT_EMAIL);
		$target_unsubs = $obj->AddTarget(FILTER_UNSUBS_NAME,1);
		
		// 3 création des campagnes
		
		$camp_subs = $obj->AddCamp(CAMP_SUBS_NAME,0,$conf_subs,'0001-01-01T00:00:00',CAMP_DEFAULT_SUBJECT,3,'','',false);
		$camp_unsubs = $obj->AddCamp(CAMP_UNSUBS_NAME,0,$conf_unsubs,'0001-01-01T00:00:00',CAMP_DEFAULT_SUBJECT,3,'','',false);
		

		// on cree un template bidon
		$template_temp = $obj -> AddTemplate('template to delete','','','');

		// 4 : création des chronos
		$subs_chrono = $obj -> AddChronocontact('SUBS',$camp_subs,$template_temp);
		$unsubs_chrono = $obj -> AddChronocontact('UNSUBS',$camp_unsubs,$template_temp);
		
		
		// on ne supprime pas le template sinon le chrono ne fonctionne plus.
		// $obj-> DeleteTemplateById($template_temp);
		
			
		// 5 : on met tout à jour les VARIABLES DE CONFIG

		
		if(
			$id_first_domain > 0 &&
			$conf_subs > 0 &&
			$conf_unsubs > 0 && 
			$conf_nl > 0 && 
			$conf_emails > 0 && 
			$subs_chrono > 0 && 
			$unsubs_chrono > 0 && 
			$target_nl > 0 && 
			$target_bat > 0 && 
			$target_emails > 0
		)
		{

			// on cree la page abo
			$my_post = array();
			$my_post['post_title'] = 'SUBSCRIBE';
			$my_post['post_content'] = '[subscription_newsletter]';
			$my_post['post_status'] = 'publish';
			$my_post['post_author'] = 1;
			$my_post['post_type'] = 'page';
			$id_abo = wp_insert_post( $my_post );

			// on cree la page desabo
			$my_post = array();
			$my_post['post_title'] = 'UNSUBSCRIBE';
			$my_post['post_content'] = '[unsubscription_newsletter]';
			$my_post['post_status'] = 'draft';
			$my_post['post_author'] = 1;
			$my_post['post_type'] = 'page';
			$id_desabo = wp_insert_post( $my_post );
				
				

			// on cree la zone de desabo des configs	


		
			// TOUT EST OK :)
			$array_config_installed_to_json = array();
			
			$array_config_installed_to_json["CMFR__is_configured"] = 0;				
			$array_config_installed_to_json["CMFR__api_idmlist"] = $_POST['i'];
			$array_config_installed_to_json["CMFR__api_login"] = $_POST['l'];
			$array_config_installed_to_json["CMFR__api_password"] = $_POST['p'];
			$array_config_installed_to_json["CMFR__api_date_lang"] = 0;

			$array_config_installed_to_json["CMFR__api_doubletracking_enabled"] = 0;
			$array_config_installed_to_json["CMFR__api_doubletracking_id"] = 0;
			
			$array_config_installed_to_json["CMFR__api_dkim_id"] = $id_first_domain;
			$array_config_installed_to_json["CMFR__api_dkim_label"] = $name_first_domain;
			
			$array_config_installed_to_json["CMFR__prefix_email"] = PREFIX_EMAILING;
			$array_config_installed_to_json["CMFR__prefix_bat"] = PREFIX_BAT;
			$array_config_installed_to_json["CMFR__prefix_nl"] = PREFIX_NL;
			
			$array_config_installed_to_json["CMFR__prefix_target"] = PREFIX_TARGET;
			
			$array_config_installed_to_json["CMFR__idconf_subs"] = $conf_subs;
			$array_config_installed_to_json["CMFR__idconf_unsubs"] = $conf_unsubs;
			$array_config_installed_to_json["CMFR__idconf_nl"] = $conf_nl;
			$array_config_installed_to_json["CMFR__idconf_campaign"] = $conf_emails;
						
			$array_config_installed_to_json["CMFR__idchrono_subs"] = $subs_chrono;			
			$array_config_installed_to_json["CMFR__idchrono_unsubs"] = $unsubs_chrono;
						
			$array_config_installed_to_json["CMFR__idcamp_subs"] = $camp_subs;			
			$array_config_installed_to_json["CMFR__idcamp_unsubs"] = $camp_unsubs;

			
			$array_config_installed_to_json["CMFR__idquery_nl"] = $target_nl;
			$array_config_installed_to_json["CMFR__idquery_bat"] = $target_bat;
			$array_config_installed_to_json["CMFR__idquery_campaign"] = $target_emails;
			$array_config_installed_to_json["CMFR__idquery_unsubs"] = $target_unsubs;				
			$array_config_installed_to_json["CMFR__idquery_bat_emails"] = DEFAULT_BAT_EMAIL;
			
			$array_config_installed_to_json["CMFR__email_preview"] = EMAIL_PREVIEW;		
			
			$array_config_installed_to_json["CMFR__shortcodes_style"] = 1;		
			
			$array_config_installed_to_json["CMFR__id_tracked_ems_link"] = ID_TRACKED_LINK_EMS;				
			$array_config_installed_to_json["CMFR__id_tracked_wp_link"] = ID_TRACKED_LINK_WP;
			$array_config_installed_to_json["CMFR__url_desabo"] = TRACKED_LINK_URL;
			$array_config_installed_to_json["CMFR__url_abo"] = $id_abo;				
			$array_config_installed_to_json["CMFR__ea"] = 0;				
			// on cree les variables de la newsletter
			$array_config_installed_to_json["CMFR__nl_date_last_sent"] = NL_DATE_LAST_SENT;				
			$array_config_installed_to_json["CMFR__nl_activation"] = NL_ACTIVATE;				
			$array_config_installed_to_json["CMFR__nl_type_elements"] = NL_TYPE_ELEMENTS;
			$array_config_installed_to_json["CMFR__nl_order_elements"] = NL_ORDER_ELEMENTS;
			$array_config_installed_to_json["CMFR__nl_nb_elements"] = NL_NB_ELEMENTS;
			$array_config_installed_to_json["CMFR__nl_frequency"] = NL_FREQUENCY;				
			// on cree les variables de config des elements poussés
			$array_config_installed_to_json["CMFR__nl_image"] = NL_IMAGE;
			$array_config_installed_to_json["CMFR__nl_link"] = NL_LINK;			
			$array_config_installed_to_json["CMFR__nl_coment"] = NL_COMENT;			
			// on cree les variables du style de titre
			$array_config_installed_to_json["CMFR__nl_title_fontface"] = NL_TITLE_FONT;					
			$array_config_installed_to_json["CMFR__nl_title_color"] = NL_TITLE_COLOR;
			$array_config_installed_to_json["CMFR__nl_title_size"] = NL_TITLE_SIZE;
			$array_config_installed_to_json["CMFR__nl_title_underline"] = NL_TITLE_UNDERLINE;
			$array_config_installed_to_json["CMFR__nl_title_bold"] = NL_TITLE_BOLD;				
			$array_config_installed_to_json["CMFR__nl_title_italic"] = NL_TITLE_ITALIC;
			$array_config_installed_to_json["CMFR__nl_title_uppercase"] = NL_TITLE_UPPERCASE;
			// on cree les variables du style de contenu
			$array_config_installed_to_json["CMFR__nl_content_fontface"] = NL_CONTENT_FONT;					
			$array_config_installed_to_json["CMFR__nl_content_color"] = NL_CONTENT_COLOR;
			$array_config_installed_to_json["CMFR__nl_content_size"] = NL_CONTENT_SIZE;
			$array_config_installed_to_json["CMFR__nl_content_underline"] = NL_CONTENT_UNDERLINE;
			$array_config_installed_to_json["CMFR__nl_content_bold"] = NL_CONTENT_BOLD;				
			$array_config_installed_to_json["CMFR__nl_content_italic"] = NL_CONTENT_ITALIC;
			$array_config_installed_to_json["CMFR__nl_content_uppercase"] = NL_CONTENT_UPPERCASE;
			// on cree les variables du style de link
			$array_config_installed_to_json["CMFR__nl_link_defaulttext"] = NL_LINK_DEFAULTTEXT;					
			$array_config_installed_to_json["CMFR__nl_link_fontface"] = NL_LINK_FONT;					
			$array_config_installed_to_json["CMFR__nl_link_color"] = NL_LINK_COLOR;
			$array_config_installed_to_json["CMFR__nl_link_size"] = NL_LINK_SIZE;
			$array_config_installed_to_json["CMFR__nl_link_underline"] = NL_LINK_UNDERLINE;
			$array_config_installed_to_json["CMFR__nl_link_bold"] = NL_LINK_BOLD;				
			$array_config_installed_to_json["CMFR__nl_link_italic"] = NL_LINK_ITALIC;
			$array_config_installed_to_json["CMFR__nl_link_uppercase"] = NL_LINK_UPPERCASE;
			// on cree les variables du style de commentaires
			$array_config_installed_to_json["CMFR__nl_coment_fontface"] = NL_COMENT_FONT;					
			$array_config_installed_to_json["CMFR__nl_coment_color"] = NL_COMENT_COLOR;
			$array_config_installed_to_json["CMFR__nl_coment_size"] = NL_COMENT_SIZE;
			$array_config_installed_to_json["CMFR__nl_coment_underline"] = NL_COMENT_UNDERLINE;
			$array_config_installed_to_json["CMFR__nl_coment_bold"] = NL_COMENT_BOLD;				
			$array_config_installed_to_json["CMFR__nl_coment_italic"] = NL_COMENT_ITALIC;
			$array_config_installed_to_json["CMFR__nl_coment_uppercase"] = NL_COMENT_UPPERCASE;	


			// ON AJOUTE LA PARTIE DESABO
			$array_config_installed_to_json["CMFR__unsubs_text_top"] = LINK_UNSUBS_UP;
			$array_config_installed_to_json["CMFR__unsubs_text_link"] = LINK_UNSUBS_TEXT;			
			$array_config_installed_to_json["CMFR__unsubs_text_bottom"] = LINK_UNSUBS_DOWN;			
	
			
			// ON AJOUTE LES BODY ET OBJETS DE L'EMAIL ABO
			$array_config_installed_to_json['CMFR__subject_subs'] = CAMP_DEFAULT_SUBJECT;
			$array_config_installed_to_json['CMFR__html_subs'] = HTML_DEFAULT;
			$array_config_installed_to_json['CMFR__txt_subs'] = TXT_DEFAULT;
			// ON AJOUTE LES BODY ET OBJETS DE L'EMAIL DESABO
			$array_config_installed_to_json['CMFR__subject_unsubs'] = CAMP_DEFAULT_SUBJECT;
			$array_config_installed_to_json['CMFR__html_unsubs'] = HTML_DEFAULT;
			$array_config_installed_to_json['CMFR__txt_unsubs'] = TXT_DEFAULT;
			// ON AJOUTE LES BODY ET OBJETS DE  LA NL
			$array_config_installed_to_json['CMFR__subject_nl'] = CAMP_DEFAULT_SUBJECT;
			$array_config_installed_to_json['CMFR__wrapper_top_nl'] = WRAPPER_NL_TOP;
			$array_config_installed_to_json['CMFR__wrapper_bottom_nl'] = WRAPPER_NL_BOTTOM;
			// ON AJOUTE LES BODY ET OBJETS DE CAMPAGNES EMAILS
			$array_config_installed_to_json['CMFR__subject_email'] = CAMP_DEFAULT_SUBJECT;
			$array_config_installed_to_json['CMFR__html_email'] = HTML_DEFAULT;
			$array_config_installed_to_json['CMFR__txt_email'] = TXT_DEFAULT;					
			
			// on génère la variable structure de BDD
			
			$array_config_installed_to_json['CMFR__db_mapping'] = '';				
			// on met tout en bdd
			foreach($array_config_installed_to_json as $key=>$value){
				delete_option($key);
				add_option($key,$value,'no');
				update_option($key,$value,'no');
			}
			// on recup la structure EMST			
			$tab_mapping = $obj->getStructure();				
			$tab_mapping_final = array();
			$increment_fld = 0;
			
			// on boucle sur chaque champ
			foreach($tab_mapping as $fld_line)
			{
				$increment_per_field = 0;
				$id_field = 0;
				$type_fld = 0;
				$synch_fld = false;
				$edit_fld = 0;
				$values_fld = 0;				
				$tab_temp =array();
					// on boucle sur chaque element par champ
					foreach($fld_line as $fld_col)
					{
						
						if($increment_per_field==0)
						{
							// on est sur le champ ID
							$id_field = $fld_col;
							$tab_temp['id'] = $fld_col;
							$tab_temp['synchronized'] = false;
							if($id_field < 4)
							{
								// c'est < etat abo => obligatoire
								$tab_temp['editable'] = false;								
							}
							else if($id_field >= 4)
							{
								// c'est au dessus au choix du user
								$tab_temp['editable'] = true;	
							}			
						}
						else if($increment_per_field == 1)
						{
							// c'est le nom de champ
							$tab_temp['display_name'] = $fld_col;
						}
						else if($increment_per_field == 2)
						{
							// c'est le type de champ
							/*
								$type_fld
								0 => TXT
								1 => Email
								2 => Date
								3 => Numeric
								4 => SubscriberId
								5 => Integer
							*/
							if($fld_col == "Text")
							{
								$tab_temp['type'] = 0;
								$type_fld = 0;
							}
							else if($fld_col == "EmailAddress")
							{
								$tab_temp['type'] = 1;
								$type_fld = 1;
							}
							else if($fld_col == "Date")
							{
								$tab_temp['type'] = 2;
								$type_fld = 2;
							}
							else if($fld_col == "Numeric")
							{
								$tab_temp['type'] = 3;
								$type_fld = 3;
							}
							else if($fld_col == "SubscriberId")
							{
								$tab_temp['type'] = 4;
								$type_fld = 4;
							}
							else if($fld_col == "IntegerList")
							{
								$tab_temp['type'] = 5;
								$type_fld = 5;	
							}
							
						}
						else if($increment_per_field == 3)
						{
							// si on est sur un champ liste entiers
							if($type_fld == 5)
							{								
								$res_col_fld = '';
								$fld_col_tab = explode(';',$fld_col);
								$txt_f = '';
								foreach($fld_col_tab as $col_fld){
									if(is_numeric($col_fld)){
										$txt_f .= $col_fld . '___';
									}else{
										$txt_f .= $col_fld . ';;;';
									}										
								}
								$tab_temp['values'] = $txt_f;
							}
							else
							{
								$tab_temp['values'] = '';
							}
							
							$tab_temp['toppage'] = '0';
							$tab_temp['fixed_value'] = '';
						}
						
						// on incrémente
						$increment_per_field++;
					
					}
				// on ajoute le formattage
				/*
					0 : Aucun
					1 : Minuscule
					2 : Majuscule
					3 : Première lettre majusucule
					4 : Première lettre de chaque mot majuscule						
				*/
				$tab_temp['formatting'] = 0;
				// on met la longueur du champ en dur, le user le changera par la suite			

				if($fld->type <4 && $fld->type != 2){
					$tab_temp['size'] = "250";	
				}else{
					$tab_temp['size'] = "0";	
				}
						
				$tab_mapping_final[] = $tab_temp;
				$increment_fld++;					
			}
			// on ajoute la variable de la structure de bdd
			delete_option('CMFR__db_mapping');
			add_option('CMFR__db_mapping',json_encode($tab_mapping_final),'no');
			update_option('CMFR__db_mapping',json_encode($tab_mapping_final),'no');
			
			
			
			
			
			
						
			// TOUT EST OK !	
			header('HTTP/1.1 200 OK');	
			echo 0;
		}
		else
		{
		// UNE OPERATION EST NOK ON ROLLBACK
		
		// TOUT EST OK ON ECRIT LE FICHIER DE CONFIGURATION ET ROULE MA POULE :)
			try{
			$obj->DeleteConfig($conf_subs);
			$obj->DeleteConfig($conf_unsubs);
			$obj->DeleteConfig($conf_nl);
			$obj->DeleteConfig($conf_emails);				
			$obj->DeleteChronocontact($subs_chrono);
			$obj->DeleteChronocontact($unsubs_chrono);
			// on ne peut pas supprimer les cibles en API
			}
			catch( Exception $e ){
			// echo $e;
			}
			header('HTTP/1.1 200 OK');	
			echo -3;
		}
					
	}
	else
	{
		// API ne fonctionne pas
		header('HTTP/1.1 200 OK');	
		echo -1;
	}
}
else
{
	// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
}

?>