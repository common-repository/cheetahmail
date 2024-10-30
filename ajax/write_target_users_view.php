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
		$return_txt .= '<div id="referred_1" class="toggelize">';
			$return_txt .= '<h2>'. stripslashes($oListRecipientsName) .' - <strong>'. $oListRecipientsNumber .' '.$oResources->rsc_content_recipients.'</strong><div class="shut">X</div></h2>'; 
			$return_txt .= '<p><input type="text" class="search_in" value="" id="_users_target" /></p>';
			$return_txt .= '<table class="cm" id="tbl_users_target">';					
				$return_txt .= '<tr>';
					$return_txt .= '<th width="30">'.$oResources->rsc_table_state.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_email.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_subsdate.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_unsubsdate.'</th>';
					$return_txt .= '<th width="50">'.$oResources->rsc_table_actions.'</th>';
				$return_txt .= '</tr>';	
				if(!empty($oListRecipients) && !empty($oListRecipients[0]) && count($oListRecipients)>0){
					foreach($oListRecipients as $line_email_s){
						$return_txt .= $line_email_s;
					}
				}
			$return_txt .= '</table>'; 
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