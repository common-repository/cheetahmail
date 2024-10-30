<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
	$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
			
	if(
	( isset($_POST['idTemplate']) && $_POST['idTemplate']>0)
	)
	{
		// on ajoute le template
		$MyTemplate = $MyEMST->GetTemplateById($_POST['idTemplate']);
		$jHtml = '';
		$jHtml .= '<h2>'.$MyTemplate['name'].' <div class="shut">X</div></h2>';
		$jHtml .= '<input value="'.$MyTemplate['id'].'" id="template_id" type="hidden" />';
		$jHtml .= '<div>';
		$jHtml .= '<p><label for="template_name">'.$oResources->rsc_tpl_name.' <span class="required">*</span></label><input type="text" class="subj" value="'.htmlspecialchars($MyTemplate['name']).'" id="template_name" maxlength="250" /></p>';
		$jHtml .= '<p><label for="template_subject">'.$oResources->rsc_tpl_subject.' <span class="required">*</span></label><input type="text" class="subj" id="template_subject" value="'.htmlspecialchars($MyTemplate['subject']).'" maxlength="250" /></p>';		
		$jHtml .= '<p><label class="switcher active" id="1">'.$oResources->rsc_tpl_html.'</label><label class="switcher" id="2">'.$oResources->rsc_tpl_txt.'</label></p>';
		$jHtml .= '<div><p class="switch" id="1"><textarea id="template_html" class="txt rich-editor">'.$MyTemplate['html'].'</textarea></p></div>';
		$jHtml .= '<p class="switch" id="2" style="display:none"><span class="valid"><input type="button" value="'.$oResources->rsc_config_htmltotxt.'" id="generate_tpl_txt_edit" class="load" /></span><textarea class="txt" id="template_txt">'.$MyTemplate['txt'].'</textarea></p>';	
		$jHtml .= '<p><span class="valid"><input type="button"  name="save_changes" value="'.$oResources->rsc_btn_update.'" id="submit_change_template" title="'.$MyTemplate['id'].'" /></span></p>';		
		$jHtml .= '<div class="loading_area" id="loading_area_tpl_save" style="display:none"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div> ';
		$jHtml .= '</div>';		
		header('HTTP/1.1 200 OK');	
		echo $jHtml;			
	}
	else
	{
		// paramètres NOK
		header('HTTP/1.1 200 OK');	
		echo -2;
	}
?>