<?php
	// function appell&eacute;e par le menu cheetahmail
	function installation_plugin_view()
	{
		$return_txt ='';
		$return_txt .= include(dirname( __FILE__ ) . '/fn/js.php');
		$return_txt .= '<div class="experian_wrapper_outter">';
		$return_txt .= '<div class="experian_wrapper">';
		$return_txt .= '<div class="experian_logo install">';
			$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/logo.png" />';
		$return_txt .= '</div>';
		
		// $return_txt .= include(dirname( __FILE__ ) . '/fn/js.php');
		
		$return_txt .= '<div class="navigation-top float">';                
			$return_txt .= '<ul class="main-menu">';
				$return_txt .= '<li class="main-menu-item active"><a href="admin.php?page=settings"><span>'.__('Install').'</span></a></li>';
			$return_txt .= '</ul>';
			$return_txt .= '<ul class="sub-menu"></ul>';			
		$return_txt .= '</div>';
		
		$return_txt .= '<div class="experian_wrapper_inner">';
		
				$return_txt .= '<h2 class="installation">';
					$return_txt .= '<span>'.__('plugin_title', DOMAIN_PLUGIN).'</span>';
				$return_txt .= '</h2>';

				$return_txt .= '<div class="form_wrapper install">';				
						
				
				$return_txt .= '<p>&nbsp;</p>';
				$return_txt .= '<p><label></label><strong style="line-height:20px;"> <img src="../wp-content/plugins/cheetahmail/img/informationning.png" style="vertical-align:middle;" />'.__('rsc_static_intro', DOMAIN_PLUGIN).'</strong></p>';
				$return_txt .= '<p>&nbsp;</p>';
				
				
				$return_txt .= '<p>';
					$return_txt .= '<label for="idmlist">'.__('plugin_idmlist', DOMAIN_PLUGIN). '<span class="required"> *</span></label>';
					$return_txt .= '<input class="tipsyer" original-title="'.__('plugin_tooltip_idmlist', DOMAIN_PLUGIN). '" type="text" id="idmlist" tabindex="1" maxlength="10" name="cheetahmail_api_idmlist" />';
				$return_txt .= '</p>';   
				
				$return_txt .= '<p>';
					$return_txt .= '<label for="ws_login">'.__('plugin_login', DOMAIN_PLUGIN). ' <span class="required"> *</span></label>';
					$return_txt .= '<input class="tipsyer" original-title="'.__('plugin_tooltip_login', DOMAIN_PLUGIN). '" type="text" id="ws_login" tabindex="2" maxlength="50" name="cheetahmail_api_login"  />';
				$return_txt .= '</p>';                    
							  
				$return_txt .= '<p>';
					$return_txt .= '<label for="ws_password">'.__('plugin_key', DOMAIN_PLUGIN). ' <span class="required"> *</span></label>';
					$return_txt .= '<input class="tipsyer"  original-title="'.__('plugin_tooltip_key', DOMAIN_PLUGIN). ' " type="text" id="ws_password" maxlength="50" tabindex="3" name="cheetahmail_api_key"  />';
				$return_txt .= '</p>';                            
			
				// bouton soumission
				$return_txt .= '<p>';
					$return_txt .= '<span class="valid"><input class="validation" type="button" value="'.__('rsc_standard_update', DOMAIN_PLUGIN).'" id="submit_init" /></span>';
				$return_txt .= '</p>';				
									
				
				
			$return_txt .= '</div>';
			
			
			
			
		
			$return_txt .= '<h2 class="static">';
				$return_txt .= '<span>'.__('rsc_static_title', DOMAIN_PLUGIN).'</span>';
			$return_txt .= '</h2>';			
			

			$return_txt .= '<div class="form_wrapper_static">';
				$return_txt .= '<h2>'.__('rsc_static_b1_title', DOMAIN_PLUGIN).'</h2>';
				$return_txt .= '<p>';
					$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/target.png" /> ';
					$return_txt .= ''.__('rsc_static_b1_content', DOMAIN_PLUGIN).'';
				$return_txt .= '</p>';
				$return_txt .= '<p>';						
					$return_txt .= '<a href="http://www.experian.fr/marketing-services/data-quality/index.html" target="_blank">'.__('rsc_static_b1_link', DOMAIN_PLUGIN).'</a>';
				$return_txt .= '</p>';
			$return_txt .= '</div>';


			$return_txt .= '<div class="form_wrapper_static">';
				$return_txt .= '<h2>'.__('rsc_static_b2_title', DOMAIN_PLUGIN).'</h2>';
				$return_txt .= '<p>';
					$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/cross.png" /> ';
					$return_txt .= ''.__('rsc_static_b2_content', DOMAIN_PLUGIN).'';
				$return_txt .= '</p>';
				$return_txt .= '<p>';
					$return_txt .= '<a href="http://www.experian.fr/marketing-services/connaissance-client-segmentation/index.html" target="_blank">'.__('rsc_static_b2_link', DOMAIN_PLUGIN).'</a>';
				$return_txt .= '</p>';
			$return_txt .= '</div>';

			$return_txt .= '<div class="form_wrapper_static">';
				$return_txt .= '<h2>'.__('rsc_static_b3_title', DOMAIN_PLUGIN).'</h2>';
				$return_txt .= '<p>';
					$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/data.png" /> ';
					$return_txt .= ''.__('rsc_static_b3_content', DOMAIN_PLUGIN).'';
				$return_txt .= '</p>';
				$return_txt .= '<p>';						
					$return_txt .= '<a href="http://www.experian.fr/marketing-services/marketing-cross-canal/index.html" target="_blank">'.__('rsc_static_b3_link', DOMAIN_PLUGIN).'</a>';
				$return_txt .= '</p>';
			$return_txt .= '</div>';
			
			// $return_txt .= '<p>&nbsp;</p>';			
			
			$return_txt .= '<div class="experian_wrapper_footer">';
				$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/footer-bg-left.png" />';
				$return_txt .= '<img class="float_right" src="../wp-content/plugins/cheetahmail/img/footer-bg-right.png" />';
			$return_txt .= '</div>';
		$return_txt .= '</div>';
				
	$return_txt .= '</div>';//outter				
	echo $return_txt;
	
	
	}
			
	// function appell&eacute;e par le menu cheetahmail
	function update_plugin_view()
	{
		// on recup toute la config
		$tab_config_values = getVar();
		
		$oIdlist = $tab_config_values['CMFR__api_idmlist'];
		$oLogin = $tab_config_values['CMFR__api_login'];
		$oPassword = $tab_config_values['CMFR__api_password'];
		$oDateLang = $tab_config_values['CMFR__api_date_lang'];
		$oDkim = $tab_config_values['CMFR__api_dkim_id'];
		
		
		$oDblTrack_enlabled = $tab_config_values['CMFR__api_doubletracking_enabled'];
		$oDblTrack = $tab_config_values['CMFR__api_doubletracking_id'];
		
		
		
		$oCampPrefix = $tab_config_values['CMFR__prefix_email'];
		$oBATPrefix = $tab_config_values['CMFR__prefix_bat'];
		$oNLPrefix = $tab_config_values['CMFR__prefix_nl'];
		$oTargetPrefix = $tab_config_values['CMFR__prefix_target'];
		
		$oBATQueryEmails = $tab_config_values['CMFR__idquery_bat_emails'];
		$oEMailPreview= $tab_config_values['CMFR__email_preview'];
		
		$oTrackLinkEms = $tab_config_values['CMFR__id_tracked_ems_link'];
		$oTrackLinkWp = $tab_config_values['CMFR__id_tracked_wp_link'];
		
		$oIdUrlAbo = $tab_config_values['CMFR__url_abo'];
		$oEA = $tab_config_values['CMFR__ea'];
				
		$oUnsubsTextTop = $tab_config_values['CMFR__unsubs_text_top'];
		$oUnsubsTextLink = $tab_config_values['CMFR__unsubs_text_link'];
		$oUnsubsTextBottom = $tab_config_values['CMFR__unsubs_text_bottom'];	
		
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
			
		$return_txt ='';
		$return_txt .= include(dirname( __FILE__ ) . '/fn/js.php');
		$return_txt .= '<div class="experian_wrapper_outter">';
			$return_txt .= '<div class="experian_wrapper">';
				$return_txt .= '<div class="experian_logo">';
					$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/logo.png" />';
				$return_txt .= '</div>';
		
				$return_txt .= '<div class="navigation-top float">';                
					$return_txt .= '<ul class="main-menu">';
						$return_txt .= '<li class="main-menu-item active"><a href="admin.php?page=settings"><span>'.__('menu_settings', DOMAIN_PLUGIN).'</span></a></li>';
						$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=subscriptions"><span>'.__('menu_subscriptions', DOMAIN_PLUGIN).'</span></a></li>';  
						$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=newsletters"><span>'.__('menu_newsletters', DOMAIN_PLUGIN).'</span></a></li>'; 
						$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=emails"><span>'.__('menu_emailing', DOMAIN_PLUGIN).'</span></a></li>';
						$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=templates"><span>'.__('menu_templates', DOMAIN_PLUGIN).'</span></a></li>'; 
						$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=targets"><span>'.__('menu_targets', DOMAIN_PLUGIN).'</span></a></li>'; 
					$return_txt .= '</ul>';
					$return_txt .= '<ul class="sub-menu"></ul>';				         
				$return_txt .= '</div>';

			$return_txt .= '<div class="experian_wrapper_inner">'; // wrapper blanc
			
				$return_txt .= '<h2 class="settings"><span>'.__('menu_settings', DOMAIN_PLUGIN).'</span></h2>'; // h2 page
				
				$return_txt .= '<div class="form_wrapper">';	
				
				
				$return_txt .= '<div class="filter-menu-container">';
				$return_txt .= '<ul class="filter-menu frequencies-filter heading">';
				$return_txt .= '<li id="elt_0" class="heading_elt active"><img src="../wp-content/plugins/cheetahmail/img/_api.png"> '.strtoupper(__('sub_sub_menu_api', DOMAIN_PLUGIN)).'</li>';
				$return_txt .= '<li id="elt_1" class="heading_elt"><img src="../wp-content/plugins/cheetahmail/img/_settings.png"> '.strtoupper(__('sub_sub_menu_settings', DOMAIN_PLUGIN)).'</li>';
				$return_txt .= '<li id="elt_2" class="heading_elt"><img src="../wp-content/plugins/cheetahmail/img/_structure.png"> '.strtoupper(__('sub_sub_menu_structure', DOMAIN_PLUGIN)).'</li>';
				$return_txt .= '<li id="elt_3" class="heading_elt"><img src="../wp-content/plugins/cheetahmail/img/_content_perso.png"> '.strtoupper(__('sub_sub_menu_hashtags', DOMAIN_PLUGIN)).'</li>';
				// $return_txt .= '<li id="elt_4" class="heading_elt"><img src="../wp-content/plugins/cheetahmail/img/_infos.png"> '.strtoupper(__('sub_sub_menu_infos', DOMAIN_PLUGIN)).'</li>';
				$return_txt .= '</ul>';
				$return_txt .= '</div>';


				
				$return_txt .= '<div id="listContainer" class="list-container">';
				
					
					
					$return_txt .= '<div id="referred_0" class="toggelize">';

						// $return_txt .= '<div id="slider_0" class="slider active">';
							// $return_txt .=  __('settings_title_1',DOMAIN_PLUGIN) ;
						// $return_txt .= '</div>';
						
						
						$return_txt .= '<h5 class="infos">' . __('c_title_1',DOMAIN_PLUGIN) . '</h5>';
						$return_txt .= '<p class="little_text">' ;
						$return_txt .= __('c_content_1_1',DOMAIN_PLUGIN) ;
						$return_txt .= '<br /><br />' ;
						$return_txt .=  __('c_content_1_2',DOMAIN_PLUGIN) ;
						$return_txt .= '</p>';

						
						$return_txt .= '<div id="sliding_0" class="">';
							// API DATABASE ID
							$return_txt .= '<p>';
								$return_txt .= '<label for="idmlist">' . __('settings_form_idmlist',DOMAIN_PLUGIN) . '<span class="required"> *</span></label>';
								$return_txt .= '<input readonly="readonly" class="tipsyer" original-title="' . __('settings_form_tooltip_idmlist',DOMAIN_PLUGIN) . '" type="text" id="idmlist" maxlength="10" tabindex="1" value="' . $oIdlist . '" name="cheetahmail_api_idmlist"  />';
							$return_txt .= '</p>';   
							
							// API LOGIN
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_login">' . __('settings_form_login',DOMAIN_PLUGIN) . '<span class="required"> *</span></label>';
								$return_txt .= '<input readonly="readonly" class="tipsyer" original-title="' . __('settings_form_tooltip_login',DOMAIN_PLUGIN) . '" type="text" id="ws_login" maxlength="50" tabindex="2" value="' . $oLogin . '" name="cheetahmail_api_login"   />';
							$return_txt .= '</p>';                    
										  
							// API KEY
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_password">' . __('settings_form_key',DOMAIN_PLUGIN) . ' <span class="required"> *</span></label>';
								$return_txt .= '<input class="tipsyer"  readonly="readonly" original-title="' . __('settings_form_tooltip_key',DOMAIN_PLUGIN) . '" type="text" id="ws_password" tabindex="3" maxlength="50" value="' . $oPassword . '" name="cheetahmail_api_key"  />';
							$return_txt .= '</p>';                            
						$return_txt .= '</div>';

						
						// bouton REINSTALLATION
						$return_txt .= '<p>';
							$return_txt .= '<span class="valid"><input disabled="disabled" class="validation" type="button" value="' . __('Reinstallation',DOMAIN_PLUGIN) . '" id="submit_change_api_key" /></span>';
						$return_txt .= '</p>';
						
						
						
					$return_txt .= '</div>';
					
				







				
					
					$return_txt .= '<div id="referred_1" class="toggelize" style="display:none">';
						
						
						
						$return_txt .= '<div id="slider_1" class="slider active">';
							$return_txt .=  __('settings_title_2',DOMAIN_PLUGIN) ;
						$return_txt .= '</div>';
						

						

					// champs cach&eacute;s des API en cours et valides 
					$return_txt .= '<input type="hidden" id="valid_idmlist" value="' . $oIdlist . '" />';
					$return_txt .= '<input type="hidden" id="valid_ws_login" value="' . $oLogin . '" />';
					$return_txt .= '<input type="hidden" id="valid_ws_password" value="' . $oPassword . '" />';
											

			
			
						
						
						
						
						
						
						
						$return_txt .= '<div id="sliding_1" class="sliding">';						
							// DATE DISPLAY LANG 
							$return_txt .= '<p> <label>' . __('settings_form_blog_lang',DOMAIN_PLUGIN) . '  </label><input type="text" disabled="disabled" value="'.get_bloginfo('language').'" /></p>';
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_date_lang">' . __('settings_form_date_lang',DOMAIN_PLUGIN) . '<span class="required"> *</span></label>';
								$return_txt .= '<select class="tipsyer"  original-title="' . __('settings_form_tooltip_date_lang',DOMAIN_PLUGIN) . '" id="ws_date_lang" tabindex="10">';
									$return_txt .= '<option value="0" ';
									if($oDateLang == 0){
										// fr
										$return_txt .= ' selected="selected" ';
									}
									$return_txt .= '>JJ/MM/AAAA</option>';
								$return_txt .= '<option value="1" ';
									if($oDateLang == 1){
										// uk
										$return_txt .= ' selected="selected" ';
									}
									$return_txt .= '>MM/DD/YYYY</option>';								
								$return_txt .= '</select>';
							$return_txt .= '</p>';	
							
							// SENDER DOMAIN
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_domain">' . __('settings_form_domain',DOMAIN_PLUGIN) . ' <span class="required"> *</span></label>';
								$return_txt .= '<select class="tipsyer"  original-title="' . __('settings_form_tooltip_domain',DOMAIN_PLUGIN) . '" id="ws_domain" tabindex="4">';
									$return_txt .= $MyEMST -> listDomain($oDkim);
								$return_txt .= '</select>';
							$return_txt .= '</p>';	
		
							//  SHORTCODES ENABLE STYLE
							$return_txt .= '<p>';
								$return_txt .= '<label tabindex="12" original-title="'. __('settings_form_tooltip_autostyle',DOMAIN_PLUGIN) . '" class="tipsyer" for="ws_shortcodes_style">';
								$return_txt .= '' . __('settings_form_autostyle',DOMAIN_PLUGIN);
								$return_txt .= '<span class="required"> *</span>';
								$return_txt .= '</label>';
								$return_txt .= '<input type="checkbox" ';
								if($tab_config_values['CMFR__shortcodes_style'] == 1){
									$return_txt .= ' checked="checked" ';
								}
								$return_txt .= ' id="ws_shortcodes_style" />';
							$return_txt .= '</p>';
						
							// PAGE EMAIL ANALYTICS
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_ea" class="tipsyer"  original-title="' . __('settings_form_tooltip_ea',DOMAIN_PLUGIN) . '" tabindex="11">' . __('settings_form_ea',DOMAIN_PLUGIN) . ' <span class="required"> *</span></label>';
								$return_txt .= '<input';
								if($oEA){
									$return_txt .= ' checked="checked" ';
								}
								$return_txt .= ' type="checkbox" id="ws_ea">';
								$return_txt .= '';
							$return_txt .= '</p>';	


							$dbl = $MyEMST -> listDoubleTracking($oDblTrack);

							// DOUBLE TRACKING
							$return_txt .= '<p>';
								$return_txt .= '<label tabindex="13" original-title="'. __('settings_form_tooltip_doubletracking',DOMAIN_PLUGIN) . '" class="tipsyer" for="ws_doubletracking">';
								$return_txt .= '' . __('settings_form_doubletracking',DOMAIN_PLUGIN);
								$return_txt .= '<span class="required"> *</span>';
								$return_txt .= '</label>';
								$return_txt .= '<input style="float:left" type="checkbox" ';
								if($oDblTrack_enlabled == 1){
									$return_txt .= ' checked="checked" ';
								}
								if(strlen($dbl)< 2 ){
									$return_txt .= ' disabled="disabled" ';
								}
								$return_txt .= ' id="ws_doubletracking" />';
								if(strlen($dbl)< 2 ){
									$return_txt .= '<select style="display:none" id="ws_doubletracking_id" tabindex="4">';
										$return_txt .= '<option value="0"></option>';
									$return_txt .= '</select>';
								}
								else
								{
									$return_txt .= '<select id="ws_doubletracking_id" tabindex="4">';
										$return_txt .= $dbl;
									$return_txt .= '</select>';								
								}
							$return_txt .= '</p>';	
		



							
							
						$return_txt .= '</div>';
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						$return_txt .= '<div id="slider_3" class="slider">';
							$return_txt .=  __('settings_title_4',DOMAIN_PLUGIN) ;
						$return_txt .= '</div>';
						
						$return_txt .= '<div id="sliding_3" class="sliding" style="display:none">';												
							// GESTION CIBLE BAT
							$return_txt .= '<p>';
								$return_txt .= '<label for="batquery_emails">' . __('settings_form_battarget',DOMAIN_PLUGIN) . ' <span class="required"> *</span></label>';
								$return_txt .= '<textarea class="tipsyer"  original-title="' . __('settings_form_tooltip_battarget',DOMAIN_PLUGIN) . '" id="batquery_emails" tabindex="8">' . $oBATQueryEmails .'</textarea>';
							$return_txt .= '</p>';	

							// GESTION EMAIL PREVIEW
							$return_txt .= '<p>';
								$return_txt .= '<label for="email_preview">' . __('settings_form_email_preview',DOMAIN_PLUGIN) . ' <span class="required"> *</span></label>';
								$return_txt .= '<input type="text" class="tipsyer"  original-title="' . __('settings_form_tooltip_email_preview',DOMAIN_PLUGIN) . '" id="email_preview" tabindex="8" value="' . $oEMailPreview .'" />';
							$return_txt .= '</p>';	
							
						$return_txt .= '</div>';
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						$return_txt .= '<div id="slider_4" class="slider">';
							$return_txt .=  __('settings_title_5',DOMAIN_PLUGIN) ;
						$return_txt .= '</div>';
						
						$return_txt .= '<div id="sliding_4" class="sliding" style="display:none">';
						
							
							// PAGE ABO
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_abo">' . __('settings_form_subslink',DOMAIN_PLUGIN) . '<span class="required"> *</span></label>';
								$return_txt .= '<select class="tipsyer"  original-title="' . __('settings_form_tooltip_subslink',DOMAIN_PLUGIN) . '" id="ws_abo" tabindex="10">';
									$return_txt .= $MyEMST -> getListPages($oIdUrlAbo,2);
								$return_txt .= '</select>';								
							$return_txt .= '</p>';	
							
							// $return_txt .= '<p><br /><br /></p>';
						
							// INTRO
							// $return_txt .= '<h5 class="unsubs">' . __('c_title_4',DOMAIN_PLUGIN) . '</h5>';
							$return_txt .= '<p class="little_text">' . __('c_content_4_1',DOMAIN_PLUGIN) . '</p>';					
				
			
							// PAGE DE DESABO
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_desabo">' . __('settings_form_unsubslink',DOMAIN_PLUGIN) . '<span class="required"> *</span></label>';
								$return_txt .= '<select class="tipsyer"  original-title="' . __('settings_form_tooltip_unsubslink',DOMAIN_PLUGIN) . '" id="ws_desabo" tabindex="9">';
									$return_txt .= $MyEMST -> getListPages($oTrackLinkWp,1);
								$return_txt .= '</select>';
							$return_txt .= '</p>';	
							
							// TEXT BEFORE DESABO
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_unsubs_text_top">' . __('settings_form_unsubstxtbefore',DOMAIN_PLUGIN) . '<span class="required"> *</span></label>';
								$return_txt .= '<textarea class="tipsyer" id="ws_unsubs_text_top" tabindex="9" original-title="' . __('settings_form_tooltip_unsubstxtbefore',DOMAIN_PLUGIN) . '" >'.$oUnsubsTextTop.'</textarea>';
							$return_txt .= '</p>';	
							

							
							// TEXT LINK
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_unsubs_text_link">' . __('settings_form_unsubstxtlink',DOMAIN_PLUGIN) . '<span class="required"> *</span></label>';
								$return_txt .= '<input type="text" class="tipsyer" id="ws_unsubs_text_link" tabindex="9" original-title="' . __('settings_form_tooltip_unsubstxtlink',DOMAIN_PLUGIN) . '" value="'.$oUnsubsTextLink.'" />';
							$return_txt .= '</p>';
							
							// TEXT AFTER DESABO
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_unsubs_text_bottom">' . __('settings_form_unsubstxtafter',DOMAIN_PLUGIN) . '<span class="required"> *</span></label>';
								$return_txt .= '<textarea class="tipsyer" id="ws_unsubs_text_bottom" tabindex="9" original-title="' . __('settings_form_tooltip_unsubstxtafter',DOMAIN_PLUGIN) . '" >'.$oUnsubsTextBottom.'</textarea>';
							$return_txt .= '</p>';	


							
						$return_txt .= '</div>';
						
					

	
		

						
						$return_txt .= '<div id="slider_2" class="slider">';
							$return_txt .=  __('settings_title_3',DOMAIN_PLUGIN) ;
						$return_txt .= '</div>';
						
						$return_txt .= '<div id="sliding_2" class="sliding" style="display:none">';							
						
						// INTRO
						// $return_txt .= '<h5 class="wording">' . __('c_title_2',DOMAIN_PLUGIN) . '</h5>';
						$return_txt .= '<p class="little_text">' . __('c_content_2_1',DOMAIN_PLUGIN) . '</p>';
						
						
						
						
						// PREFIXE TARGETS
							$return_txt .= '<p>';
								$return_txt .= '<label for="prefix_target">' . __('settings_form_prefixtarget',DOMAIN_PLUGIN) . ' <span class="required"> *</span></label>';
								$return_txt .= '<input class="tipsyer" readonly="readonly"  original-title="' . __('settings_form_tooltip_prefixtarget',DOMAIN_PLUGIN) . '" type="text" id="prefix_target" tabindex="5" maxlength="10" value="' . $oTargetPrefix . '"   />';
							$return_txt .= '</p>';	
							
							
							// PREFIXE CAMPAGNES NL
							$return_txt .= '<p>';
								$return_txt .= '<label for="prefix_nl">' . __('settings_form_prefixnl',DOMAIN_PLUGIN) . ' <span class="required"> *</span></label>';
								$return_txt .= '<input class="tipsyer" readonly="readonly"  original-title="' . __('settings_form_tooltip_prefixnl',DOMAIN_PLUGIN) . '" type="text" id="prefix_nl" tabindex="5" maxlength="10" value="' . $oNLPrefix . '"   />';
							$return_txt .= '</p>';	

							// PREFIXE CAMPAGNE EMAIL
							$return_txt .= '<p>';
								$return_txt .= '<label for="prefix_email">' . __('settings_form_prefixemail',DOMAIN_PLUGIN) . ' <span class="required"> *</span></label>';
								$return_txt .= '<input class="tipsyer" readonly="readonly"  original-title="' . __('settings_form_tooltip_prefixemail',DOMAIN_PLUGIN) . '" type="text" id="prefix_email" tabindex="6" maxlength="10" value="' . $oCampPrefix . '"   />';
							$return_txt .= '</p>';	

							

							// PREFIXE BAT
							$return_txt .= '<p>';
								$return_txt .= '<label for="prefix_bat">' . __('settings_form_prefixbat',DOMAIN_PLUGIN) . ' <span class="required"> *</span></label>';
								$return_txt .= '<input class="tipsyer" readonly="readonly"  original-title="' . __('settings_form_tooltip_prefixbat',DOMAIN_PLUGIN) . '" type="text" id="prefix_bat" tabindex="7" maxlength="10" value="' . $oBATPrefix . '"   />';
							$return_txt .= '</p>';	

						$return_txt .= '</div>';
						
						
						
						



						


							
						// bouton soumission
						$return_txt .= '<p>';
							$return_txt .= '<span class="valid"><input class="validation" type="button" value="' . __('Save changes',DOMAIN_PLUGIN) . '" id="submit_update_settings" /></span>';
						$return_txt .= '</p>';
						
					$return_txt .= '</div>';	
					$return_txt .= '<div id="referred_2" class="toggelize" style="display:none">';
						$return_txt .= '<div id="return_table_structure"></div>';
					$return_txt .= '</div>';	

					$return_txt .= '<div id="referred_3" class="toggelize" style="display:none">';

						$return_txt .= '<h5 class="perso">' . __('c_title_5',DOMAIN_PLUGIN) . '</h5>';
						$return_txt .= '<p class="little_text">' . __('c_content_5_1',DOMAIN_PLUGIN) . '</p>';
						
						$return_txt .= '<ul class="static_content">';
							$return_txt .= '<li>' . __('c_content_5_2',DOMAIN_PLUGIN) . '</li>';
							$return_txt .= '<li>' . __('c_content_5_3',DOMAIN_PLUGIN) . '</li>';
							$return_txt .= '<li>' . __('c_content_5_4',DOMAIN_PLUGIN) . '</li>';
							$return_txt .= '<li>' . __('c_content_5_5',DOMAIN_PLUGIN) . '</li>';
						$return_txt .= '</ul>';
						
					$return_txt .= '</div>';





					
				$return_txt .= '</div>';
			$return_txt .= '</div>';
			
			$return_txt .= '<div class="experian_wrapper_footer">';
				$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/footer-bg-left.png" />';
				$return_txt .= '<img class="float_right" src="../wp-content/plugins/cheetahmail/img/footer-bg-right.png" />';
			$return_txt .= '</div>';

				
		$return_txt .= '</div>';					
	$return_txt .= '</div>';//outter					
	echo $return_txt;
	}
	
		
	// function appell&eacute;e par le menu SUBSCRIPTIONS / UNSUBSCRIPTIONS
	function subscriptions_plugin_view()
	{	
		$tab_config_values = getVar();
		$oIdlist = $tab_config_values['CMFR__api_idmlist'];
		$oLogin = $tab_config_values['CMFR__api_login'];
		$oPassword = $tab_config_values['CMFR__api_password'];
		$oDkimId = $tab_config_values['CMFR__api_dkim_id'];
		$oDkimLabel = $tab_config_values['CMFR__api_dkim_label'];
		$oSubsConfig = $tab_config_values['CMFR__idconf_subs'];
		$oUnsubsConfig = $tab_config_values['CMFR__idconf_unsubs'];
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
		$return_txt ='';
		$return_txt .= include(dirname( __FILE__ ) . '/fn/js.php');
		$return_txt .= '<div class="experian_wrapper_outter">';
		$return_txt .= '<div class="experian_wrapper">';
			$return_txt .= '<div class="experian_logo">';
				$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/logo.png" />';
			$return_txt .= '</div>';
			
			
			$return_txt .= '<div class="navigation-top float">';                
				$return_txt .= '<ul class="main-menu">';						
					$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=settings"><span>'.__('menu_settings', DOMAIN_PLUGIN).'</span></a></li>';
					$return_txt .= '<li class="main-menu-item active"><a href="admin.php?page=subscriptions"><span>'.__('menu_subscriptions', DOMAIN_PLUGIN).'</span></a></li>';  
					$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=newsletters"><span>'.__('menu_newsletters', DOMAIN_PLUGIN).'</span></a></li>'; 
					$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=emails"><span>'.__('menu_emailing', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=templates"><span>'.__('menu_templates', DOMAIN_PLUGIN).'</span></a></li>';
					$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=targets"><span>'.__('menu_targets', DOMAIN_PLUGIN).'</span></a></li>'; 					
				$return_txt .= '</ul>';
				$return_txt .= '<ul class="sub-menu">';				
					$return_txt .= '<li class="sub-menu-item"><a id="1" class="active" href="#">'.__('sub_menu_subcription', DOMAIN_PLUGIN).'</a></li>';
					$return_txt .= '<li class="sub-menu-item"><a id="2" href="#">'.__('sub_menu_unsubcription', DOMAIN_PLUGIN).'</a></li>';
					$return_txt .= '<li class="sub-menu-item"><a id="3" href="#">'.__('sub_menu_subscribers', DOMAIN_PLUGIN).'</a></li>';
					$return_txt .= '<li class="sub-menu-item"><a id="4" href="#">'.__('sub_menu_sync', DOMAIN_PLUGIN).'</a></li>';           
				$return_txt .= '</ul>';			
			$return_txt .= '</div>';
		
		
		
		
			$return_txt .= '<div class="experian_wrapper_inner">'; // wrapper blanc
			
				$return_txt .= '<h2 class="subs"><span>'.__('menu_subscriptions', DOMAIN_PLUGIN).'</span></h2>'; // h2 page
				
				$return_txt .= '<div class="form_wrapper">';	
				// SUBSCRIPTIONS			
					$return_txt .= '<div id="return_table_config_infos_1" class="container c_1"></div>';								
					// UNSUBSCRIPTIONS
					$return_txt .= '<div id="return_table_config_infos_2" class="container c_2" style="display:none"></div>';
					//  LISTING
					$return_txt .= '<div id="referred_1" class="toggelize" style="">';
						$return_txt .= '<div id="return_table_subscribers_infos" class="container c_3" style="display:none"></div>';
					$return_txt .= '</div>';
					//  SYNCHRONIZE USERS FROM WP
					$return_txt .= '<div id="referred_2" class="toggelize" style="">';
						$return_txt .= '<div id="return_table_users_infos" class="container c_4" style="display:none">';
							$return_txt .= '<div class="filter-menu-container">';
								$return_txt .= '<ul class="filter-menu frequencies-filter heading">';			
									$return_txt .= '<li class="heading_elt active" id="elt_1"><img src="../wp-content/plugins/cheetahmail/img/_icon_users.png" /> '.strtoupper(__('sub_sub_menu_synchronize', DOMAIN_PLUGIN)).'</li>';
								$return_txt .= '</ul>';								
							$return_txt .= '</div>';
							$return_txt .= '<div class="list-container" id="listContainer">';
								$return_txt .= '<div id="referred_1" class="toggelize" style="">';
									$return_txt .= '<p><span class="valid decale"><input type="button" value="'.__('rsc_content_sync_btn', DOMAIN_PLUGIN).'" id="sync_users_from_wp" class="sync" /></span></p>';
									$return_txt .= '<p>&nbsp; </p>'; 		
									$return_txt .= '</div>'; 
									$return_txt .= '<div id="new_users_added">'; 
								$return_txt .= '</div>'; 	
							$return_txt .= '</div>'; 
							
						$return_txt .= '</div>';
					$return_txt .= '</div>';
				$return_txt .= '</div>';				

			$return_txt .= '</div>'; 					

			
		
		$return_txt .= '<div class="experian_wrapper_footer">';
			$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/footer-bg-left.png" />';
			$return_txt .= '<img class="float_right" src="../wp-content/plugins/cheetahmail/img/footer-bg-right.png" />';
		$return_txt .= '</div>';	
		
		$return_txt .= '</div>'; // fin div experian		
	$return_txt .= '</div>'; // fin outter
	echo $return_txt;
	}


	// function appell&eacute;e par le menu NEWSLETTERS
	function newsletters_plugin_view()
	{						
		$tab_config_values = getVar();
		$oIdlist = $tab_config_values['CMFR__api_idmlist'];
		$oLogin = $tab_config_values['CMFR__api_login'];
		$oPassword = $tab_config_values['CMFR__api_password'];		
		$oDkimId = $tab_config_values['CMFR__api_dkim_id'];
		$oDkimLabel = $tab_config_values['CMFR__api_dkim_label'];		
		$oNLConfig = $tab_config_values['CMFR__idconf_nl'];
		$oNLActivation = $tab_config_values['CMFR__nl_activation'];
		
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
		$oNLConfigsInfos = $MyEMST->GetConfigById($oNLConfig);		
		
		$return_txt ='';
		$return_txt .= include(dirname( __FILE__ ) . '/fn/js.php');
		$return_txt .= '<div class="experian_wrapper_outter">';
		$return_txt .= '<div class="experian_wrapper">';
		$return_txt .= '<div class="experian_logo">';
			$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/logo.png" />';
		$return_txt .= '</div>';
		

		
		$return_txt .= '<div class="navigation-top float">'; 

			$return_txt .= '<ul class="main-menu">';						
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=settings"><span>'.__('menu_settings', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=subscriptions"><span>'.__('menu_subscriptions', DOMAIN_PLUGIN).'</span></a></li>';  
				$return_txt .= '<li class="main-menu-item active"><a href="admin.php?page=newsletters"><span>'.__('menu_newsletters', DOMAIN_PLUGIN).'</span></a></li>'; 
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=emails"><span>'.__('menu_emailing', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=templates"><span>'.__('menu_templates', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=targets"><span>'.__('menu_targets', DOMAIN_PLUGIN).'</span></a></li>'; 					
			$return_txt .= '</ul>';

			$return_txt .= '<ul class="sub-menu">';
				$return_txt .= '<li class="sub-menu-item"><a id="1" class="active" href="#">'.__('sub_menu_envelop', DOMAIN_PLUGIN).'</a></li>';
				$return_txt .= '<li class="sub-menu-item"><a id="2" href="#">'.__('sub_menu_settings', DOMAIN_PLUGIN).'</a></li>';
				$return_txt .= '<li class="sub-menu-item" id="sub_nl_elt"><a id="3" href="#">'.__('sub_menu_preview_nl', DOMAIN_PLUGIN).'</a></li>';				
				$return_txt .= '<li class="sub-menu-item"><a id="4" href="#">'.__('sub_menu_historic_nl', DOMAIN_PLUGIN).'</a></li>';
			$return_txt .= '</ul>';			
		$return_txt .= '</div>';
		
		
		
		
		$return_txt .= '<div class="experian_wrapper_inner">';
			$return_txt .= '<h2 class="newsletters"><span>'.__('menu_newsletters', DOMAIN_PLUGIN).'</span></h2>';
			$return_txt .= '<div class="form_wrapper">';	
			$return_txt .= '<div class="container c_1">';	
				$return_txt .= '<div id="return_table_config_infos_3"></div>';
			$return_txt .= '</div>';	
			
					



					
				$return_txt .= '<div class="container c_2" style="display:none">';	
					$return_txt .= '<div class="filter-menu-container">';
						$return_txt .= '<ul class="filter-menu frequencies-filter heading">';
							$return_txt .= '<li class="heading_elt active" id="elt_5"><img src="../wp-content/plugins/cheetahmail/img/_icon_settings.png" /> '.strtoupper(__('sub_sub_menu_settings', DOMAIN_PLUGIN)).'</li>';
							$return_txt .= '<li class="heading_elt" id="elt_6"><img src="../wp-content/plugins/cheetahmail/img/_icon_style.png" /> '.strtoupper(__('sub_sub_menu_style', DOMAIN_PLUGIN)).'</li>';
							$return_txt .= '<li class="heading_elt" id="elt_7"><img src="../wp-content/plugins/cheetahmail/img/_magnify_on.png" /> '.strtoupper(__('sub_sub_menu_preview', DOMAIN_PLUGIN)).'</li>';
						$return_txt .= '</ul>';								
					$return_txt .= '</div>';

					$return_txt .= '<div id="listContainer" class="list-container">';	
						$return_txt .= '<div id="referred_5" class="toggelize">';	
							$return_txt .= '<div id="return_table_settings_nl" ></div>';
						$return_txt .= '</div>';
					
						$return_txt .= '<div id="referred_6" class="toggelize" style="display:none">';	
							$return_txt .= '<div id="return_table_style_nl" ></div>';
						$return_txt .= '</div>';
						
						$return_txt .= '<div id="referred_7" class="toggelize" style="display:none">';	
							$return_txt .= '<div id="return_table_preview_style_nl" ></div>';
						$return_txt .= '</div>';
						
					$return_txt .= '</div>';
					
				$return_txt .= '</div>';
				
				$return_txt .= '<div class="container c_3" style="display:none">';	
						$return_txt .= '<div id="return_table_elements_nl"></div>';		
				$return_txt .= '</div>';
				
				$return_txt .= '<div class="container c_4" style="display:none">';					
						$return_txt .= '<div id="return_table_sent_nl"></div>';
				$return_txt .= '</div>';

			
			$return_txt .= '</div>';

			
		$return_txt .= '</div>'; // fin experian wrapper
		
		$return_txt .= '<div class="experian_wrapper_footer">';
			$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/footer-bg-left.png" />';
			$return_txt .= '<img class="float_right" src="../wp-content/plugins/cheetahmail/img/footer-bg-right.png" />';
		$return_txt .= '</div>';
		$return_txt .= '</div>'; // fin outter
	
		echo $return_txt;
	}
	

	// function appell&eacute;e par le menu EMAILINGS
	function emailings_plugin_view()
	{				
		// on recup toute la config
		$tab_config_values = getVar();						
		$oIdlist = $tab_config_values['CMFR__api_idmlist'];
		$oLogin = $tab_config_values['CMFR__api_login'];
		$oPassword = $tab_config_values['CMFR__api_password'];		
		$oDkimId = $tab_config_values['CMFR__api_dkim_id'];
		$oDkimLabel = $tab_config_values['CMFR__api_dkim_label'];		
		$oEmailConfig = $tab_config_values['CMFR__idconf_campaign'];		
		// on instancie notre client
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);

		// on recupere les infos de la config Email
		$oEmailConfigsInfos = $MyEMST->GetConfigById($oEmailConfig);
		
		$return_txt ='';
		$return_txt .= include(dirname( __FILE__ ) . '/fn/js.php');
		$return_txt .= '<div class="experian_wrapper_outter">';
		$return_txt .= '<div class="experian_wrapper">';
		$return_txt .= '<div class="experian_logo">';
			$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/logo.png" />';
		$return_txt .= '</div>';
		

		
		$return_txt .= '<div class="navigation-top float">';  


			$return_txt .= '<ul class="main-menu">';						
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=settings"><span>'.__('menu_settings', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=subscriptions"><span>'.__('menu_subscriptions', DOMAIN_PLUGIN).'</span></a></li>';  
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=newsletters"><span>'.__('menu_newsletters', DOMAIN_PLUGIN).'</span></a></li>'; 
				$return_txt .= '<li class="main-menu-item active"><a href="admin.php?page=emails"><span>'.__('menu_emailing', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=templates"><span>'.__('menu_templates', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=targets"><span>'.__('menu_targets', DOMAIN_PLUGIN).'</span></a></li>'; 					
			$return_txt .= '</ul>';
			

			$return_txt .= '<ul class="sub-menu">';
				$return_txt .= '<li class="sub-menu-item"><a id="1" class="active" href="#">'.__('sub_menu_envelop', DOMAIN_PLUGIN).'</a></li>';
				$return_txt .= '<li class="sub-menu-item"><a id="3" href="#">'.__('sub_menu_campaigns', DOMAIN_PLUGIN).'</a></li>';
			$return_txt .= '</ul>';		
		$return_txt .= '</div>';
		
		$return_txt .= '<div class="experian_wrapper_inner">';
			$return_txt .= '<h2 class="emailings"><span>'.__('menu_emailing', DOMAIN_PLUGIN).'</span></h2>';
			$return_txt .= '<div class="form_wrapper">';			
						
/*
******************************************************************
VUE DE LA CONFIGURATION
******************************************************************
*/	
	
				$return_txt .= '<div class="container c_1">';				
					$return_txt .= '<div id="return_table_config_infos_4"></div>';				
				$return_txt .= '</div>';			
	

/*
******************************************************************
VUE DES CAMPAGNES
******************************************************************
*/


				$return_txt .= '<div class="container c_3" style="display:none">';

			
				$return_txt .= '<div class="filter-menu-container">';

					$return_txt .= '<ul class="filter-menu frequencies-filter heading">';
						$return_txt .= '<li class="heading_elt active" id="elt_1"><img src="../wp-content/plugins/cheetahmail/img/state_not_sent.png" /> ' . strtoupper(__('sub_sub_menu_list_camp',DOMAIN_PLUGIN)) . '</li>';
						$return_txt .= '<li class="heading_elt" id="elt_2"><img src="../wp-content/plugins/cheetahmail/img/state_finished.png" /> ' . strtoupper(__('sub_sub_menu_list_sentcamp',DOMAIN_PLUGIN)) . '</li>';
						$return_txt .= '<li class="heading_elt" id="elt_3"><img src="../wp-content/plugins/cheetahmail/img/state_bat_finished.png" /> ' . strtoupper(__('sub_sub_menu_list_senttest',DOMAIN_PLUGIN)) .' </li>';
						$return_txt .= '<li class="heading_elt" id="elt_4"><img src="../wp-content/plugins/cheetahmail/img/_icon_add.png" /> ' . strtoupper(__('sub_sub_menu_newcamp',DOMAIN_PLUGIN)) . '</li>';
					$return_txt .= '</ul>';								
				$return_txt .= '</div>';

				$return_txt .= '<div id="listContainer" class="list-container">';
					
					$return_txt .= '<div id="referred_1" class="toggelize">';
						$return_txt .= '<div id="return_table_preparing_campaigns"></div>';
					$return_txt .= '</div>';
								
					$return_txt .= '<div id="referred_2" class="toggelize" style="display:none">';
						$return_txt .= '<div id="return_table_sent_campaigns"></div>';
					$return_txt .= '</div>';
					
					$return_txt .= '<div id="referred_3" class="toggelize" style="display:none">';
						$return_txt .= '<div id="return_table_sent_bat"></div>';
					$return_txt .= '</div>';
					
					$return_txt .= '<div id="referred_4" class="toggelize" style="display:none">';

						$return_txt .= '<div class="half_page">';
							$return_txt .= '<p class="">';
								$return_txt .= '<label for="ws_name_campaign">'.__('camp_rsc_name',DOMAIN_PLUGIN).' <span class="required"> *</span></label>';
								$return_txt .= '<input class="tipsyer" original-title="'.__('camp_rsc_tooltip_name',DOMAIN_PLUGIN).'" type="text" id="ws_name_campaign"  maxlength="250" tabindex="1" value="" />';
							$return_txt .= '</p>'; 
						$return_txt .= '</div>';
						$return_txt .= '<div class="half_page">';
							$return_txt .= '<p class="">';
								$return_txt .= '<label for="campaign_subject">'.__('camp_rsc_subject',DOMAIN_PLUGIN).' <span class="required"> *</span></label>';
								$return_txt .= '<input class="tipsyer" original-title="'.__('camp_rsc_tooltip_subject',DOMAIN_PLUGIN).'" type="text" id="campaign_subject"  maxlength="250" tabindex="1" value="" />';
							$return_txt .= '</p>'; 
						$return_txt .= '</div>';
					
						
						// oNLIdQuery
						$return_txt .= '<div class="alternate_style_full">';
							$return_txt .= '<p>';
								$return_txt .= '<label for="ws_target">'.__('camp_rsc_target',DOMAIN_PLUGIN).'<span class="required"> *</span></label>';
									$return_txt .= '<select id="ws_target">';
										$return_txt .= $MyEMST -> GetTargetsListSelect($oNLIdQuery);
									$return_txt .= ' </select>';
							$return_txt .= '</p>'; 
						$return_txt .= '</div>'; 
						
			
						// chargement template
						$return_txt .= '<div>';
							$return_txt .= '<label for="ws_tpl_upload_campaign">'.__('camp_rsc_uploadtpl',DOMAIN_PLUGIN).' <span class="required"> *</span></label>';
							
							$list_tpl = $MyEMST -> GetTemplatesList();
							
							$return_txt .= '<span class="valid-light"><input type="button" value="'.__('rsc_standard_load',DOMAIN_PLUGIN).'" title="add" class="load" id="load_tpl" /></span>';
							$return_txt .= '<img id="loading_area_tpl" style="display:none;float:right" src="../wp-content/plugins/cheetahmail/img/link-loader.gif" /> ';
							$return_txt .= '<select class="tipsyer half" original-title="2" id="ws_tpl_upload_campaign" tabindex="2">';

								$return_txt .= '<option selected="selected" value="-1">'.__('camp_rsc_choosetpl',DOMAIN_PLUGIN).'</option>';
							if(!empty($list_tpl) && count($list_tpl)>0){
								// plusieurs resultats
								
								foreach($list_tpl as $line){
									$return_txt .= '<option value="' . $line['id'] . '">'.$line['name'] . ' (' .$line['date'].')</option>';
								}
							}else{
								// un seul resultat					
							}			
							$return_txt .= '</select>';
							
							
						$return_txt .= '</div>';  

						
						// version code custom
						$return_txt .= '<div>';
							$return_txt .= '<div class="alternate_style_full">';
								$return_txt .= '<p><label class="full" for="campaign_html">'.__('rsc_standard_html',DOMAIN_PLUGIN).' <span class="required"> *</span></label></p>';
								$return_txt .= '<textarea class="tipsyer rich-editor" original-title="'.__('rsc_standard_tooltip_html',DOMAIN_PLUGIN).'" name="campaign_html_add" id="campaign_html" tabindex="3"></textarea>';
							$return_txt .= '</div>';  

							$return_txt .= '<p class="alternate_style_full">';
								$return_txt .= '<label for="campaign_txt">'.__('rsc_standard_txt',DOMAIN_PLUGIN).'<span class="required"> *</span> <span class="valid-light"><input type="button" id="generate_txt" value="'.__('rsc_standard_tooltip_htmltotxt',DOMAIN_PLUGIN).'" class="load" /></span> </label>';
								$return_txt .= '<textarea class="tipsyer" original-title="'.__('rsc_standard_tooltip_txt',DOMAIN_PLUGIN).'" id="campaign_txt" tabindex="4"></textarea>';
							$return_txt .= '</p>'; 
						$return_txt .= '</div>';					

						// bouton soumission
						$return_txt .= '<p class="alternate_style_full">';
							$return_txt .= '<span class="valid"><input class="validation" type="button" value="' . __('rsc_standard_add',DOMAIN_PLUGIN) . '" id="submit_add_campaign" /></span>';
						$return_txt .= '</p>';
						$return_txt .= '<div class="loading_area" id="loading_area_camp_add" style="display:none"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/link-loader.gif" /></div></div> ';
					$return_txt .= '</div>';
					


						
					$return_txt .= '</div>';
				$return_txt .= '</div>';
			$return_txt .= '</div>';




			$return_txt .= '<div class="experian_wrapper_footer">';
				$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/footer-bg-left.png" />';
				$return_txt .= '<img class="float_right" src="../wp-content/plugins/cheetahmail/img/footer-bg-right.png" />';
			$return_txt .= '</div>';
		$return_txt .= '</div>'; // fin experian div	
	$return_txt .= '</div>'; // fin outter						
	echo $return_txt;
	}


	// function appell&eacute;e par le menu TARGETS
	function templates_plugin_view()
	{				
		// on recup toute la config
		$tab_config_values = getVar();						
		$oIdlist = $tab_config_values['CMFR__api_idmlist'];
		$oLogin = $tab_config_values['CMFR__api_login'];
		$oPassword = $tab_config_values['CMFR__api_password'];		
		$oDkimId = $tab_config_values['CMFR__api_dkim_id'];
		$oDkimLabel = $tab_config_values['CMFR__api_dkim_label'];			
		// on instancie notre client
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);

		$return_txt ='';
		$return_txt .= include(dirname( __FILE__ ) . '/fn/js.php');
		$return_txt .= '<div class="experian_wrapper_outter">';
		$return_txt .= '<div class="experian_wrapper">';
		$return_txt .= '<div class="experian_logo">';
			$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/logo.png" />';
		$return_txt .= '</div>';
		

		
		$return_txt .= '<div class="navigation-top float">';                
			$return_txt .= '<ul class="main-menu">';						
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=settings"><span>'.__('menu_settings', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=subscriptions"><span>'.__('menu_subscriptions', DOMAIN_PLUGIN).'</span></a></li>';  
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=newsletters"><span>'.__('menu_newsletters', DOMAIN_PLUGIN).'</span></a></li>'; 
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=emails"><span>'.__('menu_emailing', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item active"><a href="admin.php?page=templates"><span>'.__('menu_templates', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=targets"><span>'.__('menu_targets', DOMAIN_PLUGIN).'</span></a></li>'; 					
			$return_txt .= '</ul>';

			$return_txt .= '<ul class="sub-menu">';
				$return_txt .= '<li class="sub-menu-item"></li>';
			$return_txt .= '</ul>';		
		$return_txt .= '</div>';
		
		$return_txt .= '<div class="experian_wrapper_inner">';
			$return_txt .= '<h2 class="templates"><span>'.__('menu_templates', DOMAIN_PLUGIN).'</span></h2>';
			$return_txt .= '<div class="form_wrapper">';			
		



										
												
				/*
				******************************************************************
				VUE DES TEMPLATES
				******************************************************************
				*/
								
				$return_txt .= '<div class="container c_2">';
							
					$return_txt .= '<div class="filter-menu-container">';
						$return_txt .= '<ul class="filter-menu frequencies-filter heading">';
							$return_txt .= '<li class="heading_elt active" id="elt_1"><img src="../wp-content/plugins/cheetahmail/img/_icon_list.png" /> '.strtoupper(__('sub_sub_menu_listtpl', DOMAIN_PLUGIN)).'</li>';
							$return_txt .= '<li class="heading_elt" id="elt_2"><img src="../wp-content/plugins/cheetahmail/img/_icon_add.png" /> '.strtoupper(__('sub_sub_menu_newtpl', DOMAIN_PLUGIN)).'</li>';
						$return_txt .= '</ul>';								
					$return_txt .= '</div>';
					
					$return_txt .= '<div id="listContainer" class="list-container">';
								
						$return_txt .= '<div id="referred_1" class="toggelize">';				 
							$return_txt .= '<div id="return_table_templates"></div>';
						$return_txt .= '</div>';
													
						$return_txt .= '<div id="referred_2" class="toggelize" style="display:none">';
						
							// chargement template
							$return_txt .= '<div>';
								$return_txt .= '<img id="loading_area_tpl_tpl" style="display:none; float:right" src="../wp-content/plugins/cheetahmail/img/link-loader.gif" /> ';
								$return_txt .= '<label for="ws_tpl_upload_template">'.__('camp_rsc_uploadtpl',DOMAIN_PLUGIN).' <span class="required"> *</span></label>';
								
								$list_tpl_tpl = $MyEMST -> GetTemplatesList();
								
								$return_txt .= '<span class="valid-light"><input type="button" value="'.__('rsc_standard_load',DOMAIN_PLUGIN).'" title="add" class="load" id="load_tpl_tpl" /></span>';
								
								$return_txt .= '<select class="tipsyer half" original-title="2" id="ws_tpl_upload_template" tabindex="2">';

									$return_txt .= '<option selected="selected" value="-1">'.__('camp_rsc_choosetpl',DOMAIN_PLUGIN).'</option>';
								if(!empty($list_tpl_tpl) && count($list_tpl_tpl)>0){
									// plusieurs resultats
									
									foreach($list_tpl_tpl as $line){
										$return_txt .= '<option value="' . $line['id'] . '">'.$line['name'] . ' (' .$line['date'].')</option>';
									}
								}else{
									// un seul resultat					
								}			
								$return_txt .= '</select>';
								
								$return_txt .= '<p>&nbsp;</p>';
							$return_txt .= '</div>'; 

							
							
							
							
							
							
						
							$return_txt .= '<div class="half_page">';
								$return_txt .= '<p class="">';
									$return_txt .= '<label for="ws_name_template">'.__('tpl_rsc_name', DOMAIN_PLUGIN).' <span class="required"> *</span></label>';
									$return_txt .= '<input class="tipsyer" original-title="'.__('tpl_rsc_tooltip_name', DOMAIN_PLUGIN).'" type="text" id="ws_name_template" tabindex="1" value=""  maxlength="250" />';
								$return_txt .= '</p>'; 
							$return_txt .= '</div>';
							$return_txt .= '<div class="half_page">';
								$return_txt .= '<p class="">';
									$return_txt .= '<label for="ws_subject_template">'.__('tpl_rsc_subject', DOMAIN_PLUGIN).' <span class="required"> *</span></label>';
									$return_txt .= '<input class="tipsyer" original-title="'.__('tpl_rsc_tooltip_subject', DOMAIN_PLUGIN).'" type="text" id="ws_subject_template" tabindex="1" value="" maxlength="250" />';
								$return_txt .= '</p>'; 
							$return_txt .= '</div>';	
								$return_txt .= '<div class="alternate_style_full">';
									$return_txt .= '<p><label class="full" for="ws_html_template">'.__('rsc_standard_html', DOMAIN_PLUGIN).' <span class="required"> *</span></label></p>';
									$return_txt .= '<textarea class="tipsyer rich-editor" original-title="'.__('rsc_standard_tooltip_html', DOMAIN_PLUGIN).'" id="ws_html_template" tabindex="2"></textarea>';
								$return_txt .= '</div>';  

								$return_txt .= '<p class="alternate_style_full">';
									$return_txt .= '<label for="ws_txt_template">'.__('rsc_standard_txt', DOMAIN_PLUGIN).'<span class="required"> *</span>';
									$return_txt .= '<span class="valid-light"><input type="button" id="generate_tpl_txt" value="'.__('rsc_standard_tooltip_htmltotxt', DOMAIN_PLUGIN).'" class="load" /></span>';
									$return_txt .= '</label>';
									$return_txt .= '<textarea class="tipsyer" original-title="'.__('rsc_standard_tooltip_html', DOMAIN_PLUGIN).'" id="ws_txt_template" tabindex="3"></textarea>';
									
								$return_txt .= '</p>'; 
								
								// bouton soumission
								$return_txt .= '<p class="alternate_style_full">';
									$return_txt .= '<span class="valid"><input class="validation" type="button" value="' . __('rsc_standard_add',DOMAIN_PLUGIN) . '" id="submit_add_template" /></span>';
								$return_txt .= '</p>';								
								$return_txt .= '<div class="loading_area" id="loading_area_tpl_add" style="display:none"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div> ';							
						$return_txt .= '</div>';
						
						
					//$return_txt .= '</div>';
					


						
					$return_txt .= '</div>';
				$return_txt .= '</div>';
			$return_txt .= '</div>';




			$return_txt .= '<div class="experian_wrapper_footer">';
				$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/footer-bg-left.png" />';
				$return_txt .= '<img class="float_right" src="../wp-content/plugins/cheetahmail/img/footer-bg-right.png" />';
			$return_txt .= '</div>';
		$return_txt .= '</div>'; // fin experian div	
	$return_txt .= '</div>'; // fin outter						
	echo $return_txt;
	}

	// function appell&eacute;e par le menu TARGETS
	function targets_plugin_view()
	{				
		// on recup toute la config
		$tab_config_values = getVar();						
		$oIdlist = $tab_config_values['CMFR__api_idmlist'];
		$oLogin = $tab_config_values['CMFR__api_login'];
		$oPassword = $tab_config_values['CMFR__api_password'];		
		$oDkimId = $tab_config_values['CMFR__api_dkim_id'];
		$oDkimLabel = $tab_config_values['CMFR__api_dkim_label'];			
		// on instancie notre client
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);

		$return_txt ='';
		$return_txt .= include(dirname( __FILE__ ) . '/fn/js.php');
		$return_txt .= '<div class="experian_wrapper_outter">';
		$return_txt .= '<div class="experian_wrapper">';
		$return_txt .= '<div class="experian_logo">';
			$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/logo.png" />';
		$return_txt .= '</div>';
		

		
		$return_txt .= '<div class="navigation-top float">';                
			$return_txt .= '<ul class="main-menu">';						
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=settings"><span>'.__('menu_settings', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=subscriptions"><span>'.__('menu_subscriptions', DOMAIN_PLUGIN).'</span></a></li>';  
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=newsletters"><span>'.__('menu_newsletters', DOMAIN_PLUGIN).'</span></a></li>'; 
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=emails"><span>'.__('menu_emailing', DOMAIN_PLUGIN).'</span></a></li>';
				$return_txt .= '<li class="main-menu-item"><a href="admin.php?page=templates"><span>'.__('menu_templates', DOMAIN_PLUGIN).'</span></a></li>'; 
				$return_txt .= '<li class="main-menu-item active"><a href="admin.php?page=targets"><span>'.__('menu_targets', DOMAIN_PLUGIN).'</span></a></li>'; 					
			$return_txt .= '</ul>';

			$return_txt .= '<ul class="sub-menu">';
				$return_txt .= '<li class="sub-menu-item"></li>';
			$return_txt .= '</ul>';		
		$return_txt .= '</div>';
		
		$return_txt .= '<div class="experian_wrapper_inner">';
			$return_txt .= '<h2 class="targets"><span>'.__('menu_targets', DOMAIN_PLUGIN).'</span></h2>';
			$return_txt .= '<div class="form_wrapper">';			
		


				$return_txt .= '<div class="container c_1">';

			
				$return_txt .= '<div class="filter-menu-container">';
					$return_txt .= '<ul class="filter-menu frequencies-filter heading">';
						$return_txt .= '<li class="heading_elt active" id="elt_1"><img src="../wp-content/plugins/cheetahmail/img/_icon_list.png" />'.strtoupper(__('sub_sub_menu_listtargets', DOMAIN_PLUGIN)).'</li>';
						$return_txt .= '<li class="heading_elt" id="elt_2"><img src="../wp-content/plugins/cheetahmail/img/_icon_add.png" /> '.strtoupper(__('sub_sub_menu_newtarget', DOMAIN_PLUGIN)).'</li>';
					$return_txt .= '</ul>';								
				$return_txt .= '</div>';

				$return_txt .= '<div id="listContainer" class="list-container">';
					
					
					
					
					$return_txt .= '<div id="referred_1" class="toggelize">';
						$return_txt .= '<div id="return_table_targets"></div>';
					$return_txt .= '</div>';
									




									
					$return_txt .= '<div id="referred_2" class="toggelize" style="display:none">';

						$return_txt .= '<div class="alternate_style_full">';
							$return_txt .= '<p class="">';
								$return_txt .= '<label for="ws_name_target">' . strtoupper(__('target_rsc_name',DOMAIN_PLUGIN)) . ' <span class="required"> *</span></label>';
								$return_txt .= '<input class="tipsyer" original-title="' . __('target_rsc_tooltip_name',DOMAIN_PLUGIN) . '" type="text" id="ws_name_target"  maxlength="250" tabindex="1" value="" />';
							$return_txt .= '</p>'; 
						$return_txt .= '</div>';
					
						// liste crit&egrave;res de segmentation
						$return_txt .= '<div><br /><br />';
							$return_txt .= '<h4>' . __('target_rsc_criterias',DOMAIN_PLUGIN) . '</h4>';
							
							$def_bdd = $MyEMST->getStructureLiveForTarget();
							$return_txt .= $def_bdd;
						$return_txt .= '</div>';  

						
						// bouton soumission
						$return_txt .= '<p class="alternate_style_full">';
							$return_txt .= '<span class="valid"><input class="validation" type="button" value="' . __('rsc_standard_add',DOMAIN_PLUGIN) . '" id="submit_add_target" /></span>';
						$return_txt .= '</p>';
						$return_txt .= '<div class="loading_area" id="loading_area_camp_add" style="display:none"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div> ';
					$return_txt .= '</div>';
					


						
					$return_txt .= '</div>';
				$return_txt .= '</div>';
			$return_txt .= '</div>';




			$return_txt .= '<div class="experian_wrapper_footer">';
				$return_txt .= '<img class="float_left" src="../wp-content/plugins/cheetahmail/img/footer-bg-left.png" />';
				$return_txt .= '<img class="float_right" src="../wp-content/plugins/cheetahmail/img/footer-bg-right.png" />';
			$return_txt .= '</div>';
		$return_txt .= '</div>'; // fin experian div	
	$return_txt .= '</div>'; // fin outter						
	echo $return_txt;
	}


	
?>