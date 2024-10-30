<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oSubsQuery = $tab_config_values['CMFR__idquery_campaign'];
	$oUnSubsQuery = $tab_config_values['CMFR__idquery_unsubs'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oSubsListRecipients = $MyEMST->GetSubscribers($oSubsQuery);
	$oSubsNumber = $MyEMST->GetNumberByIdTarget($oSubsQuery);
	$oUnSubsListRecipients = $MyEMST->GetSubscribers($oUnSubsQuery);
	$oUnSubsNumber = $MyEMST->GetNumberByIdTarget($oUnSubsQuery);
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
	
	if(isset($oSubsListRecipients[0]) && empty($oSubsListRecipients[0])){
		$oSubsNumber --;
	}
	if(isset($oUnSubsListRecipients[0]) && empty($oUnSubsListRecipients[0])){
		$oUnSubsNumber --;
	}	
	$return_txt = '';		 
			
	$return_txt .= '<div class="filter-menu-container">';
		$return_txt .= '<ul class="filter-menu frequencies-filter heading">';			
			$return_txt .= '<li class="heading_elt active" id="elt_1"><img src="../wp-content/plugins/cheetahmail/img/_icon_subscribers.png" /> '.strtoupper($oResources->rsc_submenu_subscribers).'</li>';
			$return_txt .= '<li class="heading_elt" id="elt_2"><img src="../wp-content/plugins/cheetahmail/img/_icon_unsubscribers.png" /> '.strtoupper($oResources->rsc_submenu_unsubscribers).'</li>';
			$return_txt .= '<li class="heading_elt" id="elt_3"><img src="../wp-content/plugins/cheetahmail/img/_magnify_off.png" /> '.strtoupper($oResources->rsc_submenu_search).'</li>';
		$return_txt .= '</ul>';								
	$return_txt .= '</div>';

	$return_txt .= '<div class="list-container" id="listContainer">';


		$return_txt .= '<div id="referred_1" class="toggelize" style="">';
			$return_txt .= '<p>'.$oResources->rsc_content_subs_sentence_left.' <strong>'. $oSubsNumber .'</strong> '.$oResources->rsc_content_subs_sentence_right.'<input type="text" class="search_in" value="" id="_subscribers" /></p>';
			$return_txt .= '<table class="cm" id="tbl_subscribers">';					
				$return_txt .= '<tr>';
					$return_txt .= '<th width="30">'.$oResources->rsc_table_state.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_email.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_subsdate.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_unsubsdate.'</th>';
					$return_txt .= '<th width="50">'.$oResources->rsc_table_actions.'</th>';
				$return_txt .= '</tr>';		
				
				if(!empty($oSubsListRecipients) && count($oSubsListRecipients)>0)
				{
					foreach($oSubsListRecipients as $line_email_subs){
						$return_txt .= $line_email_subs;
					}
				}
					
			$return_txt .= '</table>'; 
		$return_txt .= '</div>'; 
					
		
		$return_txt .= '<div id="referred_2" class="toggelize"  style="display:none">';
			$return_txt .= '<p>'.$oResources->rsc_content_unsubs_sentence_left.' <strong>'. $oUnSubsNumber .'</strong> '.$oResources->rsc_content_unsubs_sentence_right.' <input type="text" class="search_in" value="" id="_unsubscribers" /></p>';
			$return_txt .= '<table class="cm" id="tbl_unsubscribers">';					
				$return_txt .= '<tr>';
					$return_txt .= '<th width="30">'.$oResources->rsc_table_state.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_email.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_subsdate.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_unsubsdate.'</th>';
					$return_txt .= '<th width="50">'.$oResources->rsc_table_actions.'</th>';
				$return_txt .= '</tr>';	
					if(!empty($oUnSubsListRecipients) && count($oUnSubsListRecipients)>0){
						foreach($oUnSubsListRecipients as $line_email_unsubs){
							$return_txt .= $line_email_unsubs;
						}
					}
			$return_txt .= '</table>'; 
		$return_txt .= '</div>';


		$return_txt .= '<div id="referred_3" class="toggelize" style="display:none">';
			$return_txt .= '<p class="search_page">';
				$return_txt .= '<label for="email_search"> @ </label>';
				$return_txt .= '<input type="text" value="" class="" id="email_search" /> ';
				$return_txt .= '<input type="button" disabled="disabled" value="'.$oResources->rsc_content_search.'" id="valid_email_search" /> ';
				$return_txt .= '<br /><span class="minus">'.$oResources->rsc_content_search_sentence.'</span>';						
			$return_txt .= '</p>';
			$return_txt .= '<div id="ajax_area_search"></div>';
		
		$return_txt .= '</div>';
	
	$return_txt .= '</div>';
	header('HTTP/1.1 200 OK');		
	echo $return_txt;	

?>