<?php
	require('../../../../wp-blog-header.php');
	include('../fn/fn.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['api_idmlist'];
	$oLogin = $tab_config_values['api_login'];
	$oPassword = $tab_config_values['api_password'];
	$txt_return_full = '';	
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oImg_wp = $MyEMST->getListImagesFromWP();
	foreach( $oImg_wp as $img ){
		if(strlen($img['src']) > 2){
			$txt_return_full .=  '<div class="bloc_img_wp" id="' . $img['id'] .'">';
				$txt_return_full .=  '<img src="' . $img['src'] .'">';
			$txt_return_full .=  '</div>';
		}
	}	
	header('HTTP/1.1 200 OK');		
	echo $txt_return_full;
?>