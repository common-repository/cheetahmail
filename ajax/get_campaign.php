<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oPrefixEmailing = $tab_config_values['CMFR__prefix_email'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
	
	if(
	( isset($_POST['id_campaign']) && $_POST['id_campaign']>0)
	){		
		// on recup les infos
		$MyCampaign = $MyEMST->GetCampaignByd($_POST['id_campaign']);
		$MyCampaign_contents = $MyEMST->GetContentsCampaign($_POST['id_campaign']);
		$oDesc = $MyCampaign->description;
							
		if(strpos($oDesc,$oPrefixEmailing) >=0){
			// on a le prefixe EMAILING
			$oDesc_temp = explode($oPrefixEmailing,$oDesc);
			$oDesc = $oDesc_temp[1];
		}
		
		$jHtml = '';
		$jHtml .= '<h2>'.$oDesc.' <div class="shut">X</div></h2>';
		$jHtml .= '<input value="'.$MyCampaign->id.'" id="campaign_id" type="hidden" />';
		$jHtml .= '<div>';
		
		$jHtml .= '<p><label class="switcher active" id="1">'.$oResources->rsc_camp_params.'</label> <label class="switcher" id="2">'.$oResources->rsc_camp_html.' &amp; '. $oResources->rsc_camp_txt .'</label></p>';
		$jHtml .= '<div class="switch" id="1">';
				
			$jHtml .= '<p><label for="campaign_name">'.$oResources->rsc_camp_name.' <span class="required">*</span></label><input type="text" class="subj" value="'.htmlspecialchars($oDesc).'" id="campaign_name" maxlength="250" /></p>';
			$jHtml .= '<p><label for="campaign_subject">'.$oResources->rsc_camp_subject.' <span class="required">*</span></label><input type="text" class="subj" id="campaign_subject" maxlength="250" value="'.htmlspecialchars($MyCampaign_contents->subject).'" /></p>';

			// Target
			$jHtml .= '<div class="alternate_style_full">';
				$jHtml .= '<p>';
					$jHtml .= '<label for="ws_target">'.$oResources->rsc_camp_target.'<span class="required"> *</span></label>';
						$jHtml .= '<select id="ws_target">';
							$jHtml .= $MyEMST -> GetTargetsListSelect($MyCampaign->filters->fieldFilterId);
						$jHtml .= ' </select>';
				$jHtml .= '</p>'; 
			$jHtml .= '</div>'; 
			
			$jHtml .= '<p><span class="valid"><input type="button"  name="save_changes" value="'.$oResources->rsc_btn_update.'" id="submit_change_campaign" title="'.$MyCampaign->id.'" /></span></p>';
			$jHtml .= '<div class="loading_area" id="loading_area_camp_update" style="display:none"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div> ';	
		
		$jHtml .= '</div>';
		
		$jHtml .= '<div class="switch" id="2" style="display:none">';
			// version code custom
			$jHtml .= '<p>';
				$jHtml .= '<label for="ws_tpl_upload_campaign">'.$oResources->rsc_camp_uploadtpl.' <span class="required"> *</span></label>';
				
				$list_tpl = $MyEMST -> GetTemplatesList();
				
				
				$jHtml .= '<select class="tipsyer half" original-title="2" id="ws_tpl_upload_campaign" tabindex="2">';

					$jHtml .= '<option selected="selected" value="-1">'.$oResources->rsc_camp_choosetpl.'</option>';
				if(!empty($list_tpl) && count($list_tpl)>0){
					// plusieurs resultats
					
					foreach($list_tpl as $line){
						$jHtml .= '<option value="' . $line['id'] . '">'.$line['name'] . ' (' .$line['date'].')</option>';
					}
				}else{
					// un seul resultat					
				}			
				$jHtml .= '</select>';
				$jHtml .= '<span class="valid-light"><input type="button" value="'.$oResources->rsc_camp_loadtpl.'" class="load" title="edit" id="load_tpl"></span>';
				$jHtml .= '<img id="loading_area_tpl" style="display:none" src="../wp-content/plugins/cheetahmail/img/link-loader.gif" /> ';
			$jHtml .= '</p>'; 
			$jHtml .= '<p>';
				$jHtml .= '<textarea id="campaign_html" class="txt  rich-editor" >'.$MyCampaign_contents->htmlsrc.'</textarea>';
			$jHtml .= '</p>';
		
			$jHtml .= '<p> <span class="valid"><input type="button" value="Generate TXT from HTML" id="generate_txt_edit" class="load" /></span> <textarea class="txt" id="campaign_txt">'.$MyCampaign_contents->txtsrc.'</textarea> </p>';	
			$jHtml .= '<p><span class="valid"><input type="button"  name="save_changes" value="'.$oResources->rsc_btn_update.'" id="submit_change_campaign" title="'.$MyCampaign->id.'" /></span></p>';
			$jHtml .= '<div class="loading_area" id="loading_area_camp_update" style="display:none"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div> ';					
		$jHtml .= '</div>';		
		// print_r($MyCampaign);
		header('HTTP/1.1 200 OK');	
		echo($jHtml);			
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>