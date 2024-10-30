<?php
	include('../fn/fn.php');
	require('../../../../wp-blog-header.php');
	$tab_config_values = getVarWithoutSession();
	$oIdlist = $tab_config_values['CMFR__api_idmlist'];
	$oLogin = $tab_config_values['CMFR__api_login'];
	$oPassword = $tab_config_values['CMFR__api_password'];	
	$oPassword = $tab_config_values['CMFR__api_password'];
	$oEMails = $tab_config_values['CMFR__idquery_bat_emails'];
	$oEMails_tab = explode(chr(10),$oEMails);
	$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
			
	if(isset($_POST['type']) && $_POST['type']>0)
	{
		// on est ok sur les params
		if($_POST['type'] == 1){
			$oChrono = $tab_config_values['CMFR__idchrono_subs'];
			$html_o = $tab_config_values['CMFR__html_subs'];
			$txt_o = $tab_config_values['CMFR__txt_subs'];
			$subject_o = $tab_config_values['CMFR__subject_subs'];
		}else if($_POST['type'] == 2){
			$oChrono = $tab_config_values['CMFR__idchrono_unsubs'];
			$html_o = $tab_config_values['CMFR__html_unsubs'];
			$txt_o = $tab_config_values['CMFR__txt_unsubs'];
			$subject_o = $tab_config_values['CMFR__subject_unsubs'];
		}	
		
		$html = str_replace('&quot;','"',utf8_encode($html_o));
		$txt = str_replace('&quot;','"',utf8_encode($txt_o));
		$subject = str_replace('&quot;','"',utf8_encode($subject_o));
			
		foreach($oEMails_tab as $e){
			if(strlen($e)>0){
				try{
					$iduser = $MyEMST->FindByEmail($e);
					$array_chrono_test = array('chronoId'=>$oChrono,'userId'=>$iduser,'HTMLsource'=>$MyEMST->TrackHTMLLinks($html,true),'TXTsource'=>$MyEMST->TrackHTMLLinks($txt,false),'subject'=>$subject,'attachementPath'=>'','deleteAttachementFile'=>false);
					$res = $MyEMST->_chronocontact->SendMailHTML($array_chrono_test)->SendMailHTMLResult;
					// print_r($array_chrono_test) .'<br />' .print_r($res).'<br />';
					// print_r($res);
				}catch(Exception $e)
				{
					// error					
				}
			}
		}		
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