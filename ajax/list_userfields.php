<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);	
	$listFld = $MyEMST -> getStructure();
	$jHtml = '';
	
	if(count($listFld)>3){
		$jHtml .= '<table class="cu">';
		
			$jHtml .= '<tr>';
				$jHtml .= '<th>'.$oResources->rsc_table_displaytext.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_name.'</th>';
				$jHtml .= '<th width="170">'.$oResources->rsc_table_type.'</th>';
				$jHtml .= '<th width="100">'.$oResources->rsc_table_values.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_setformat.'</th>';
				$jHtml .= '<th widt="70">'.$oResources->rsc_table_setdefault.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_actions.'</th>';
			$jHtml .= '</tr>';		
			
			$u = 0;
			
			foreach($listFld as $fld)
			{
				$jHtml .= '<tr>';
				$type_fld = 'Text';
				$name_fld = '';
				$id_fld = 0;
				$i = 0;
					foreach($fld as $fld_col)
					{
						if($i==0){
							// c'est l'id du champ
							$jHtml .= '<td>'.$fld_col.'</td>';
							$id_fld = $fld_col;
						}else if($i == 1){
							// c'est le nom de champ
							$jHtml .= '<td>'.$fld_col.'</td>';
							$name_fld = $fld_col;
						}
						else if($i == 2){
							// c'est le type de champ
							$jHtml .= '<td>'.$fld_col.'</td>';
							$type_fld = $fld_col;
						}
						else if($i == 3)
						{
						// si on est sur les valeurs possibles
							if($type_fld == "IntegerList"){
								$res_col_fld='';
								$fld_col_tab = explode(';',$fld_col);
								$p = '';
								foreach($fld_col_tab as $col_fld){
									if(is_numeric($col_fld)){
										$res_col_fld .= $col_fld .  ' : ';
									}else{
										$res_col_fld .= $col_fld . '<br />';
									}
								}
							}else{
								$res_col_fld = '';
							}
								$jHtml .= '<td><div class="list_min">'.$res_col_fld.'</div></td>';
						}
						// on incrémente
						$i++;
					}
					$jHtml .= '<td>';
											
						if($type_fld == 'Text')
						{
							// si champ texte ou email
							$jHtml .= '<select class="u_format">';
								$jHtml .= '<option value="0" selected="selected">'.$oResources->rsc_table_format_none.'</option>';
								$jHtml .= '<option value="Lowercase">'.$oResources->rsc_table_format_lowercase.'</option>';
								$jHtml .= '<option value="Uppercase">'.$oResources->rsc_table_format_uppercase.'</option>';
								$jHtml .= '<option value="First">'.$oResources->rsc_table_format_first.'</option>';
								$jHtml .= '<option value="AllFirst">'.$oResources->rsc_table_format_allfirst.'</option>';
							$jHtml .= '</select>';
						}else if($type_fld == 'Date')
						{
							// si champ date
							$jHtml .= '<select class="u_format">';
								$jHtml .= '<option value="" selected="selected">'.$oResources->rsc_table_format_none.'</option>';
							$jHtml .= '</select>';
						}else if($type_fld == 'IntegerList' || $type_fld == 'EmailAddress')
						{
							// si champ entier
							$jHtml .= '<select class="u_format">';
								$jHtml .= '<option value="" selected="selected">'.$oResources->rsc_table_format_none.'</option>';
							$jHtml .= '</select>';
						}else if($type_fld == 'Numeric')
						{
							// si champ numérique
							$jHtml .= '<select class="u_format">';
								$jHtml .= '<option value="" selected="selected">'.$oResources->rsc_table_format_none.'</option>';
								$jHtml .= '<option value="">'.$oResources->rsc_table_format_zerofill.'</option>';
							$jHtml .= '</select>';
						}
						
					
					$jHtml .= '</td>';
					
					$jHtml .= '<td>';
						if($type_fld == 'SubscriberId' || $type_fld == 'EmailAddress'){
						$jHtml .= '<input type="hidden" value="" class="u_default" />';
						}else{
							$jHtml .= '<input type="text" value="" class="u_default" />';
						}
					$jHtml .= '</td>';
	
					
					
					$jHtml .= '<td>';
						$jHtml .= '<span class="valid"><input class="validation" type="button" value="'.$oResources->rsc_btn_add.'" id="submit_add_usrfield" /></span>';
					$jHtml .= '</td>';
					
				$jHtml .= '</tr>';
				$u++;
			}		
		$jHtml .= '</table>';	
		
		header('HTTP/1.1 200 OK');					
		echo($jHtml);			
	}
?>