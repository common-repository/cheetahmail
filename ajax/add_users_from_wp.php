<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);		
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	
	$return_txt = '';				
	$args = array(
		'blog_id'      => $GLOBALS['blog_id'],
		'role'         => '',
		'meta_key'     => '',
		'meta_value'   => '',
		'meta_compare' => '',
		'meta_query'   => array(),
		'include'      => array(),
		'exclude'      => array(),
		'orderby'      => 'login',
		'order'        => 'ASC',
		'offset'       => '',
		'search'       => '',
		'number'       => '',
		'count_total'  => false,
		'fields'       => 'all',
		'who'          => ''
	 );
	$users_tab = get_users( $args );
	
	$return_txt .= '<h2 class="users_added">'. $oResources->rsc_js_users_sync_result .'</h2>'; 
	$return_txt .= '<table class="cm" id="tbl_users">';					
	$return_txt .= '<tr>';
		$return_txt .= '<th>'. $oResources->rsc_table_user_email .'</th>';
		$return_txt .= '<th>'. $oResources->rsc_table_user_login .'</th>';
		$return_txt .= '<th>'. $oResources->rsc_table_user_nicename .'</th>';
		$return_txt .= '<th>'. $oResources->rsc_table_user_displayname .'</th>';
		$return_txt .= '<th>'. $oResources->rsc_table_user_subsdate .'</th>';
	$return_txt .= '</tr>';			
	$c = 0;
	foreach($users_tab as $user){
		if($user-> user_status == 0){
			$user_id = $MyEMST->AddByEmailForWPUsers($user -> user_email);
			if($user_id>0){
				$return_txt .= '<tr>';
					$return_txt .= '<td>' .$user -> user_email .'</th>';
					$return_txt .= '<td>' .$user -> user_login .'</td>';
					$return_txt .= '<td>' .$user -> user_nicename .'</td>';
					$return_txt .= '<td width="30">' .$user -> display_name .'</td>';
					$return_txt .= '<td width="50">' .$user -> user_registered .'</td>';
				$return_txt .= '</tr>';
				$c++;
			}
		}
	}
	if($c == 0){
		$return_txt .= '<tr>';
			$return_txt .= '<td colspan="5" align="center">'.$oResources->rsc_content_no_user_to_sync.'</th>';
		$return_txt .= '</tr>';
	}
	$return_txt .= '</table>';
	header('HTTP/1.1 200 OK');	
	echo $return_txt;	
?>