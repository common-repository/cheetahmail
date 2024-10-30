<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
if(
	( isset($_POST['nl_active']) && is_numeric($_POST['nl_active']) && $_POST['nl_active']>=0) 
	&&
	( isset($_POST['nl_type_elements']) && $_POST['nl_type_elements']>=0 ) 
	&&
	( isset($_POST['nl_nb_elements']) && $_POST['nl_nb_elements']>=0 ) 			
	&&
	( isset($_POST['nl_frequency']) && $_POST['nl_frequency']>=0 ) 		
	&&
	( isset($_POST['nl_order_elements']) && $_POST['nl_order_elements']>=0 ) 	
	&&
	( isset($_POST['nl_link']) && $_POST['nl_link']>=0 ) 			
	&&
	( isset($_POST['nl_img']) && $_POST['nl_img']>=0 )	
	&&
	( isset($_POST['nl_coment']) && $_POST['nl_coment']>=0 )		
)
{

	// on recup toute la config JSON
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];

	// on instancie notre client
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);

	// TOUT EST OK ON ECRIT LE FICHIER DE CONFIGURATION 
	$array_config_nl = array();
	
	$array_config_nl["CMFR__idquery_nl"] = $_POST['nl_target']; // url WP

	$array_config_nl["CMFR__nl_date_last_sent"] = $tab_config_values['CMFR__nl_date_last_sent']; // url WP
	$array_config_nl["CMFR__nl_activation"] = $_POST['nl_active']; // url WP
	$array_config_nl["CMFR__nl_type_elements"] = $_POST['nl_type_elements']; // url WP
	$array_config_nl["CMFR__nl_nb_elements"] = $_POST['nl_nb_elements']; // url WP
	$array_config_nl["CMFR__nl_order_elements"] = $_POST['nl_order_elements']; // url WP
	$array_config_nl["CMFR__nl_frequency"] = $_POST['nl_frequency']; // url WP
	
	
	$array_config_nl["CMFR__nl_title_fontface"] = $_POST['nl_title_fontface']; // url WP
	$array_config_nl["CMFR__nl_title_color"] = $_POST['nl_title_color']; // url WP
	$array_config_nl["CMFR__nl_title_size"] = $_POST['nl_title_size']; // url WP
	$array_config_nl["CMFR__nl_title_underline"] = $_POST['nl_title_underline']; // url WP
	$array_config_nl["CMFR__nl_title_bold"] = $_POST['nl_title_bold']; // url WP
	$array_config_nl["CMFR__nl_title_italic"] = $_POST['nl_title_italic']; // url WP
	$array_config_nl["CMFR__nl_title_uppercase"] = $_POST['nl_title_uppercase']; // url WP
	
	$array_config_nl["CMFR__nl_content_fontface"] = $_POST['nl_content_fontface']; // url WP
	$array_config_nl["CMFR__nl_content_color"] = $_POST['nl_content_color']; // url WP
	$array_config_nl["CMFR__nl_content_size"] = $_POST['nl_content_size']; // url WP
	$array_config_nl["CMFR__nl_content_underline"] = $_POST['nl_content_underline']; // url WP
	$array_config_nl["CMFR__nl_content_bold"] = $_POST['nl_content_bold']; // url WP
	$array_config_nl["CMFR__nl_content_italic"] = $_POST['nl_content_italic']; // url WP
	$array_config_nl["CMFR__nl_content_uppercase"] = $_POST['nl_content_uppercase']; // url WP
	
	$array_config_nl["CMFR__nl_link_defaulttext"] = $_POST['nl_link_defaulttext']; // url WP
	$array_config_nl["CMFR__nl_link_fontface"] = $_POST['nl_link_fontface']; // url WP
	$array_config_nl["CMFR__nl_link_color"] = $_POST['nl_link_color']; // url WP
	$array_config_nl["CMFR__nl_link_size"] = $_POST['nl_link_size']; // url WP
	$array_config_nl["CMFR__nl_link_underline"] = $_POST['nl_link_underline']; // url WP
	$array_config_nl["CMFR__nl_link_bold"] = $_POST['nl_link_bold']; // url WP
	$array_config_nl["CMFR__nl_link_italic"] = $_POST['nl_link_italic']; // url WP
	$array_config_nl["CMFR__nl_link_uppercase"] = $_POST['nl_link_uppercase']; // url WP
	
	$array_config_nl["CMFR__nl_coment_fontface"] = $_POST['nl_coment_fontface']; // url WP
	$array_config_nl["CMFR__nl_coment_color"] = $_POST['nl_coment_color']; // url WP
	$array_config_nl["CMFR__nl_coment_size"] = $_POST['nl_coment_size']; // url WP
	$array_config_nl["CMFR__nl_coment_underline"] = $_POST['nl_coment_underline']; // url WP
	$array_config_nl["CMFR__nl_coment_bold"] = $_POST['nl_coment_bold']; // url WP
	$array_config_nl["CMFR__nl_coment_italic"] = $_POST['nl_coment_italic']; // url WP
	$array_config_nl["CMFR__nl_coment_uppercase"] = $_POST['nl_coment_uppercase']; // url WP
	
	$array_config_nl["CMFR__nl_image"] = $_POST['nl_img']; // url WP
	$array_config_nl["CMFR__nl_link"] = $_POST['nl_link']; // url WP
	$array_config_nl["CMFR__nl_coment"] = $_POST['nl_coment']; // url WP
			
	$MyEMST->setVars($array_config_nl);
	header('HTTP/1.1 200 OK');	
	echo 0;			
}
else
{
	// paramètres NOK
	header('HTTP/1.1 200 OK');	
	echo -2;
}

?>