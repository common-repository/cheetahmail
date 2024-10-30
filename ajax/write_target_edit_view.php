<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oQuery = $_POST['id_target'];
	$oListRecipients = $MyEMST->GetSubscribers($oQuery);
	$oListRecipientsNumber = $_POST['number_target'];
	$oListRecipientsName = $_POST['name_target'];
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	

if(	$_POST['number_target']>=0 && strlen($_POST['name_target']) && $_POST['id_target']>0)
{
	$return_txt = '';					
										
		$return_txt .= '<div id="referred_2" class="toggelize">';
			$return_txt .= '<h2>'. htmlspecialchars(stripslashes($oListRecipientsName)) .' - <strong>'. $oListRecipientsNumber .' '.$oResources->rsc_content_recipients.'</strong><div class="shut">X</div></h2>'; 

			// $return_txt .= '<label for="ws_name_target">'.$oResources->rsc_table_content_name.' <span class="required"> *</span></label> ';			
			$return_txt .= '<h3>'.$oResources->rsc_table_content_name.' </h3> ';
			$return_txt .= '<p class="alternate_style_full">';
				$return_txt .= '<input readonly="readonly" class="tipsyer" original-title="1" type="text" id="ws_name_target"  maxlength="250" tabindex="1" value="'. htmlspecialchars(stripslashes($oListRecipientsName)) .'" />';
			$return_txt .= '</p>'; 
	
		// liste critères de segmentation
		$return_txt .= '<div>';
			$return_txt .= '<h3>'.$oResources->rsc_content_criterias.'</h3>';
			
			$def_bdd = $MyEMST->getStructureLiveForTarget($oQuery);
			$return_txt .= $def_bdd;
		$return_txt .= '</div>';  

		
		// bouton soumission
		$return_txt .= '<p class="alternate_style_full" id="'.$_POST['id_target'].'">';
			$return_txt .= '<span class="valid"><input class="validation" type="button" value="'.$oResources->rsc_btn_update.'" id="submit_update_target" /></span>';
		$return_txt .= '</p>';
		$return_txt .= '<div class="loading_area" id="loading_area_camp_update" style="display:none"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div> ';
	$return_txt .= '</div>';
	header('HTTP/1.1 200 OK');	
	echo $return_txt;
}
else
{
	// erreur params
	header('HTTP/1.1 200 OK');	
	echo -1;
}	
?>