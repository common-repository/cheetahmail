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
	$return_txt ='<option value="-1">'.$oResources->rsc_tpl_camp_choosetpl.'</option>';			
	if(!empty($oEmailTemplatesInfos) && count($oEmailTemplatesInfos)>0){
		foreach($oEmailTemplatesInfos as $line){
				$return_txt .= '<option value="'.$line['id'].'">';
					$return_txt .= $line['name'] . ' ' . $line['date'];
				$return_txt .= '</option>';						
		}
	}				
	header('HTTP/1.1 200 OK');	
	echo $return_txt;
?>