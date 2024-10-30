<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oEmailTemplatesInfos = $MyEMST->GetTemplatesList();
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);

	$return_txt ='';
	$return_txt .= '<p><input type="text" class="search_in" value="" id="_tpl" /></p>';
	$return_txt .= '<table class="cm" id="tbl_tpl">';
	$return_txt .= '<tr>';
		$return_txt .= '<th>';
			$return_txt .= $oResources->rsc_table_id;
		$return_txt .= '</th>';
		$return_txt .= '<th>';
			$return_txt .= $oResources->rsc_table_date;
		$return_txt .= '</th>';							
		$return_txt .= '<th>';
			$return_txt .= $oResources->rsc_table_name;
		$return_txt .= '</th>';	
		$return_txt .= '<th width="50">';
			$return_txt .= $oResources->rsc_table_actions;
		$return_txt .= '</th>';						
	$return_txt .= '</tr>';
				
	if(!empty($oEmailTemplatesInfos) && count($oEmailTemplatesInfos)>0){
		foreach($oEmailTemplatesInfos as $line){	
			$return_txt .= '<tr id="'.$line['id'].'">';
				$return_txt .= '<td>';
					$return_txt .= $line['id'];
				$return_txt .= '</td>';						
				$return_txt .= '<td>';
					$return_txt .= $line['date'];
				$return_txt .= '</td>';
				$return_txt .= '<td >';
					$return_txt .= $line['name']. '<span style="display:none">'.strtolower($line['name']).'</span>';
				$return_txt .= '</td>';	
				$return_txt .= '<td>';
					$return_txt .= '<div class="actions_switcher"> </div>';						
					$return_txt .= '<div class="partial_buttons" id="'.$line['id'].'" style="display:none">';
						$return_txt .= '<span class="action_template edit" id="edit">'.$oResources->rsc_table_action_edit.'</span>';
						$return_txt .= '<span class="action_template preview" id="preview">'.$oResources->rsc_table_action_preview.'</span>';
						$return_txt .= '<span class="action_template duplicate" id="duplicate">'.$oResources->rsc_table_action_duplicate.'</span>';
						$return_txt .= '<span class="action_template delete" id="delete">'.$oResources->rsc_table_action_delete.'</span>';
					$return_txt .= '</div>';
					$return_txt .= '<div style="display:none" class="partial_loading"><img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif" /></div>';	
				$return_txt .= '</td>';								
			$return_txt .= '</tr>';	
		}
	}				
	$return_txt .= '</table>'; 
	header('HTTP/1.1 200 OK');	
	echo $return_txt;
?>