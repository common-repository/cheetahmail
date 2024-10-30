<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);		
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
	$jHtml= '';
	$def_bdd = $MyEMST->getStructure();
	if(count($def_bdd)>3){
		$jHtml .= '<table class="cm">';
		
			$jHtml .= '<tr>';
				$jHtml .= '<th>'.$oResources->rsc_table_id.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_name.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_type.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_values.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_displaytext.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_sync.'</th>';
			$jHtml .= '</tr>';		
			
			$u = 0;
			
			foreach($def_bdd as $fld)
			{
				$jHtml .= '<tr>';
				$type_fld = 'Text';
				$i = 0;
					foreach($fld as $fld_col)
					{
						if($i==0){
							// c'est l'id du champ
							$jHtml .= '<td>'.$fld_col.'</td>';
						}else if($i == 1){
							// c'est le nom de champ
							$jHtml .= '<td>'.$fld_col.'</td>';
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
								$jHtml .= '<td><span class="minus">'.$res_col_fld.'</span></td>';
						}
						// on incrémente
						$i++;
					}
					
					if($u<=4 && $u != 1){
						$jHtml .= '<td><input type="text" value="" disabled="disabled" /></td>';
						$jHtml .= '<td><input type="checkbox" value="1" checked="checked" disabled="disabled" /></td>';
					}else{
						$jHtml .= '<td><input type="text" value="" /></td>';
						$jHtml .= '<td>';
							$jHtml .= '<input type="checkbox" value="1" />';							
							$jHtml .= '';
						$jHtml .= '</td>';

					}
				$jHtml .= '</tr>';
				$u++;
			}		
		$jHtml .= '</table>';	
		
		// bouton soumission
		$jHtml .= '<p>';
			$jHtml .= '<span class="valid"><input class="validation" type="button" value="'.$oResources->rsc_btn_update.'" id="submit_update_structure" /></span>';
		$jHtml .= '</p>';
		header('HTTP/1.1 200 OK');					
		echo($jHtml);			
	}else{
		// API ne fonctionne pas
		header('HTTP/1.1 200 OK');	
		echo -1;
	}
?>