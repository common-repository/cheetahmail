<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);	
	$jHtml= '';
	$def_bdd = $MyEMST->getStructureLive();
	// print_r($def_bdd);
	if(count($def_bdd)>0)
	{
		$jHtml .= '<table class="cm">';		
			$jHtml .= '<tr>';
				$jHtml .= '<th>'.$oResources->rsc_table_type.'</th>';
				$jHtml .= '<th width="15%">'.$oResources->rsc_table_displaytext.'</th>';				
				$jHtml .= '<th>'.$oResources->rsc_table_values.'</th>';
				$jHtml .= '<th width="10%">'.$oResources->rsc_table_format.'</th>';
				$jHtml .= '<th width="10%">'.$oResources->rsc_table_size.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_sync.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_editable.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_displayed.'</th>';
				$jHtml .= '<th width="10%">'.$oResources->rsc_table_toppage.'</th>';
				$jHtml .= '<th>'.$oResources->rsc_table_fixed_value.'</th>';
			$jHtml .= '</tr>';				
			$u = 0;
			
			foreach($def_bdd as $fld)
			{
				if($fld->id == 1){
					$jHtml .= '<tr title="'.$fld->id.'">';
				}
				else if($fld->id <=4 ){
					$jHtml .= '<tr title="'.$fld->id.'" class="disabled">';
				}else{
					$jHtml .= '<tr title="'.$fld->id.'">';
				}
					// c'est l'id du champ
					// $jHtml .= $fld->id;
					// c'est le type de champ
					if($fld->type == 4){
						$jHtml .= '<td><img title="4"  src="../wp-content/plugins/cheetahmail/img/_type_fld_key.png" /></td>';
					}else if($fld->type == 0){
						$jHtml .= '<td><img title="0" src="../wp-content/plugins/cheetahmail/img/_type_fld_txt.png" /></td>';
					}else if($fld->type == 1){
						$jHtml .= '<td><img title="1" src="../wp-content/plugins/cheetahmail/img/_type_fld_arobase.png" /></td>';
					}else if($fld->type == 2){
						$jHtml .= '<td><img title="2" src="../wp-content/plugins/cheetahmail/img/_type_fld_date.png" /></td>';
					}else if($fld->type == 3){
						$jHtml .= '<td><img title="3"  src="../wp-content/plugins/cheetahmail/img/_type_fld_int.png" /></td>';
					}else if($fld->type == 5){
						$jHtml .= '<td><img title="5" src="../wp-content/plugins/cheetahmail/img/_type_fld_list.png" /></td>';
					}					
					$type_fld = $fld->type;							
					
					// c'est le nom de champ
					
					if($fld->id == 1)
					{
						$jHtml .= '<td><input class="_fld_display_value" type="text" value="'.$fld->display_name.'"  /></td>';
					}else if($fld->id <= 4 ){
						$jHtml .= '<td><input readonly="readonly" class="_fld_display_value" type="text" value="'.$fld->display_name.'"  /></td>';
					}else{
						$jHtml .= '<td><input class="_fld_display_value" type="text" value="'.$fld->display_name.'"  /></td>';
					}
							
					// si on est sur les valeurs possibles
					if($type_fld == 5){
						$res_col_fld='';
						$fld_col_tab = explode(';;;',$fld->values);
						foreach($fld_col_tab as $col_fld){
							$fld_col_t = explode('___',$col_fld);
							if(trim($fld_col_t[0])>=0 && strlen(trim($fld_col_t[1]))> 0 ){
							$res_col_fld .= trim($fld_col_t[0]) .  ' : ' .trim($fld_col_t[1]) . '<br />';
							}
						}
					}else{
						$res_col_fld = '';
					}						
					$jHtml .= '<td><span class="minus">'.$res_col_fld.'</span></td>';									
					if($fld->id == 1)
					{
					
						$jHtml .= '<td align="center">';
							$jHtml .= '<select class="_fld_formatting_value">';
								$jHtml .= '<option value="0" ';
								if($fld->formatting == 0){
									$jHtml .= ' selected="selected" ';
								}							
								$jHtml .= '>'.$oResources->rsc_table_format_none.'</option>';			
								$jHtml .= '<option value="1" ';
								if($fld->formatting == 1){
									$jHtml .= ' selected="selected" ';
								}	
								$jHtml .= '>'.$oResources->rsc_table_format_lowercase.'</option>';
								$jHtml .= '<option value="2" ';
								if($fld->formatting == 2){
									$jHtml .= ' selected="selected" ';
								}	
								$jHtml .= '>'.$oResources->rsc_table_format_uppercase.'</option>';
								$jHtml .= '<option value="3" ';
								if($fld->formatting == 3){
									$jHtml .= ' selected="selected" ';
								}	
								$jHtml .= '>'.$oResources->rsc_table_format_first.'</option>';
								$jHtml .= '<option value="4" ';
								if($fld->formatting == 4){
									$jHtml .= ' selected="selected" ';
								}	
								$jHtml .= '>'.$oResources->rsc_table_format_allfirst.'</option>';

							$jHtml .= '</select>';
						$jHtml .= '</td>';
						$jHtml .= '<td align="center">';
						if($fld->type <4 && $fld->type != 2){
							$jHtml .= '<input type="text" class="_fld_size_value" value="'.$fld->size.'" />';
						}else{
							$jHtml .= '<input type="hidden" class="_fld_size_value" value="0" />';
						}
						$jHtml .= '</td>';
						$jHtml .= '<td align="center"><input type="checkbox" class="_fld_synchronize_value" value="1" checked="checked" disabled="disabled" /></td>';
						$jHtml .= '<td align="center"><input type="checkbox" class="_fld_editable_value" value="1" checked="checked" disabled="disabled" /></td>';
						$jHtml .= '<td align="center"><input type="checkbox" class="_fld_displayed_value" value="1" checked="checked" disabled="disabled" /></td>';
						$jHtml .= '<td align="center"><input class="_fld_toppage" type="hidden" value="0"  /></td>';
						$jHtml .= '<td align="center"><input class="_fld_fixed_value" type="hidden" value="" /></td>';

					}
					else if($fld->id <= 4 )
					{
						
						$jHtml .= '<td align="center">';
							$jHtml .= '<select style="display:none" class="_fld_formatting_value">';
								$jHtml .= '<option value="0">'.$oResources->rsc_table_format_none.'</option>';			
							$jHtml .= '</select>';
						$jHtml .= '</td>';
						
						$jHtml .= '<td align="center">';
						if($fld->type <4 && $fld->type != 2){
							$jHtml .= '<input type="text" class="_fld_size_value" value="'.$fld->size.'" />';
						}else{
							$jHtml .= '<input type="hidden" class="_fld_size_value" value="0" />';
						}
						$jHtml .= '</td>';
						
						$jHtml .= '<td align="center"><input type="checkbox" value="1" checked="checked" disabled="disabled" class="_fld_synchronize_value" /></td>';
						$jHtml .= '<td align="center"><input class="_fld_editable_value" type="checkbox" value="1" disabled="disabled" /></td>';
						$jHtml .= '<td align="center"><input class="_fld_displayed_value" type="checkbox" value="1" disabled="disabled" /></td>';
						$jHtml .= '<td align="center"><input class="_fld_toppage" type="hidden" value="0"  /></td>';
						$jHtml .= '<td align="center"><input class="_fld_fixed_value" type="hidden" value="" /></td>';
					}
					else
					{
						
						$jHtml .= '<td align="center">';
							$jHtml .= '<select ';
							if($fld->type != 0){
								$jHtml .= ' style="display:none" ';
							}
							$jHtml .= 'class="_fld_formatting_value">';
								$jHtml .= '<option value="0" ';
								if($fld->formatting == 0){
									$jHtml .= ' selected="selected" ';
								}							
								$jHtml .= '>'.$oResources->rsc_table_format_none.'</option>';			
								$jHtml .= '<option value="1" ';
								if($fld->formatting == 1){
									$jHtml .= ' selected="selected" ';
								}	
								$jHtml .= '>'.$oResources->rsc_table_format_lowercase.'</option>';
								$jHtml .= '<option value="2" ';
								if($fld->formatting == 2){
									$jHtml .= ' selected="selected" ';
								}	
								$jHtml .= '>'.$oResources->rsc_table_format_uppercase.'</option>';
								$jHtml .= '<option value="3" ';
								if($fld->formatting == 3){
									$jHtml .= ' selected="selected" ';
								}	
								$jHtml .= '>'.$oResources->rsc_table_format_first.'</option>';
								$jHtml .= '<option value="4" ';
								if($fld->formatting == 4){
									$jHtml .= ' selected="selected" ';
								}	
								$jHtml .= '>'.$oResources->rsc_table_format_allfirst.'</option>';

							$jHtml .= '</select>';
						$jHtml .= '</td>';
						
						$jHtml .= '<td align="center">';
						if($fld->type < 4 && $fld->type != 2){
							$jHtml .= '<input type="text" class="_fld_size_value" value="'.$fld->size.'" />';
						}else{
							$jHtml .= '<input type="hidden" class="_fld_size_value" value="0" />';
						}
						$jHtml .= '</td>';
						
						$jHtml .= '<td align="center"><input class="_fld_synchronize_value" ';
						if($fld->synchronize == 1){
							$jHtml .= ' checked="checked" ';
						}
						$jHtml .= ' type="checkbox" value="1" /></td>';							
						$jHtml .= '<td align="center"><input class="_fld_editable_value" checked="checked" type="checkbox" value="1" disabled="disabled" /></td>';			
						$jHtml .= '<td align="center"><input class="_fld_displayed_value" type="checkbox" value="1"';
						if( $fld->displayed == 1){
							$jHtml .= ' checked="checked"';
						}
						$jHtml .= ' /></td>';	
						
						// GESTION CHAMPS TOPPAGE + FIXED VALUE
						$jHtml .= '<td align="center">';
							$jHtml .= '<select class="_fld_toppage">';
								$jHtml .= '<option value="0" ';
								if($fld->toppage == 0){
									$jHtml .= ' selected="selected" ';
								}							
								$jHtml .= '>'.$oResources->rsc_table_toppage_none.'</option>';			
								$jHtml .= '<option value="1" ';
								if($fld->toppage == 1){
									$jHtml .= ' selected="selected" ';
								}	
								$jHtml .= '>'.$oResources->rsc_table_toppage_toppage.'</option>';
							$jHtml .= '</select>';
						$jHtml .= '</td>';
						
						$jHtml .= '<td align="center">';
							if($fld->type == 2){
								// si champ date
								$jHtml .= '<input type="text" id="" class="_fld_fixed_value datepicker" value="'.$fld->fixed_value.'" />';
							}else if($fld->type == 3){
								// si champ numérique
								$jHtml .= '<input type="text" id="" class="_fld_fixed_value numeric" value="'.$fld->fixed_value.'" />';
							}else if($fld->type != 5){
								// si le champ n'est pas de type liste entier
								$jHtml .= '<input type="text" id="" class="_fld_fixed_value" value="'.$fld->fixed_value.'" />';
							}else{
								$jHtml .= '<select class="_fld_fixed_value" '.$fld->fixed_value.'>';
								
									// on boucle sur les valeurs possibles et on selectionne la bonne
									$res_col_fld='';
									$fld_col_tab = explode(';;;',$fld->values);
									foreach($fld_col_tab as $col_fld){
										$fld_col_t = explode('___',$col_fld);
										if(trim($fld_col_t[0])>=0 && strlen(trim($fld_col_t[1]))> 0 ){
										$res_col_fld .= trim($fld_col_t[0]) .  ' : ' .trim($fld_col_t[1]) . '<br />';
										$jHtml .= '<option value="'.trim($fld_col_t[0]).'"';
										if(trim($fld_col_t[0]) == $fld->fixed_value){
											$jHtml .= ' selected="selected" ';
										}
										$jHtml .= '>'.trim($fld_col_t[1]).'</option>';
										}
									}
									
								$jHtml .= '</select>';
							}
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
		echo(trim($jHtml));			
	}else{
		// API ne fonctionne pas
		header('HTTP/1.1 200 OK');
		echo -1;
	}
?>