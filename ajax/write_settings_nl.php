<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);

	// var newsletters
	$oNLDateLastSent = $tab_config_values['CMFR__nl_date_last_sent'];
	$oNLActivation = $tab_config_values['CMFR__nl_activation'];
	$oNLTypeElements = $tab_config_values['CMFR__nl_type_elements'];
	$oNLOrderElements = $tab_config_values['CMFR__nl_order_elements'];
	$oNLNbElements = $tab_config_values['CMFR__nl_nb_elements'];
	$oNLFrequency = $tab_config_values['CMFR__nl_frequency'];
	
	$oNLIdQuery = $tab_config_values['CMFR__idquery_nl'];
	
	$oNLTitleFontFace = $tab_config_values['CMFR__nl_title_fontface'];
	$oNLTitleColor = $tab_config_values['CMFR__nl_title_color'];
	$oNLTitleSize = $tab_config_values['CMFR__nl_title_size'];
	$oNLTitleUnderline = $tab_config_values['CMFR__nl_title_underline'];
	$oNLTitleBold = $tab_config_values['CMFR__nl_title_bold'];
	$oNLTitleItalic = $tab_config_values['CMFR__nl_title_italic'];
	$oNLTitleUppercase = $tab_config_values['CMFR__nl_title_uppercase'];
	
	$oNLContentFontFace = $tab_config_values['CMFR__nl_content_fontface'];
	$oNLContentColor = $tab_config_values['CMFR__nl_content_color'];
	$oNLContentSize = $tab_config_values['CMFR__nl_content_size'];
	$oNLContentUnderline = $tab_config_values['CMFR__nl_content_underline'];
	$oNLContentBold = $tab_config_values['CMFR__nl_content_bold'];
	$oNLContentItalic = $tab_config_values['CMFR__nl_content_italic'];
	$oNLContentUppercase = $tab_config_values['CMFR__nl_content_uppercase'];
	
	
	$oNLLinkDefaultText = $tab_config_values['CMFR__nl_link_defaulttext'];
	$oNLLinkFontFace = $tab_config_values['CMFR__nl_link_fontface'];
	$oNLLinkColor = $tab_config_values['CMFR__nl_link_color'];
	$oNLLinkSize = $tab_config_values['CMFR__nl_link_size'];
	$oNLLinkUnderline = $tab_config_values['CMFR__nl_link_underline'];
	$oNLLinkBold = $tab_config_values['CMFR__nl_link_bold'];
	$oNLLinkItalic = $tab_config_values['CMFR__nl_link_italic'];
	$oNLLinkUppercase = $tab_config_values['CMFR__nl_link_uppercase'];

	$oNLComentFontFace = $tab_config_values['CMFR__nl_coment_fontface'];
	$oNLComentColor = $tab_config_values['CMFR__nl_coment_color'];
	$oNLComentSize = $tab_config_values['CMFR__nl_coment_size'];
	$oNLComentUnderline = $tab_config_values['CMFR__nl_coment_underline'];
	$oNLComentBold = $tab_config_values['CMFR__nl_coment_bold'];
	$oNLComentItalic = $tab_config_values['CMFR__nl_coment_italic'];
	$oNLComentUppercase = $tab_config_values['CMFR__nl_coment_uppercase'];
	
	$oNLImage = $tab_config_values['CMFR__nl_image'];
	$oNLLink = $tab_config_values['CMFR__nl_link'];
	$oNLComent = $tab_config_values['CMFR__nl_coment'];
			
	// on instancie notre client
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$return_txt ='';

	if($_GET['type'] == 1){
		// cas partie configuration des NL
		
			$return_txt .= '<div class="half_page">';
				$return_txt .= '<p>';
					$return_txt .= '<label for="ws_activation">'.$oResources->rsc_content_nl_activation.'<span class="required"> *</span></label>';
						$return_txt .= '<input type="checkbox"';
						if($oNLActivation == 1){
							$return_txt .= ' checked="checked" ';
						}
						$return_txt .= ' value="1" id="ws_activation" />';
				$return_txt .= '</p>'; 
			$return_txt .= '</div>'; 

		// oNLIdQuery
			$return_txt .= '<div class="half_page">';
				$return_txt .= '<p>';
					$return_txt .= '<label for="ws_target">'.$oResources->rsc_content_nl_target.'<span class="required"> *</span></label>';
						$return_txt .= '<select id="ws_target">';
							$return_txt .= $MyEMST -> GetTargetsListSelect($oNLIdQuery);
						$return_txt .= ' </select>';
				$return_txt .= '</p>'; 
			$return_txt .= '</div>'; 



			
		$return_txt .= '<div class="half_page">';
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_type_elements">'.$oResources->rsc_content_nl_type.' <span class="required"> *</span></label>';
				$return_txt .= '<select id="ws_type_elements" class="tipsyer half" original-title="'.$oResources->rsc_content_nl_tooltip_type.'" tabindex="9">';
					$return_txt .= '<option value="0"';
					if($oNLTypeElements == 0){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>'.$oResources->rsc_content_nl_type_post.' &amp; '.$oResources->rsc_content_nl_type_page.'</option>';

					$return_txt .= '<option value="1"';
					if($oNLTypeElements == 1){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>'.$oResources->rsc_content_nl_type_post.'</option>';								

					$return_txt .= '<option value="2"';
					if($oNLTypeElements == 2){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>'.$oResources->rsc_content_nl_type_page.'</option>';								

				$return_txt .= '</select>';
			$return_txt .= '</p>'; 
		$return_txt .= '</div>';
		
		$return_txt .= '<div class="half_page">';
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_nb_elements">'.$oResources->rsc_content_nl_elt_limit.' <span class="required"> *</span></label>';
				$return_txt .= '<span class="elt_little">' . $oResources->rsc_content_nl_elt . '</span>';
				$return_txt .= '<select id="ws_nb_elements" class="tipsyer half" original-title="'.$oResources->rsc_content_nl_tooltip_elt_limit.'" tabindex="9">';						
					$return_txt .= '<option value="0"';
					if($oNLNbElements == 0){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>5</option>';

					$return_txt .= '<option value="1"';
					if($oNLNbElements == 1){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>10</option>';								

					$return_txt .= '<option value="2"';
					if($oNLNbElements == 2){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>20</option>';								

					$return_txt .= '<option value="3"';
					if($oNLNbElements == 3){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>50</option>';		

					$return_txt .= '<option value="4"';
					if($oNLNbElements == 4){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>'.$oResources->rsc_content_nl_elt_limit_all.'</option>';
				$return_txt .= '</select> ';
				
			$return_txt .= '</p>'; 
		$return_txt .= '</div>';






		$return_txt .= '<div class="half_page">';
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_order_elements">'.$oResources->rsc_content_nl_elt_orderby.' <span class="required"> *</span></label>';
				$return_txt .= '<select id="ws_order_elements" class="tipsyer half" original-title="'.$oResources->rsc_content_nl_tooltip_elt_orderby.'" tabindex="10">';						
					$return_txt .= '<option value="DESC"';
					if($oNLOrderElements == "DESC"){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>DESC</option>';

					$return_txt .= '<option value="ASC"';
					if($oNLOrderElements == "ASC"){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>ASC</option>';								

				$return_txt .= '</select>';
			$return_txt .= '</p>'; 
		$return_txt .= '</div>';
		


		
		$return_txt .= '<div class="half_page">';
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_frequency">'.$oResources->rsc_content_nl_elt_frequency.'<span class="required"> *</span></label>';
				$return_txt .= '<select id="ws_frequency" class="tipsyer half" original-title="'.$oResources->rsc_content_nl_tooltip_elt_frequency.'" tabindex="11">';
					$return_txt .= '<option value="0"';
					if($oNLFrequency == 0){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>'.$oResources->rsc_content_nl_elt_frequency_daily.'</option>';

					$return_txt .= '<option value="1"';
					if($oNLFrequency == 1){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>'.$oResources->rsc_content_nl_elt_frequency_weekly.'</option>';								

					$return_txt .= '<option value="2"';
					if($oNLFrequency == 2){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>'.$oResources->rsc_content_nl_elt_frequency_monthly.'</option>';	

				$return_txt .= '</select>';
			$return_txt .= '</p>'; 
		$return_txt .= '</div>';

		// bouton soumission
		$return_txt .= '<p>';
			$return_txt .= '<span class="valid"><input class="validation" type="button" name="submit_change_nl_settings" value="'.$oResources->rsc_btn_update.'" id="submit_change_nl_settings" title="3" /></span>';
		$return_txt .= '</p>';		

		$return_txt .= '</table>'; 
	}
	else if($_GET['type'] == 2)
	{
		// cas partie styles des NL

		
		
			$return_txt .= '<p class="bloc_checkbox">';
				$return_txt .= '<label for="ws_nl_img"><img src="../wp-content/plugins/cheetahmail/img/_big_image.png" /> '.$oResources->rsc_content_nl_addimage.' <span class="required"> *</span> ';
				$return_txt .= '<input type="checkbox" checked="checked" id="ws_nl_img" name="ws_nl_img" class="half" value="1" /> ';
			$return_txt .= '</label>'; 
			$return_txt .= '</p>'; 


			$return_txt .= '<p class="bloc_checkbox">';
				$return_txt .= '<label for="ws_nl_coment"><img src="../wp-content/plugins/cheetahmail/img/_big_comment.png" /> ';
				$return_txt .= '<select class="nowidth" id="ws_nl_coment" name="ws_nl_coment">';
					$return_txt .= '<option value="0"';
						if($oNLComent == 0){
						$return_txt .= ' selected="selected" ';
						}
						$return_txt .= '>0 '.$oResources->rsc_content_nl_addcoment;
					$return_txt .= '</option>';
					$return_txt .= '<option value="5"';
						if($oNLComent == 5){
						$return_txt .= ' selected="selected" ';
						}
						$return_txt .= '>5 '.$oResources->rsc_content_nl_addcoment;
					$return_txt .= '</option>';					
				$return_txt .= '</select>';
			$return_txt .= ' </label>'; 
			$return_txt .= '</p>';		

			
			$return_txt .= '<p class="bloc_checkbox">';
				$return_txt .= '<label for="ws_nl_link"><img src="../wp-content/plugins/cheetahmail/img/_big_link.png" />  '.$oResources->rsc_content_nl_addlink.' <span class="required"> *</span>';
				$return_txt .= '<input type="checkbox" ';
				if($oNLLink == 1){
					$return_txt .= ' checked="checked" ';
				}				
				$return_txt .= ' id="ws_nl_link" name="ws_nl_link" class="half" value="1" />';
			$return_txt .= '</label>'; 
			$return_txt .= '</p>'; 		
		
		$return_txt .= '<div class="third_page">';
			$return_txt .= '<h4><img src="../wp-content/plugins/cheetahmail/img/_middle_title.png" /> '.$oResources->rsc_content_nl_style_title.'</h4>';

			$return_txt .= '<div>';
				$return_txt .= '<label for="ws_title_color">'.$oResources->rsc_content_nl_style_color.' <span class="required"> *</span></label>';
					$return_txt .= '<div class="color-picker" style="position: relative;">';
					   $return_txt .= ' <input type="text" name="ws_title_color" id="ws_title_color" class="tipsyer half"   original-title="9" maxlength="7" tabindex="9" value="'.$oNLTitleColor.'" />';
				   $return_txt .= ' </div>';				
			$return_txt .= '</div>';

			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_title_fontface">'.$oResources->rsc_content_nl_style_fontface.' <span class="required"> *</span></label>';
				$return_txt .= '<select style="float:left" id="ws_title_fontface" class="half" tabindex="9">';
					$return_txt .= '<option value="0"';
					if($oNLTitleFontFace == 0){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Arial</option>';

					$return_txt .= '<option value="1"';
					if($oNLTitleFontFace == 1){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Verdana</option>';								

					$return_txt .= '<option value="2"';
					if($oNLTitleFontFace == 2){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Helvetica</option>';	

				$return_txt .= '</select>';
			$return_txt .= '</p>'; 
						
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_title_size">'.$oResources->rsc_content_nl_style_size.' <span class="required"> *</span></label>';
				$return_txt .= ' <input type="text" id="ws_title_size" style="float:left" class="half numeric" tabindex="9" maxlength="2" value="'.$oNLTitleSize.'" /> <span style="float:left" class="elt_little">px</span> ';
			$return_txt .= '</p>'; 

			
			$return_txt .= '<p>';
				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLTitleUnderline == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_title_underline" class="half" value="1" /> '.$oResources->rsc_content_nl_style_underline.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLTitleBold == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_title_bold" class="half" value="1" /> '.$oResources->rsc_content_nl_style_bold.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLTitleItalic == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_title_italic" class="half" value="1" /> '.$oResources->rsc_content_nl_style_italic.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLTitleUppercase == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_title_uppercase" class="half" value="1" /> '.$oResources->rsc_content_nl_style_uppercase.'</label>';

				
			$return_txt .= '</p>'; 
		$return_txt .= '</div>';
		
		

		
		
		
		
		
		

		
	
		$return_txt .= '<div class="third_page">';
			$return_txt .= '<h4><img src="../wp-content/plugins/cheetahmail/img/_middle_content.png" /> '.$oResources->rsc_content_nl_style_content.'</h4>';
					
			$return_txt .= '<div>';
				$return_txt .= '<label for="ws_content_color">'.$oResources->rsc_content_nl_style_color.'<span class="required"> *</span></label>';
					$return_txt .= '<div class="color-picker" style="position: relative;">';
					   $return_txt .= ' <input type="text" name="ws_content_color" id="ws_content_color" class="half" maxlength="7" tabindex="9" value="'.$oNLContentColor.'" />';
				   $return_txt .= ' </div>';	
				$return_txt .= '';
			$return_txt .= '</div>'; 

			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_content_fontface">'.$oResources->rsc_content_nl_style_fontface.' <span class="required"> *</span></label>';
				$return_txt .= '<select style="float:left" id="ws_content_fontface" class="half" tabindex="9">';
					$return_txt .= '<option value="0"';
					if($oNLContentFontFace == 0){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Arial</option>';

					$return_txt .= '<option value="1"';
					if($oNLContentFontFace == 1){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Verdana</option>';								

					$return_txt .= '<option value="2"';
					if($oNLContentFontFace == 2){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Helvetica</option>';	

				$return_txt .= '</select>';
			$return_txt .= '</p>'; 


			
			
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_content_size">'.$oResources->rsc_content_nl_style_content.' <span class="required"> *</span></label>';
				$return_txt .= ' <input type="text" id="ws_content_size" style="float:left" class="half numeric" tabindex="9" maxlength="2" value="'.$oNLContentSize.'" /> <span style="float:left" class="elt_little">px</span> ';
			$return_txt .= '</p>'; 

		
			
			$return_txt .= '<p>';
				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLContentUnderline == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_content_underline" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_underline.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLContentBold == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_content_bold" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_bold.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLContentItalic == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_content_italic" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_italic.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLContentUppercase == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_content_uppercase" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_uppercase.'</label>';

				
			$return_txt .= '</p>'; 

		$return_txt .= '</div>';








	
	
	
	
	
	
	

	
		$return_txt .= '<div class="third_page" id="coment_third_page"';
		$return_txt .= '>';
			$return_txt .= '<h4><img src="../wp-content/plugins/cheetahmail/img/_middle_comment.png" /> '.$oResources->rsc_content_nl_style_coments.'</h4>';
			
			$return_txt .= '<div>';
				$return_txt .= '<label for="ws_coment_color">'.$oResources->rsc_content_nl_style_color.' <span class="required"> *</span></label>';
				$return_txt .= '<div class="color-picker" style="position: relative;">';
				   $return_txt .= ' <input type="text" name="ws_coment_color" id="ws_coment_color" class="tipsyer half input_colorpicker" original-title="9" maxlength="7" tabindex="9" value="'.$oNLComentColor.'" />';
					$return_txt .= '<div style="position: absolute; z-index:100000;" id="cp_link" class="colorpicker"></div>';
			   $return_txt .= ' </div>';	
			$return_txt .= '</div>'; 
			
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_coment_fontface">'.$oResources->rsc_content_nl_style_fontface.' <span class="required"> *</span></label>';
				$return_txt .= '<select style="float:left" id="ws_coment_fontface" class="tipsyer half" original-title="9" tabindex="9">';
					$return_txt .= '<option value="0"';
					if($oNLComentFontFace == 0){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Arial</option>';

					$return_txt .= '<option value="1"';
					if($oNLComentFontFace == 1){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Verdana</option>';								

					$return_txt .= '<option value="2"';
					if($oNLComentFontFace == 2){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Helvetica</option>';	

				$return_txt .= '</select>';
			$return_txt .= '</p>'; 

			


			
			
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_coment_size">'.$oResources->rsc_content_nl_style_size.' <span class="required"> *</span></label>';
				$return_txt .= ' <input type="text" id="ws_coment_size" style="float:left" class="half numeric" tabindex="9" maxlength="2" value="'.$oNLComentSize.'" /> <span style="float:left" class="elt_little">px</span> ';
			$return_txt .= '</p>'; 




		
			$return_txt .= '<p>';
				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLComentUnderline == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_coment_underline" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_underline.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLComentBold == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_coment_bold" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_bold.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLComentItalic == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_coment_italic" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_italic.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLComentUppercase == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_coment_uppercase" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_uppercase.'</label>';

				
			$return_txt .= '</p>'; 


		$return_txt .= '</div>';

	
	
	
	
	
	
	
	
	
	
	
	
	
	

		
	
		$return_txt .= '<div class="third_page" id="link_third_page"';
		if($oNLLink == 0){
		$return_txt .= ' style="display:none" ';
		}
		$return_txt .= '>';
			$return_txt .= '<h4><img src="../wp-content/plugins/cheetahmail/img/_middle_link.png" /> '.$oResources->rsc_content_nl_style_link.'</h4>';

			$return_txt .= '<div>';
				$return_txt .= '<label for="ws_link_color">'.$oResources->rsc_content_nl_style_color.'<span class="required"> *</span></label>';
				$return_txt .= '<div class="color-picker" style="position: relative;">';
				   $return_txt .= ' <input type="text" name="ws_link_color" id="ws_link_color" class="tipsyer half"   original-title="9" maxlength="7" tabindex="9" value="'.$oNLLinkColor.'" />';
			   $return_txt .= ' </div>';	
			$return_txt .= '</div>'; 
			
			$return_txt .= '<p>';
			$return_txt .= '<label for="">'.$oResources->rsc_content_nl_style_link_text.' <span class="required"> *</span></label>';
			$return_txt .= '<input type="text" name="ws_link_defaulttext" id="ws_link_defaulttext" class="tipsyer half" style="float:left" original-title="9" maxlength="100" tabindex="9" value="'.$oNLLinkDefaultText.'" />';
			$return_txt .= '</p>';
			
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_link_fontface">'.$oResources->rsc_content_nl_style_fontface.' <span class="required"> *</span></label>';
				$return_txt .= '<select style="float:left" id="ws_link_fontface" class="tipsyer half" original-title="9" tabindex="9">';
					$return_txt .= '<option value="0"';
					if($oNLLinkFontFace == 0){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Arial</option>';

					$return_txt .= '<option value="1"';
					if($oNLLinkFontFace == 1){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Verdana</option>';								

					$return_txt .= '<option value="2"';
					if($oNLLinkFontFace == 2){
						$return_txt .= ' selected="selected" ';
					} 
					$return_txt .= '>Helvetica</option>';	

				$return_txt .= '</select>';
			$return_txt .= '</p>'; 

			
			


			
			
			$return_txt .= '<p>';
				$return_txt .= '<label for="ws_link_size">'.$oResources->rsc_content_nl_style_size.' <span class="required"> *</span></label>';
				$return_txt .= ' <input type="text" id="ws_link_size" class="tipsyer half numeric" style="float:left"  original-title="9" tabindex="9" maxlength="2" value="'.$oNLLinkSize.'" /> <span style="float:left" class="elt_little">px</span> ';
			$return_txt .= '</p>'; 




		
			$return_txt .= '<p>';
				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLLinkUnderline == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_link_underline" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_underline.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLLinkBold == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_link_bold" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_bold.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLLinkItalic == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_link_italic" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_italic.'</label>';

				$return_txt .= '<label class="nowidth"><input type="checkbox" ';
				if($oNLLinkUppercase == 1){
					$return_txt .= ' checked="checked" ';
				}
				
				$return_txt .= ' id="ws_link_uppercase" class="tipsyer half" value="1" /> '.$oResources->rsc_content_nl_style_uppercase.'</label>';

				
			$return_txt .= '</p>'; 


		$return_txt .= '</div>';

	


	
	
	
	
	
	
	
	
	
	
	
	
	
	
		// bouton soumission
		$return_txt .= '<p>';
			$return_txt .= '<span class="valid"><input class="validation" type="button" name="submit_change_nl_settings" value="'.$oResources->rsc_btn_update.'" id="submit_change_nl_settings" title="3" /></span>';
		$return_txt .= '</p>';			
					
	}
	
	header('HTTP/1.1 200 OK');	
	echo $return_txt;

?>