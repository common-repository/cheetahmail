<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');

	if( isset($_POST['id_user']) && $_POST['id_user']>0 && isset($_POST['post_values']) && strlen($_POST['post_values'])>0 )
	{
		$tab_config_values = getVarWithoutSession();
		$oIdlist = $tab_config_values['CMFR__api_idmlist'];
		$oLogin = $tab_config_values['CMFR__api_login'];
		$oPassword = $tab_config_values['CMFR__api_password'];
		$MyEMST = new emst($oIdlist,$oLogin,$oPassword);		
		try{
			$tab_infos_user = json_decode(stripslashes($_POST['post_values']),true);
			$def_user = $MyEMST->UpdateUserInfos($_POST['id_user'],$tab_infos_user);
			if($def_user == 0){
				header('HTTP/1.1 200 OK');	
				echo 0;
			}else{
				header('HTTP/1.1 200 OK');	
				echo $def_user;
			}
		}catch (SoapFault $e)
		{
			header('HTTP/1.1 200 OK');	
			echo $e;
		}		
	}else{
		// API ne fonctionne pas
		header('HTTP/1.1 200 OK');	
		echo -1;
	}
?>