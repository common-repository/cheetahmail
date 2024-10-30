<?php
	require('../../../../wp-blog-header.php');
	
	if(
		isset($_POST['post_values']) && 
		strlen($_POST['post_values'])>0
	){
		$tab_config_values = getVarWithoutSession();
		$oIdlist = $tab_config_values['CMFR__api_idmlist'];
		$oLogin = $tab_config_values['CMFR__api_login'];
		$oPassword = $tab_config_values['CMFR__api_password'];
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
		$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
		
		try{
			$tab_infos_user = json_decode(stripslashes($_POST['post_values']),true);				
			$tab_last = '';
			$tab_last_topush = '';
			
			foreach($tab_infos_user as $fld_user){
				
				// pour chaque champ = tableau
				$fld_user['val_fld'] = trim($fld_user['val_fld']);
				$tab_last[$fld_user['id_fld']]['id_fld'] = $fld_user['id_fld'];
				$tab_last[$fld_user['id_fld']]['val_fld'] = $fld_user['val_fld'];
				$tab_last[$fld_user['id_fld']]['type_fld'] = $fld_user['type_fld'];
				$tab_last[$fld_user['id_fld']]['format_fld'] = $fld_user['format_fld'];	
				
				if($fld_user['id_fld'] == 1){
					$email = $fld_user['val_fld'];
				}
				
				if($tab_last[$fld_user['id_fld']]['type_fld'] == 2){
					// date
					if($tab_last[$fld_user['id_fld']]['val_fld'] == ''){
						$tab_last[$fld_user['id_fld']]['val_fld'] = '0001-01-01T00:00:00';
					}
				}else{
					//texte
					// if( $fld_user['format_fld']){
					
					// }
				}
				
				
				
				$tab_last_topush[$fld_user['id_fld']]['id_fld'] = $fld_user['id_fld'];
				
				if($fld_user['format_fld'] == 0)
				{
					$tab_last_topush[$fld_user['id_fld']]['val_fld'] = $fld_user['val_fld'];
				}
				else if($fld_user['format_fld'] == 1)
				{
					$tab_last_topush[$fld_user['id_fld']]['val_fld'] = strtolower($fld_user['val_fld']);
				}
				else if($fld_user['format_fld'] == 2)
				{
					$tab_last_topush[$fld_user['id_fld']]['val_fld'] = strtoupper($fld_user['val_fld']);
				}
				else if($fld_user['format_fld'] == 3)
				{
					$tab_last_topush[$fld_user['id_fld']]['val_fld'] = ucfirst($fld_user['val_fld']);
				}
				else if($fld_user['format_fld'] == 4)
				{
					$tab_last_topush[$fld_user['id_fld']]['val_fld'] = ucwords($fld_user['val_fld']);
				}			
		
			}						
	
			$test_id = 0;
			$iduser = $MyEMST->FindByEmail($email);
			// si iduser est inexistant
			if($iduser  == 0)
			{
				try
				{
					$iduser = $MyEMST->_subscribers->Add(array('email'=>strtolower($email)))->AddResult;
					$test_id = 1;
				}
				catch(SoapFault $e){
					// echo($e);
					header('HTTP/1.1 200 OK');	
					echo '<div class="cm_msg cm_alert">' . $oResources -> rsc_user_form_error . '</div>';
					exit;
				}
			}
			
			
			// on reconstitue le tableau en retirant les types de champs
			$def_user = $MyEMST->UpdateUserInfos($iduser,$tab_last_topush);
				
			if($def_user == 0 && $test_id == 1){
				header('HTTP/1.1 200 OK');
				echo '<div class="cm_msg cm_success">' . $oResources -> rsc_user_form_added . '</div>';
			}else if($def_user == 0 && $test_id == 0){
				header('HTTP/1.1 200 OK');
				echo '<div class="cm_msg cm_success">' . $oResources -> rsc_user_form_updated . '</div>';
			}else{
				header('HTTP/1.1 200 OK');	
				echo '<div class="cm_msg cm_alert">' . $oResources -> rsc_user_form_error . '</div>';
			}
		}catch (SoapFault $e) {
			header('HTTP/1.1 200 OK');	
			echo '<div class="cm_msg cm_alert">' . $oResources -> rsc_user_form_error . '</div>';
		}		
	}else{
		// API ne fonctionne pas
		header('HTTP/1.1 200 OK');	
		echo '<div class="cm_msg cm_alert">' . $oResources -> rsc_user_form_error . '</div>';
	}
?>