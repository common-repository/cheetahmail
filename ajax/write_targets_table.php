<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oPrefixTarget = $tab_config_values['CMFR__prefix_target'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
	$oTargetsInfos = $MyEMST->_filter->List()->ListResult->string;
	
	$return_txt ='';
	$return_txt .= '<p><input type="text" class="search_in" value="" id="_targets" /></p>';
	$return_txt .= '<table class="cm" id="tbl_targets">';
	$return_txt .= '<tr>';
		
		$return_txt .= '<th width="5%">';
			$return_txt .= $oResources->rsc_table_id;
		$return_txt .= '</th>';							
		
		$return_txt .= '<th>';					
			$return_txt .= $oResources->rsc_table_name;
		$return_txt .= '</th>';	
		
		$return_txt .= '<th>';					
			$return_txt .= $oResources->rsc_table_recipients;
		$return_txt .= '</th>';	
			
		$return_txt .= '<th width="50">';
			$return_txt .= $oResources->rsc_table_actions;
		$return_txt .= '</th>';							
	$return_txt .= '</tr>';
	
	if(count($oTargetsInfos)>1)
	{
		// plusieurs resultats		
		foreach($oTargetsInfos as $line){
			// on enleve le prefixe EMAILING
			$oTemp = explode(' - ',$line);			
			$oId = $oTemp[0];			
			$oDesc = $oTemp[1];
			$oCount = $MyEMST -> GetNumberByIdTarget($oId);			
			if(strpos($oDesc,$oPrefixTarget) !== false ){								
				$oDesc_temp = explode($oPrefixTarget,$oDesc);					
				$oDesc = $oDesc_temp[1];					
				$return_txt .= '<tr id="'.$oId.'">';			
					$return_txt .= '<td>';
						$return_txt .= $oId;					
					$return_txt .= '</td>';
					$return_txt .= '<td>';
						$return_txt .= $oDesc;
					$return_txt .= '</td>';								
					$return_txt .= '<td>';
						$return_txt .= $oCount;
					$return_txt .= '</td>';	
					$return_txt .= '<td>';
						$return_txt .= '<div class="actions_switcher"> </div>';						
						$return_txt .= '<div id="'.$oId.'" class="partial_buttons" style="display:none">';
							$return_txt .= '<span class="action_target edit" id="edit">'.$oResources->rsc_table_action_edit.'</span>';
							$return_txt .= '<span class="action_target preview" id="view">'.$oResources->rsc_table_action_viewusers.'</span>';
						$return_txt .= '</div>';
						$return_txt .= '<div style="display:none" class="partial_loading"><img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif" /></div>';
					$return_txt .= '</td>';								
				$return_txt .= '</tr>';	
			}
		}
	}
	else
	{
		// on enleve le prefixe EMAILING
		$oTemp = explode(' - ',$oTargetsInfos);			
		$oId = $oTemp[0];			
		$oDesc = $oTemp[1];			
		if(strpos($oDesc,$oPrefixTarget) !== false ){											
			$oDesc_temp = explode($oPrefixTarget,$oDesc);
			$oDesc = $oDesc_temp[1];
		}	
		
		$return_txt .= '<tr id="'.$oId.'">';

			$return_txt .= '<td>';						
				$return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/state_finished.png" /> ';	
			$return_txt .= '</td>';
			$return_txt .= '<td>';
				$return_txt .= $oId;
			$return_txt .= '</td>';
			$return_txt .= '</td>';
			$return_txt .= '</td>';
			$return_txt .= '<td>';
				$return_txt .= $oDesc . '<span style="display:none">'.strtolower($oDesc).'</span>';
			$return_txt .= '</td>';	
			$return_txt .= '<td>';
				$return_txt .= '<div class="actions_switcher"> </div>';						
				$return_txt .= '<div id="'.$oId.'" class="partial_buttons" style="display:none">';
					$return_txt .= '<span class="action_target edit" id="edit">'.$oResources->rsc_table_action_edit.'</span>';
					$return_txt .= '<span class="action_target preview" id="view">'.$oResources->rsc_table_action_viewusers.'</span>';
				$return_txt .= '</div>';
				$return_txt .= '<div style="display:none" class="partial_loading"><img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif" /></div>';
			$return_txt .= '</td>';								
		$return_txt .= '</tr>';							
	}	
	$return_txt .= '</table>'; 
	header('HTTP/1.1 200 OK');	
	echo $return_txt;	
?>