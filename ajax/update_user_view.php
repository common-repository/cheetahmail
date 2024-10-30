<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');

	if(isset($_POST['id_user']) && $_POST['id_user']>0){
	// on recup toute la config JSON
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);	
	$jHtml= '';
	$jHtml_inner= '';
	$def_bdd = $MyEMST->getStructureLive();
	$def_user = $MyEMST->GetUnitUserById($_POST['id_user']);
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);
	
	$jHtml .= '<h2>'.$oResources->rsc_table_update_user_title .' <div class="shut">X</div></h2>';	
	$jHtml .= '<div id="table_update_user">';		
	
	if(count($def_bdd)>0)
	{
			
		$u = 0;
		
		// pour chaque champ de la structure de base on boucle
		foreach($def_bdd as $fld)
		{				
			// $jHtml .= '<p >'.$def_user['FLD'.$fld->id].'</p>';
			// on regarde si le champ est apte
			if($fld->synchronize == 1)
			{
				if($fld->editable == 1){
					$jHtml_inner.= '<tr title="'.$fld->id.'">';
				}else{
					$jHtml_inner .= '<tr class="disabled" title="'.$fld->id.'">';
				}			
				$type_fld = $fld->type;	
			
				if($fld->displayed == 1 && $fld->editable == 1)
				{	
					if($type_fld == 4){
						// iduser
						$jHtml_inner .= '<td><img title="4"  src="../wp-content/plugins/cheetahmail/img/_type_fld_key.png" /></td>';
						// c'est le nom de champ
						$jHtml_inner .= '<td>'.$fld->display_name.' </td>';	
						$jHtml_inner .= '<td><input type="text" class="fld" id="fld_'.$fld->id.'" value="'.$def_user['FLD'.$fld->id].'" /></td>';	
					}else if($type_fld == 0){
						// texte
						$jHtml_inner .= '<td><img title="0" src="../wp-content/plugins/cheetahmail/img/_type_fld_txt.png" /></td>';
						// c'est le nom de champ
						$jHtml_inner .= '<td>'.$fld->display_name.'</td>';	
						$jHtml_inner .= '<td><input type="text" class="fld" maxlength="'.$fld->size.'" id="fld_'.$fld->id.'" value="'.$def_user['FLD'.$fld->id].'" /></td>';	
					}else if($type_fld == 1){
						// @
						$jHtml_inner .= '<td><img title="1" src="../wp-content/plugins/cheetahmail/img/_type_fld_arobase.png" /></td>';
						// c'est le nom de champ
						$jHtml_inner .= '<td>'.$fld->display_name.'</td>';	
						$jHtml_inner .= '<td><input type="text" class="fld" maxlength="'.$fld->size.'" id="fld_'.$fld->id.'" value="'.$def_user['FLD'.$fld->id].'" /></td>';	
					}else if($type_fld == 2){
						// date
						$jHtml_inner .= '<td><img title="2" src="../wp-content/plugins/cheetahmail/img/_type_fld_date.png" /></td>';
						// c'est le nom de champ
						$jHtml_inner .= '<td>'.$fld->display_name.'</td>';	
						$jHtml_inner .= '<td><input type="text" class="fld datepicker" id="fld_'.$fld->id.'" value="'.$def_user['FLD'.$fld->id].'" /></td>';	
					}else if($type_fld == 3){
						// numérique
						$jHtml_inner .= '<td><img title="3"  src="../wp-content/plugins/cheetahmail/img/_type_fld_int.png" /></td>';
						// c'est le nom de champ
						$jHtml_inner .= '<td>'.$fld->display_name.'</td>';	
						$jHtml_inner .= '<td><input type="text" class="fld numeric" maxlength="'.$fld->size.'" id="fld_'.$fld->id.'" value="'.$def_user['FLD'.$fld->id].'" /></td>';	
					}else if($type_fld == 5){
						// liste entiers
						$jHtml_inner .= '<td><img title="5" src="../wp-content/plugins/cheetahmail/img/_type_fld_list.png" /></td>';
						$jHtml_inner .= '<td>'.$fld->display_name.'</td>';	
						$res_col_fld='';
						$res_col_fld.= '<select id="fld_'.$fld->id.'" class="fld" >';						
						$fld_col_tab = explode(';;;',$fld->values);
						foreach($fld_col_tab as $col_fld){
							$fld_col_t = explode('___',$col_fld);
							if(strlen(trim($fld_col_t[0]))>0 && strlen(trim($fld_col_t[1]))>0){
								$res_col_fld .= '<option value="'.trim($fld_col_t[0]).'"';
								if(trim($fld_col_t[0]) == $def_user['FLD'.$fld->id]){
									$res_col_fld .= ' selected="selected" ';
								}
								$res_col_fld .= '>' .trim($fld_col_t[1]) . '</option>';
							}
						}
						$res_col_fld .= ' </select>';
						$jHtml_inner .= '<td>'.$res_col_fld.'</td>';
					}
				$u++;
				}// si non readonly
				else
				{
					// readonly
					if($type_fld == 5)
					{
						// liste entiers
						$jHtml_inner .= '<td><img title="5" src="../wp-content/plugins/cheetahmail/img/_type_fld_list.png" /></td>';
						$jHtml_inner .= '<td>'.$fld->display_name.'</td>';	

						$res_col_fld='';
						$res_col_fld.= '<select class="fld" id="fld_'.$fld->id.'" disabled="disabled">';
						
						$fld_col_tab = explode(';;;',$fld->values);
						foreach($fld_col_tab as $col_fld){
							$fld_col_t = explode('___',$col_fld);
							if(strlen(trim($fld_col_t[0]))>0 && strlen(trim($fld_col_t[1]))>0){
								$res_col_fld .= '<option value="'.trim($fld_col_t[0]).'"';
								if($fld_col_t[0] == $def_user['FLD'.$fld->id]){
									$res_col_fld .= ' selected="selected" ';
								}
								$res_col_fld .= '>' .trim($fld_col_t[1]) . '</option>';
							}
						}
						$res_col_fld .= ' </select>';
						$jHtml_inner .= '<td>'.$res_col_fld.'</td>';
					}
					else
					{
						// other
						if($type_fld == 4){
							$jHtml_inner .= '<td><img title="4"  src="../wp-content/plugins/cheetahmail/img/_type_fld_key.png" /></td>';
						}else if($type_fld == 0){
							$jHtml_inner .= '<td><img title="0" src="../wp-content/plugins/cheetahmail/img/_type_fld_txt.png" /></td>';
						}else if($type_fld == 1){
							$jHtml_inner .= '<td><img title="1" src="../wp-content/plugins/cheetahmail/img/_type_fld_arobase.png" /></td>';
						}else if($type_fld == 2){
							$jHtml_inner .= '<td><img title="2" src="../wp-content/plugins/cheetahmail/img/_type_fld_date.png" /></td>';	
						}else if($type_fld == 3){
							$jHtml_inner .= '<td><img title="3"  src="../wp-content/plugins/cheetahmail/img/_type_fld_int.png" /></td>';
						}
						
							// $jHtml .= '<td><img title="5" src="../wp-content/plugins/cheetahmail/img/_type_fld_list.png" /></td>';
							$jHtml_inner .= '<td>'.$fld->display_name.' </td>';	
							$jHtml_inner .= '<td><input type="text" class="fld" id="fld_'.$fld->id.'" value="'.$def_user['FLD'.$fld->id].'" disabled="disabled" /></td>';	
						}
				$u++;
				}// si  readonly
			$jHtml_inner .= '</tr>';			
			}
			else
			{
				// le champ est invisible
				$jHtml_inner .= '<input type="hidden" class="fld" id="fld_'.$fld->id.'" value="'.$def_user['FLD'.$fld->id].'" />';
			}
							
			
		} // fin foreach	
		
		
		

		if($u>0){
			// bouton soumission
			$jHtml .= '<table class="cm">';	
				$jHtml .= $jHtml_inner;
			$jHtml .= '</table>';
			$jHtml .= '<p>';
				$jHtml .= '<span class="valid"><input class="validation" type="button" value="'.$oResources -> rsc_btn_update.'" id="submit_update_user" /></span>';
			$jHtml .= '</p>';
			
		}else{
			// nothing
			$jHtml .= '<p>' . $oResources -> rsc_table_update_no_result . '</p>';
		}
	}else
	{
		// API ne fonctionne pas
	}
	$jHtml .= '</div>';	
	header('HTTP/1.1 200 OK');	
	echo $jHtml;
	}
	
?>