<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$search = $_POST['search'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
	
	if( strlen(trim($search))>0 )
	{	
		$oSubsListRecipients = $MyEMST->SearchByEmail($search);
		$oSubsNumberRecipients = count($oSubsListRecipients) ;
		if(empty($oSubsListRecipients)){
			$oSubsNumberRecipients = $oSubsNumberRecipients -1;
		}		
		$return_txt = '';		
				
		$return_txt .= '<p>';			
				
					
			
			// if($oSubsNumberRecipients == 0){
				// $return_txt .= '<img src="../wp-content/plugins/cheetahmail/img/_magnify_off.png" /> <img src="../wp-content/plugins/cheetahmail/img/info.png" />';
				// $return_txt .= ' <strong>&quot;'. $search .'&quot;</strong> ';
				// $return_txt .= ' <strong style="float:right">'. $oSubsNumberRecipients . ' ' . $oResources->rsc_content_results.'</strong> ';	
			// }
			// else{
				$return_txt .= ' <img style="height:16px" src="../wp-content/plugins/cheetahmail/img/_magnify_on.png" /> <strong>&quot;'. $search .'&quot;</strong> ';
				$return_txt .= ' <strong ><img src="../wp-content/plugins/cheetahmail/img/success.png" /> '. $oSubsNumberRecipients. ' ' .$oResources->rsc_content_results .'</strong> ';	
			
				if($oSubsNumberRecipients > 0){
					$return_txt .= '<input type="text" class="search_in" value="" id="_search" />';
				}	
				
				$return_txt .= ' ';
			// }	
				
	
		$return_txt .= '</p>';					
			
		if($oSubsNumberRecipients>0){		
			$return_txt .= '<table class="cm" id="tbl_search">';								
				$return_txt .= '<tr>';
					$return_txt .= '<th width="30">'.$oResources->rsc_table_state.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_email.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_subsdate.'</th>';
					$return_txt .= '<th>'.$oResources->rsc_table_unsubsdate.'</th>';
					$return_txt .= '<th width="50">'.$oResources->rsc_table_actions.'</th>';
				$return_txt .= '</tr>';		
				foreach($oSubsListRecipients as $line_email_subs){
					$return_txt .= $line_email_subs;
				}	
			$return_txt .= '</table>'; 
		}
		header('HTTP/1.1 200 OK');	
		echo $return_txt;	
					
	}else{
		// API ne fonctionne pas
		header('HTTP/1.1 200 OK');	
		echo -1;
	}

?>