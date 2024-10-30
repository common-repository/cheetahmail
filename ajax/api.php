<?php

// function pour connaitre une valeur sans session

function getVarWithoutSession($var_to_search = '')
{
	global $wpdb;
	$alloptions = array();
	if($var_to_search != ''){
		$alloptions[$var_to_search] = get_option($var_to_search);
	}else{
		$alloptions_db = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options" );
		foreach ( (array) $alloptions_db as $o ) {
			$alloptions[$o->option_name] = $o->option_value;
		}
	}
	return $alloptions;
}


function transToTimeStamp($date)
{
	$tab_ar = explode('T',$date);
	$tab_arr = explode('-',$tab_ar[0]);
	$tab_arrr = explode(':',$tab_ar[1]);
	return mktime(
	intval(
	$tab_arrr[0]),
	intval($tab_arrr[1]),
	intval($tab_arrr[2]),
	intval($tab_arr[1]),
	intval($tab_arr[2]),
	intval($tab_arr[0])
	);
}


function transFromISOToDate($date,$lang=0,$format=0)
{
	$tab_ar = array();
	$date = trim($date);
	
	if(strpos($date,'T'))
	{
		$tab_ar = explode('T',$date);
	}
	else if(strpos($date,' '))
	{
		$tab_ar = explode(' ',$date);
	}else{
		return '';
	}
	
	$tab_arr = explode('-',$tab_ar[0]);	
	$tab_arrr = explode(':',$tab_ar[1]);
	if($lang == 0){
		// cas FR
		if($format == 0){
			return $tab_arr[2].'/' .$tab_arr[1].'/' .$tab_arr[0] . '  ' .$tab_arrr[0] .':'. $tab_arrr[1] ;
		}else{
			return $tab_arr[2].'/' .$tab_arr[1].'/' .$tab_arr[0];			
		}
	}else if($lang == 1){
		// cas UK
		if($format == 0){
			return $tab_arr[1].'/' .$tab_arr[2].'/' .$tab_arr[0] . '  ' .$tab_arrr[0] .':'. $tab_arrr[1] ;
		}else{
			return $tab_arr[1].'/' .$tab_arr[2].'/' .$tab_arr[0];			
		}
	}
	

}


class SoapClientEMST extends SoapClient
{
    const EMS_WS_NAMESPACE = "http://ws.ems6.net/";
    
    
    function SoapClientEMST( $username, $pwd, $idmlist, $wsdl, $options=array() )
    {
        parent::__construct( $wsdl, $options  );
        $this->__setSoapHeaders( $this->createHeader( $username, $pwd, $idmlist ) );
    }
    private function createHeader( $username, $pwd, $idmlist )
    {
        @$struct->UserName = new SoapVar( $username, XSD_STRING, null, null, null, self::EMS_WS_NAMESPACE );
        $struct->Password = new SoapVar( $pwd, XSD_STRING, null, null, null, self::EMS_WS_NAMESPACE );
        $struct->IdMlist = new SoapVar( $idmlist, XSD_INTEGER, null, null, null, self::EMS_WS_NAMESPACE );
        $header_values = new SoapVar( $struct, SOAP_ENC_OBJECT, null, null, null, self::EMS_WS_NAMESPACE );
        $header = new SoapHeader( self::EMS_WS_NAMESPACE, "AuthHeader", $header_values );
        return $header;
    }
    
}


class emst extends SoapClientEMST
{
    var $oResources;	
    public function __construct( $Idmlist,    $Login ,    $Pwd , $Options =    array())
    {
        try
        {
            $Protocole = "https://ws1.ems6.net/";
            // $Protocole = "https://api.cheetahmail.fr/v1/";
            $this->_subscribers = new SoapClientEMST( $Login, $Pwd, $Idmlist, $Protocole."subscribers.asmx?WSDL", $Options );
            $this->_chronocontact = new SoapClientEMST( $Login, $Pwd, $Idmlist, $Protocole."chronocontact.asmx?WSDL", $Options);
            $this->_campaigns = new SoapClientEMST( $Login, $Pwd, $Idmlist, $Protocole."campaigns.asmx?WSDL", $Options);
            $this->_bodymanager = new SoapClientEMST( $Login, $Pwd, $Idmlist, $Protocole."bodymanager.asmx?WSDL", $Options);
            $this->_filter = new SoapClientEMST( $Login, $Pwd, $Idmlist, $Protocole."filters.asmx?WSDL", $Options);
            $this->_configs = new SoapClientEMST( $Login, $Pwd, $Idmlist, $Protocole."configsv2.asmx?WSDL", $Options );		
            $this->_stats = new SoapClientEMST( $Login, $Pwd, $Idmlist, $Protocole."stats.asmx?WSDL", $Options );
			$tab_config_values = getVarWithoutSession();
			$this -> oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);			
        }
        catch( Exception $e ){
			echo $e;
		}
    }
    
    public function __destruct()
	{
		// silence please
	}


	public function testConnexion()
	{
		
		// test subscribers
		try{
			$result = $this->_subscribers->GetFieldsDefinition();
		}catch(Exception $e){
			return 0;
		break;
		}
		
		// test chronocontact
		try{
			$result = $this->_chronocontact->GetTemplates();
		}catch(Exception $e){
			return 0;
		break;
		}
		
		// test _campaigns
		try{
			$result = $this->_campaigns->List();
		}catch(Exception $e){
			return 0;
		break;
		}

		// test _bodymanager
		try{
			$result = $this->_bodymanager->GetListCategory();
		}catch(Exception $e){
			return 0;
		break;
		}

		// test _filter
		try{
			$result = $this->_filter->List();
		}catch(Exception $e){
			return 0;
		break;
		}

		// test _configs
		try{
			$result = $this->_configs->ListConfig();
		}catch(Exception $e){
			return 0;
		break;
		}

		// test _stats
		try{
			$result = $this->_stats->List();
		}catch(Exception $e){
			return 0;
		break;
		}
		
		// si on arrive ici c'est que tout est ok
		return 1; break;
	}


	// RECUPERATION STRUCTURE DB CHEETAHMAIL
	public function getStructure()
	{
		
		// un teste par api nécessaire : le but est de vérifier que le client a tous les droits
		try{
			$result = $this->_subscribers->GetFieldsDefinition();
		}catch(Exception $e){
			return $e;
		break;
		}
		if(count($result->GetFieldsDefinitionResult->FieldDefinition)>0){
			return $result->GetFieldsDefinitionResult->FieldDefinition ;
		}else{
			return -2;
		}
	}
	
	// RECUPERATION STRUCTURE DB CHEETAHMAIL
	public function getStructureLive()
	{		
			$result = get_option('CMFR__db_mapping');
			// print_r($result);
			$return_tab = json_decode($result);
			return $return_tab;
	}
	


	// TRACKING	
    public function TrackUnitLink($link)
    {
        if(empty($link)){
            return -2;
        }
        else{
            try{
                $Params_track = array('_strLink' => $link,'_strDescription' => $link,'_firstCategory' => 0,'_secondCategory' => 0,'_bAdd'=>false);
                $result_track = $this ->_bodymanager-> TrackLink($Params_track) -> TrackLinkResult;
                 return $result_track;
            }catch(SoapFault $e)
            {
               return -2;
            }
        }
    }
    
	
    public function TrackHTMLLinks($code,$ishtml=true,$iswa = 0,$idwa = 0, $idcamp = 0)
    {

        if(empty($code)){
            return -2;
        }
        else{
			if($iswa > 0 && $idwa > 0 && $idcamp > 0){
				// MODE WA
				try{
					$Params_track = array('_strBody' => $code,'_firstCategory' => 0,'_secondCategory' => 0,'_bisHtml' => $ishtml,'_idCamp' => $idcamp,'_idSent' => 1,'_idWA' => $idwa);
					$result_track = $this ->_bodymanager-> TrackBodyForWebAnalytics($Params_track)  -> TrackBodyForWebAnalyticsResult;
					return $result_track;
				}catch(SoapFault $e)
				{
					return -1;
				}
			}else{
				// MODE TRACKING SIMPLE
				try{
					$Params_track = array('_strBody' => $code,'_firstCategory' => 0,'_secondCategory' => 0,'_bisHtml' => $ishtml);
					$result_track = $this ->_bodymanager-> TrackBody($Params_track)  -> TrackBodyResult;
					return $result_track;
				}catch(SoapFault $e)
				{
					return -1;
				}
			}
			

        }
    }
    

	
/*
******************************************************************
GESTION DES FONCTIONS QUI FONT APPEL A WORDPRESS
******************************************************************
*/


	// GESTION VARIABLES WORDPRESS
	public function getVar($var_to_search)
	{
		global $wpdb;
		$alloptions = array();
		if($var_to_search != ''){
			$alloptions[$var_to_search] = get_option($var_to_search);
		}else{
			$alloptions_db = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'CMFR_%' " );
			foreach ( (array) $alloptions_db as $o ) {
				$alloptions[$o->option_name] = $o->option_value;
			}
		}
		return $alloptions;				
	}	
	
	public function setVars($tab)
	{
		foreach($tab as $key=>$value){
			add_option($key,$value,'no');
			update_option($key,$value,'no');
		}	
		return true;				
	}
	
	
	
	// pour la partie configuration
	public function getListPages($old_wp,$type)
	{
		$txt_return ='';
		$pages = get_pages(array('sort_order' => 'ASC','sort_column'=>'post_date','show_date'=>'created','post_type'=>'page','post_status'=>'publish'));
		if($type == 1){
			$txt_return .= '<option title="" value="-1" ';
			if($old_wp == -1){
			$txt_return .= ' selected="selected" ';
			}
			$txt_return .= '> CheetahMail default link</option>';	
		}
		foreach ( $pages as $page ) {
			$option .= '<option title="' . get_page_link( $page->ID ) . '" value="'. $page->ID .'"';
			if($old_wp == $page->ID){
				$option .= ' selected="selected" ';
			}
			$option .= ' >';
			$option .= $page->post_title;
			$option .= '</option>';
			$txt_return .= $option;
		}
		return($txt_return);
	}	


	public function getListPagesForNL($old_wp_date,$type=0,$nb=0,$order="DESC")
	{
		switch($nb){
			case "0" : $nb = 5; break;
			case "1" : $nb = 10; break;
			case "2" : $nb = 20; break;
			case "3" : $nb = 50; break;
			case "4" : $nb = 100; break;
		}	
		
		
		$pages = get_pages(array('sort_order' => $order,'sort_column'=>'post_date','show_date'=>'created','post_type'=>'page','post_status'=>'publish'));
		$posts = get_posts(array('order'=>$order,'orderby'=>'post_date','post_type'=>'post','post_status'=>'publish'));
		
		$option = array();
		$counter = 0;
		if(!empty($pages) && count($pages)>0 && ($type == "0" || $type == "2") ){
			foreach ( $pages as $page ) {
				if(
				$page->post_password == "" 
				&& transToTimeStamp($page->post_date) > transToTimeStamp($old_wp_date)
				&& $counter<$nb
				){				
					if ( has_post_thumbnail()) {
					$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($page->ID),'thumbnail', true);
					$option[$counter]['img'] = $image_url[0];
					}else{
					$option[$counter]['img'] = '';
					}
					$option[$counter]['id'] = $page->ID;
					$option[$counter]['name'] = $page->post_title;
					$option[$counter]['content'] = $page->post_content;
					$option[$counter]['date'] = $page->post_date;
					$option[$counter]['link'] = get_page_link( $page->ID );					
					$counter++;
				}
			}
		}
		
		if(!empty($posts) && count($posts)>0 && ($type == "0" || $type == "1") ){
		
			foreach ( $posts as $post ) {
				if(
				$post->post_password == "" 
				&& transToTimeStamp($post->post_date) > transToTimeStamp($old_wp_date)
				&& $counter<$nb
				){
					if ( has_post_thumbnail()) {
					$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'thumbnail', true);
					$option[$counter]['img'] = $image_url[0];
					}else{
					$option[$counter]['img'] = '';
					}
					$option[$counter]['id'] = $post->ID;
					$option[$counter]['name'] = $post->post_title;
					$option[$counter]['content'] = $post->post_content;
					$option[$counter]['date'] = $post->post_date;
					$option[$counter]['link'] = get_page_link( $post->ID );
					$counter++;
				}
			}
		}

		

		return($option);
	}	
	
	
	public function getListPagesforEditor($id_item='')
	{
		if($id_item == ''){
			$pages = get_pages(array('sort_order' => 'DESC','sort_column'=>'post_date','show_date'=>'created','post_type'=>'page','post_status'=>'publish'));
			$posts = get_posts(array('order'=>'DESC','orderby'=>'post_date','post_type'=>'post','post_status'=>'publish'));	
			$option = array();
			$counter = 0;
			foreach ( $pages as $page ) {
				if($page->post_password == ""){
					$option[$counter]['id'] = $page->ID;
					$option[$counter]['name'] = $page->post_title;
					$option[$counter]['content'] = $page->post_content;
					$option[$counter]['date'] = $page->post_date;
					$option[$counter]['link'] = get_page_link( $page->ID );
					$option[$counter]['type'] = 0;
				}
				$counter++;
			}		
			foreach ( $posts as $post ) {
				if($post->post_password == ""){
					$option[$counter]['id'] = $post->ID;
					$option[$counter]['name'] = $post->post_title;
					$option[$counter]['content'] = $post->post_content;
					$option[$counter]['date'] = $post->post_date;
					$option[$counter]['link'] = get_page_link( $post->ID );
					$option[$counter]['type'] = 1;
				}
				$counter++;
			}
			return $option;
		}
		else
		{
			// on a une page get_page(
			$page = get_page($id_item);			
			if(!empty($page)){
				$option['id'] = $page->ID;
				$option['name'] = $page->post_title;
				$option['content'] = $page->post_content;
				$option['date'] = $page->post_date;
				$option['link'] = get_page_link( $page->ID );
				$option[$counter]['type'] = 0;				
			}else{
				$page = get_post($id_item);
				if(!empty($page)){
					$option['id'] = $page->ID;
					$option['name'] = $page->post_title;
					$option['content'] = $page->post_content;
					$option['date'] = $page->post_date;
					$option['link'] = get_page_link( $page->ID );
					$option[$counter]['type'] = 1;
				}
			}
			return $option;
		}
	}	

	

	// pour la partie configuration
	public function getListImagesFromWP()
	{
		$tab_return =array();
		$query_images_args = array(
			'post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,
		);
		$i = 0;
		$query_images = new WP_Query( $query_images_args );		
		foreach ( $query_images->posts as $image)
		{			
			$images = wp_get_attachment_url( $image->ID );
			$tab_return[$i]['id'] = $image->ID;
			$tab_return[$i]['src'] = $images;
			$i++;
		}		
		return($tab_return);
	}	


/*
******************************************************************
GESTION DES USERS
******************************************************************
*/

	public function GetUnitUserById( $iduser )
	{
		
		try{
			$params = array('subscriberId' => $iduser);
			$result = $this->_subscribers->Get($params);
			$tab = array();
			if(!empty($result->GetResult) && isset($result->GetResult)){				
				foreach($result->GetResult->ArrayOfString as $UserFld)
				{					
					$tab[$UserFld->string[0]] = $UserFld->string[1];				
					
				}
				return( $tab);			  				
			}else{
				// pas de resultat
				return -2;
			}
		} catch (SoapFault $e) {return -1;}
	}
	

	public function FindByEmail( $email )
	{
		try{
			$params = array('criteria'    =>    array(array('1',$email)));
			$result = $this->_subscribers->Find($params);
			
			if(!empty($result) && isset($result->FindResult)){
				$nb = count($result->FindResult);
				if ( !empty($result)  && $nb > 0 )
				{
					if (is_int($result->FindResult->int))
					{
						$idUser = $result->FindResult->int;
						return $idUser;
					}
					elseif(is_array($result->FindResult->int))
					{
						foreach($result->FindResult->int as $idUser)
						{
							return $idUser;
							break;
						}
					}			   
				}else{
					// pas de resultat
					return 0;
				}
			}else{
				// pas de resultat
				return 0;
			}
		} catch (SoapFault $e) {return -1;}
	}
	 

	public function SearchByEmail( $email )
	{

	$vars = getVarWithoutSession();
	$tab_result = array();
		
		try{
			$params = array('criteria'    =>    array(array('1','%'.$email.'%')));
			$result = $this->_subscribers->Find($params);
			
			if(!empty($result) && isset($result->FindResult)){
				$nb = count($result->FindResult);
				if ( !empty($result)  && $nb > 0 )
				{
					if (is_int($result->FindResult->int))
					{												
						$idUser = $result->FindResult->int;
						$txt = '';
						$data_user  = $this -> GetUnitUserById($idUser);
						$txt .= '';
						$cc = 0;
						
						$id_user = 0;
						$status_user = 0;
						$line_txt_val_temp_1 = '';
						$line_txt_val_temp_2 = '';
						$line_txt_val_temp_3 = '';
						$line_txt_val_temp_4 = '';
						
						foreach($data_user as $du){
						// pour chaque ligne de champ user						
							if($cc  == 0){$id_user = $du;}	
							if($cc  == 4){$status_user = $du;}	
							
							if ($cc == 1){
								$line_txt_val_temp_1 ='<td>' . $du . '</td>';
							}
							else if ($cc == 2)
							{
								$line_txt_val_temp_2 ='<td>' . transFromISOToDate($du,$vars['CMFR__api_date_lang']) . '</td>';
							}else if ($cc == 3)
							{
								$line_txt_val_temp_3 = '<td>' . transFromISOToDate($du,$vars['CMFR__api_date_lang']) . '</td>';
							}
							else if ($cc == 4)
							{
								if($status_user == 0){
									$line_txt_val_temp_4 =  '<td><img src="../wp-content/plugins/cheetahmail/img/_icon_subscribers.png" /></td>';
								}else if($status_user >=1 && $status_user<=2){
									$line_txt_val_temp_4 =  '<td><img src="../wp-content/plugins/cheetahmail/img/_icon_unsubscribers.png" /></td>';
								}
								else if($status_user == 9){
									$line_txt_val_temp_4 =  '<td><img src="../wp-content/plugins/cheetahmail/img/_icon_spam.png" /></td>';
								}else{
									$line_txt_val_temp_4 =  '<td><img src="../wp-content/plugins/cheetahmail/img/_icon_npai.png" /></td>';
								}								
							}
							

						$cc++;
						}
						$txt .= $line_txt_val_temp_4 . $line_txt_val_temp_1 . $line_txt_val_temp_2 . $line_txt_val_temp_3;
						// partie boutons action
						$txt .= '<td>';
						if($status_user < 2)
						{
							$txt .= '<div class="actions_switcher"> </div>';
							$txt .= '<div style="display: none;" id="'.$id_user.'" class="partial_buttons">';
							if($status_user == 0)
							{
								$txt .= '<span id="update" class="action_subscribers  update">'.$this -> oResources->rsc_table_action_update.'</span>';
								$txt .= '<span id="unsubscribe" class="action_subscribers unsubscribe">'.$this -> oResources->rsc_table_action_unsubscribe.'</span>';
							}
							else if($status_user == 1)
							{
								$txt .= '<span id="update" class="action_subscribers  update">'.$this -> oResources->rsc_table_action_update.'</span>';
								$txt .= '<span id="subscribe" class="action_subscribers subscribe">'.$this -> oResources->rsc_table_action_forcesubscribe.'</span>';
								$txt .= '<span id="delete" class="action_subscribers delete">'.$this -> oResources->rsc_table_action_delete.'</span>';
							}
							$txt .= '</div>';
							$txt .= '<div style="display:none" class="partial_loading">';							
								$txt .= '<img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif">';							
							$txt .= '</div>';	
						}
						$txt .= '</td>';	
				
						$txt = '<tr id="'.$id_user.'">'.$txt.'</tr>';
						$tab_result[] = $txt;
					
					}
					elseif(is_array($result->FindResult->int))
					{
						
						foreach($result->FindResult->int as $idUser)
						{
							$txt = '';
							$txt_before = '';
							$data_user  = $this -> GetUnitUserById($idUser);
							$txt .= '';
							$cc = 0;
							
							$id_user = 0;
							$status_user = 0;
							$line_txt_val_temp_1 = '';
							$line_txt_val_temp_2 = '';
							$line_txt_val_temp_3 = '';
							$line_txt_val_temp_4 = '';
							foreach($data_user as $du)
							{													
								if($cc  == 0){$id_user = $du;}	
								if($cc  == 4){$status_user = $du;}															
								if ($cc == 1){
									$line_txt_val_temp_1 = '<td>' .$du. '</td>';
								} else if($cc == 2){
									$line_txt_val_temp_2 .='<td>' . transFromISOToDate($du,$vars['CMFR__api_date_lang']). '</td>';
								} else if($cc == 3){
									$line_txt_val_temp_3 .= '<td>' .transFromISOToDate($du,$vars['CMFR__api_date_lang']). '</td>';
								}
								else if ($cc == 4)
								{
									if($status_user == 0){
										$line_txt_val_temp_4 .=  '<td><img src="../wp-content/plugins/cheetahmail/img/_icon_subscribers.png" /></td>';
									}else if($status_user >=1 && $status_user<=2){
										$line_txt_val_temp_4 .=  '<td><img src="../wp-content/plugins/cheetahmail/img/_icon_unsubscribers.png" /></td>';
									}
									else if($status_user == 9){
										$line_txt_val_temp_4 .=  '<td><img src="../wp-content/plugins/cheetahmail/img/_icon_spam.png" /></td>';
									}else{
										$line_txt_val_temp_4 .=  '<td><img src="../wp-content/plugins/cheetahmail/img/_icon_npai.png" /></td>';
									}								
								}								

							$cc++;
							}
							$txt .= $line_txt_val_temp_4 . $line_txt_val_temp_1 . $line_txt_val_temp_2 . $line_txt_val_temp_3;
							// partie boutons action
							$txt .= '<td>';
								if($status_user < 2)
								{
									$txt .= '<div class="actions_switcher"> </div>';
									$txt .= '<div style="display: none;" id="'.$id_user.'" class="partial_buttons">';
									if($status_user == 0)
									{
										$txt .= '<span id="update" class="action_subscribers update">'.$this -> oResources->rsc_table_action_update.'</span>';
										$txt .= '<span id="unsubscribe" class="action_subscribers unsubscribe">'.$this -> oResources->rsc_table_action_unsubscribe.'</span>';
									}
									else if($status_user == 1)
									{
										$txt .= '<span id="update" class="action_subscribers update">'.$this -> oResources->rsc_table_action_update.'</span>';
										$txt .= '<span id="subscribe" class="action_subscribers subscribe">'.$this -> oResources->rsc_table_action_forcesubscribe.'</span>';
										$txt .= '<span id="delete" class="action_subscribers delete">'.$this -> oResources->rsc_table_action_delete.'</span>';
									}
									$txt .= '</div>';
									$txt .= '<div style="display:none" class="partial_loading">';							
										$txt .= '<img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif">';							
									$txt .= '</div>';	
								}
							$txt .= '</td>';	
					
							$txt = '<tr id="'.$id_user.'">'.$txt.'</tr>';
							$tab_result[] = $txt;
						}
						
					}	
					return  $tab_result;
				}else{
					// pas de resultat
					return 0;
				}
			}else{
				// pas de resultat
				return 0;
			}
		} catch (SoapFault $e) {return -1;}
	}
	 

    public function AddByEmail($email)
    {  
		$iduser = $this->FindByEmail($email);
		// si iduser est inexistant
		if($iduser  == 0){
			try
			{
				$iduser = $this->_subscribers->Add(array('email'=>strtolower($email)))->AddResult;
				return $iduser;
			}
			catch(SoapFault $e){return("-1");}
		}else{
			// si existant
			// on réabonne			
			$params = array('subscriberId' =>$iduser ,'data' => array(array('3',''),array('4','0')));
			$update = $this->_subscribers->Update($params);
			return $iduser;
		}
    }
    

	public function AddByEmailForWPUsers($email)
    {  
		try{
		$iduser = $this->FindByEmail($email);
		// si iduser est inexistant
		if($iduser  == 0){
			try
			{
				$iduser = $this->_subscribers->Add(array('email'=>strtolower($email)))->AddResult;
				// on met le toppage
				return $iduser;
			}
			catch(SoapFault $e){return("-1");}
		}else{
			// si existant : on met le toppage
			return -1;
		}
		}
		catch(SoapFault $e){return("-2");}
    }
	
    public function UpdateByEmail($email,$type)
    {
	   // $type { 1 : subscribe ; 2 : unsubscribe }
        try{
			$params = array('criteria' => array(array('1',$email)));
			$result = $this->_subscribers->Find($params);
			
			$nb = count($result->FindResult);
			if ( !empty($result) && $nb > 0)
			{
				if (is_int($result->FindResult->int))
				{
					$idUser = $result->FindResult->int;
					$test_state = 0;
					
					if($type == 1){
						// on checke le state du user
						$inf_u = $this -> GetUnitUserById($idUser); 
						if($inf_u['FLD4'] <= 1){
							$params_update = array('subscriberId'=>$idUser,'data'=>array(array('FLD3',''),array('FLD4','0')));
							$test_state = 1;
						}
					}else if($type == 2){
						// on checke le state du user
						$inf_u = $this -> GetUnitUserById($idUser); 
						// print_r($inf_u);
						if($inf_u['FLD4'] <= 1){
							$params_update = array('subscriberId' => $idUser,'data'=> array(array("FLD4" , "1"),array("FLD3", date("Y-m-d\TH:i:s"))));
							$test_state = 1;
						}
					}
					if($test_state == 1){					
						$test = $this->_subscribers->Update($params_update)->UpdateResult;
					}
					return $idUser;
				}
				elseif(is_array($result->FindResult->int))
				{
					
					foreach($result->FindResult->int as $idUser)
					{
						$test_state = 0;
						$idUser = $result->FindResult->int;
						if($type == 1){
							// on checke le state du user
							$inf_u = $this -> GetUnitUserById($idUser); 
							if($inf_u['FLD4'] <= 1){
								$params_update = array('subscriberId'=>$idUser,'data'=>array('FLD3','','FLD4','0'));
								$test_state = 1;
							}
						}else if($type ==2){
							$inf_u = $this -> GetUnitUserById($idUser); 
							if($inf_u['FLD4'] <= 1){
								$params_update = array('subscriberId' => $idUser,'data'=> array(array("FLD4","1"),array("FLD3",date("Y-m-d\TH:i:s"))));
								$test_state = 1;
							}
						}
						
						if($test_state == 1){
							$test = $this->_subscribers->Update($params_update);
						}
					}					
						
					return $idUser;	
				}				
							   
			}else{
				// pas de resultat
				return 0;
			}
		} catch (SoapFault $e) {return $e;}
    }


	

    public function DeleteByEmail($email)
    {	
		try{
			$params = array('criteria' => array(array('1',$email)));
			$result = $this->_subscribers->Find($params);
			$nb = count($result->FindResult);
			if ( !empty($result) && $nb > 0)
			{
				if (is_int($result->FindResult->int))
				{
					$idUser = $result->FindResult->int;
					$params_delete = array('subscriberId' => $idUser);
					$this->_subscribers->Delete($params_delete)->DeleteResult;
					return $idUser;
				}
				elseif(is_array($result->FindResult->int))
				{	
					foreach($result->FindResult->int as $idUser)
					{
						if($idUser>0){
							$params_delete = array('subscriberId' => $idUser);
							$this->_subscribers->Delete($params_delete)->DeleteResult;
						}
					}						
					return $idUser;	
				}							   
			}else{
				// pas de resultat
				return 0;
			}
		} catch (SoapFault $e) {return $e;}
    }
	
	
	
	
	
    public function UpdateUserInfos($iduser,$var)
    {
		$array_fld = '';
		$i = 0;
		
		foreach($var as $key=>$value){
			if($key == 1 && strpos($value['val_fld'],'@')!== false && strpos($value['val_fld'],'.')!== false){
				$i = 1;
			}
			$array_fld[] = array('FLD'.$key,$value['val_fld']);
		}
		
		
		
		if($i == 1){
			// on est ok sur l'email
			$params_update = array(
				'subscriberId' => $iduser,
				'data'=> $array_fld				
			);
			// print_r($params_update);
			$test = $this->_subscribers->Update($params_update)->UpdateResult;
			// return $test;
			return 0;
		}		
		else
		{
			// email nok
			return -1;
		}
    }

	


	
    public function UpdateUserInfosFromBlank($iduser,$var)
    {
		$array_fld = '';
		$i = 0;
		
		foreach($var as $key=>$value){
			$array_fld[] = array('FLD'.$key,$value);
		}
		
		// on est ok sur l'email
		$params_update = array(
			'subscriberId' => $iduser,
			'data'=> $array_fld				
		);
		// print_r($params_update);
		$test = $this->_subscribers->Update($params_update)->UpdateResult;
		// return $test;
		return 0;
	
    }



	
/*
******************************************************************
SHORTCODES MANAGEMENT
******************************************************************
*/
		
	
	// RECUPERATION STRUCTURE DB CHEETAHMAIL POUR AFFICHER LE FORMULAIRE  FULL SUBSCRIPTION
	public function getStructureLiveForForm()
	{		
		$result = get_option('CMFR__db_mapping');
		$return_tab = json_decode($result);
		$def_bdd = $return_tab;
		$jHtml= '';		
		
		
		if(count($def_bdd)>0)
		{
			$jHtml .= '<form id="cheetahmail_form" title="'.get_bloginfo('wpurl').'" action="" method="post">';	
			foreach($def_bdd as $fld)
			{			
				if($fld->synchronize == 1 && $fld->displayed == 1 && $fld->editable == 1 && $fld->toppage != 1)
				{					
					$jHtml .= '<p>';
						$jHtml .= '<label for="fld_'.$fld->id.'">';
						$jHtml .= $fld->display_name;
						$jHtml .= '</label>';
						
						if($fld->type == 5)
						{
							$jHtml .= ' <select title="'.$fld->type.'||'.$fld->formatting.'" class="fld" id="fld_'.$fld->id.'">';
								// si on est sur les valeurs possibles
								$fld_col_tab = explode(';;;',$fld->values);
								$res_col_fld ='';
									foreach($fld_col_tab as $col_fld){
										$fld_col_t = explode('___',$col_fld);
										if(count($fld_col_t) > 0 && $fld_col_t[0]>=0 && strlen($fld_col_t[0])>0 && strlen($fld_col_t[1])>0)
										{
											$res_col_fld .= '<option value="'.$fld_col_t[0] .'">';
												$res_col_fld .= $fld_col_t[1];
											$res_col_fld .= '</option>';
										}
									}
								$jHtml .= $res_col_fld;
							$jHtml .= '</select>';
						}
						else if($fld->type == 2)
						{
							$jHtml .= ' <input title="'.$fld->type.'||'.$fld->formatting.'" type="text" id="fld_'.$fld->id.'" class="fld datepicker" value="" />';
						}
						else if($fld->type == 3)
						{
							$jHtml .= ' <input title="'.$fld->type.'||'.$fld->formatting.'" maxlength="'.$fld->size.'" type="text" class="fld numeric" id="fld_'.$fld->id.'"  value="" />';
						}
						else
						{
							$jHtml .= ' <input title="'.$fld->type.'||'.$fld->formatting.'" maxlength="'.$fld->size.'" type="text" class="fld" id="fld_'.$fld->id.'" value=""  />';
						}
					$jHtml .= '</p>';
				}else if($fld->toppage == 1){
					// input type  hidden
					$jHtml .= '<input title="'.$fld->type.'||'.$fld->formatting.'" type="hidden" class="fld" id="fld_'.$fld->id.'" value="'.$fld->fixed_value.'" />';					
				}else{
					// input à ne pas afficher
				}
			$u++;
			
		}
		
		$jHtml .= '<p>';
			$jHtml .= '<span class="valid">';
				$jHtml .= '<input type="button" id="cheetahmail_form_submit" value="'.$this -> oResources->rsc_btn_update.'" />';
			$jHtml .= '</span>';		
		$jHtml .= '</p>';		
		
		$jHtml .= '</form>';			
			
		return($jHtml);			
		}else{
			// API ne fonctionne pas
			echo -1;
		}
			
		
		// fin fonction
	}

	
	// RECUPERATION STRUCTURE DB CHEETAHMAIL POUR AFFICHER LE FORMULAIRE  FULL UPDATE
	public function getStructureLiveForUpdateForm()
	{		
		$result = get_option('CMFR__db_mapping');
		$return_tab = json_decode($result);
		$def_bdd = $return_tab;
		$jHtml= '';		
		$email = $_GET['email'];
		
		$iduser = $this -> FindByEmail($email);

		$inf_u =  $this -> GetUnitUserById ($iduser);
		
		
		if(count($def_bdd)>0)
		{		
			$jHtml .= '<form id="cheetahmail_form" title="'.get_bloginfo('wpurl').'" action="" method="post">';
				foreach($def_bdd as $fld)
				{		
					
						

					if($fld->synchronize == 1 && $fld->displayed == 1 && $fld->editable == 1 && $fld->toppage != 1)
					{
									
						$jHtml .= '<p>';
						$jHtml .= '<label for="fld_'.$fld->id.'">';
						$jHtml .= $fld->display_name;
						$jHtml .= '</label>';
							
							if($fld->type == 5)
							{
								$jHtml .= '<select title="'.$fld->type.'||'.$fld->formatting.'" class="fld" id="fld_'.$fld->id.'">';
									// si on est sur les valeurs possibles
									$fld_col_tab = explode(';;;',$fld->values);
									$res_col_fld ='';
										foreach($fld_col_tab as $col_fld){
											$fld_col_t = explode('___',$col_fld);
											if(count($fld_col_t) > 0 && $fld_col_t[0]>=0 && strlen($fld_col_t[0])>0 && strlen($fld_col_t[1])>0)
											{
												$res_col_fld .= '<option value="'.$fld_col_t[0] .'"';
													if( $inf_u['FLD'.$fld->id] == $fld_col_t[0]){
														$res_col_fld .= ' selected="selected" ';
													}
													
													
												$res_col_fld .= ' >';
													$res_col_fld .= $fld_col_t[1];
												$res_col_fld .= '</option>';
											}
										}
									$jHtml .= $res_col_fld;
								$jHtml .= '</select>';
							}
							else if($fld->type == 2)
							{
								$jHtml .= '<input title="'.$fld->type.'||'.$fld->formatting.'" type="text" id="fld_'.$fld->id.'" class="fld datepicker" value="'.$inf_u['FLD'.$fld->id].'" />';
							}
							else if($fld->type == 3)
							{
								$jHtml .= '<input title="'.$fld->type.'||'.$fld->formatting.'" maxlength="'.$fld->size.'" type="text" class="fld numeric" id="fld_'.$fld->id.'"  value="'.$inf_u['FLD'.$fld->id].'" />';
							}
							else
							{
								$jHtml .= '<input title="'.$fld->type.'||'.$fld->formatting.'" maxlength="'.$fld->size.'" type="text" class="fld" id="fld_'.$fld->id.'" value="'.$inf_u['FLD'.$fld->id].'"  />';
							}
						$jHtml .= '</p>';
					}
					else if($fld->toppage == 1){
					// input type  hidden
					$jHtml .= '<input title="'.$fld->type.'||'.$fld->formatting.'" type="hidden" class="fld" id="fld_'.$fld->id.'" value="'.$fld->fixed_value.'" />';					
					}
					else{
						// input à ne pas afficher
					}
				$u++;
				
			}
			$jHtml .= '<p>';
				$jHtml .= '<span class="valid">';
					$jHtml .= '<input type="button" id="cheetahmail_form_update_submit" value="'.$this -> oResources->rsc_btn_update.'" />';
				$jHtml .= '</span>';		
			$jHtml .= '</p>';		
			
			$jHtml .= '</form>';			
				
			return($jHtml);			
		}else{
			// API ne fonctionne pas
			echo -1;
		}
		
	
	// fin fonction
	}




/*
******************************************************************
GESTION DES CIBLES
******************************************************************
*/
	
    public function AddTarget($name,$unsubs = 0, $params = "no")
    {
        try{
			// tableau des params de la conf
			$array_filter = array( 	
			   'isPrivate'=> false,
				'description' => $name
			);

			$my_target = $this->_filter -> Create($array_filter)->CreateResult;	
			
			if($params != "no"){
				// cas envoi BAT	
				$this->_filter -> SetFields(
					array(
					'queryId'=>$my_target,
						'criteria' => array(
							array('IdField' => '1','Operation' => 'EQUAL', 'Value' => $params)						
						)
					)
				);
			}

			if($unsubs == 1){
				// cas unsubs	
				$this->_filter -> SetFields(
					array(
					'queryId'=>$my_target,
						'criteria' => array(
							array('IdField' => '4','Operation' => 'DIFFERENT', 'Value' => '0')						
						)
					)
				);				
			}	
			
			return  $my_target;
        } 
		catch (SoapFault $e){return $e;}
    }





    public function AddTargetUser($name,$params = array())
    {
        try{
			// tableau des params de la conf
			$array_filter = array( 	
			   'isPrivate'=> false,
				'description' => $name
			);
			$my_target = $this->_filter -> Create($array_filter)->CreateResult;				
			// die(print_r($params));	
			$this->_filter -> SetFields(
				array(
				'queryId'=>$my_target,
					'criteria' => $params				
				)
			);
			return  $my_target;
        } 
		catch (SoapFault $e){return $e;}
    }



	
    public function UpdateTarget($target,$params)
    {
        try{
			// modification de la cible
			$this -> _filter -> SetFields(array('queryId'=>$target,'criteria' => $params));			
			return  $my_target;
        } 
		catch (SoapFault $e){return $e;}
    }
	

	
	
	public function GetInfosByIdTarget($id_query)
	{
		try{
			$result = $this -> _filter -> GetFields(array('queryId'=>$id_query));			
			return $result -> GetFieldsResult;
		} catch (SoapFault $e) {return -1;}				
	}
	
	
	public function GetNumberByIdTarget($id_query)
	{
		try{
			$result = $this -> _filter -> CountFilter(array('_idFilter'=>$id_query));			
			return $result -> CountFilterResult;
		} catch (SoapFault $e) {return -1;}				
	}
	
	public function GetTargetsListSelect($id_query)
	{
		try{
			$vars = getVarWithoutSession();
			$oPrefixTarget = $vars['CMFR__prefix_target'];
			$result = $this -> _filter -> List() -> ListResult -> string;	
			// print_r($result);
			$return_txt = '';
			foreach($result as $ligne){
				$temp = explode(' - ',$ligne);
				$id_target = $temp[0];
				$name_target = $temp[1];
				if(strpos($name_target,$oPrefixTarget) !== false ){								
					$name_target_temp = explode($oPrefixTarget,$name_target);				
					$name_target = $name_target_temp[1];				
					$return_txt .= '<option ';
					if($id_target == $id_query){
						$return_txt .= ' selected="selected" ';
					}
					$return_txt .= ' value="'.$id_target.'">'.$name_target.'</option>';
				}
			}			
			return( $return_txt);
		} catch (SoapFault $e) {return -1;}				
	}
	
		
    public function UpdateBatTarget($params)
    {
        try{
			$my_target = $this->getVar('CMFR__idquery_bat');
			$my_target = $my_target['CMFR__idquery_bat'];
			//$my_target = $this -> getVar('CMFR__idquery_bat')['CMFR__idquery_bat'];
			// modification demandée
			$tab_params = array(
				'queryId'=>$my_target,
					'criteria' => array(
						array('IdField' => '1','Operation' => 'EQUAL', 'Value' => $params)
					)
				);
			// print_r($tab_params);
			$result_my_target = $this -> _filter -> SetFields($tab_params);	
			return  $my_target;
        } catch (SoapFault $e){return $e;}
    }
	
	
	
	// RECUPERATION STRUCTURE DB CHEETAHMAIL
	public function getStructureLiveForTarget($idquery=0)
	{		
		$result = get_option('CMFR__db_mapping');
		$return_tab = json_decode($result);
		$def_bdd = $return_tab;
		$jHtml= '';
		// print_r($def_bdd);
		if(count($def_bdd)>0)
		{
			$jHtml .= '<table class="cm">';		
				$jHtml .= '<tr>';
					$jHtml .= '<th width="50">'.$this -> oResources->rsc_table_type.'</th>';
					$jHtml .= '<th width="50">'.$this -> oResources->rsc_table_id.'</th>';				
					$jHtml .= '<th width="150">'.$this -> oResources->rsc_table_displaytext.'</th>';				
					$jHtml .= '<th width="100">'.$this -> oResources->rsc_table_operator.'</th>';
					$jHtml .= '<th>'.$this -> oResources->rsc_table_values.'</th>';
				$jHtml .= '</tr>';	
				
				$u = 0;
				if($idquery>0){
					$oQueryInfos = $this -> GetInfosByIdTarget($idquery)->Criterion;					
				}else
				{
					$oQueryInfos = '';
				}
				
				
				
				foreach($def_bdd as $fld)
				{			
					if($fld->id > 0)
					{
						$jHtml .= '<tr title="'.$fld->id.'">';									
							// le type de champ
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
							// l'id de champ
							$jHtml .= '<td>'.$fld->id.'</td>';						
							// le nom de champ						
							$jHtml .= '<td>'.$fld->display_name.'</td>';					
							// l'opérateur
							$jHtml .= '<td>';							
								$jHtml .= '<select class="fld_operator">';								
									$jHtml .= '<option ';
									
									if($oQueryInfos[$fld->id - 1]->Operation == "NONE"){
										$jHtml .= ' selected="selected" '; 
									}
									$jHtml .= ' value="NONE">'.$this -> oResources->rsc_operator_none.'</option>';	
	
									if($fld->type != 2 && $fld->type != 3){
										$jHtml .= '<option  ';
									if($oQueryInfos[$fld->id - 1]->Operation == "EQUAL"){
										$jHtml .= ' selected="selected" '; 
									}
									$jHtml .= ' value="EQUAL">'.$this -> oResources->rsc_operator_equal.'</option>';
										$jHtml .= '<option  ';
									if($oQueryInfos[$fld->id - 1]->Operation == "DIFFERENT"){
										$jHtml .= ' selected="selected" '; 
									}
									$jHtml .= ' value="DIFFERENT">'.$this -> oResources->rsc_operator_different.'</option>';
									}	

									if( $fld->type != 5 && $fld->type != 3)
									{
										$jHtml .= '<option ';
										if($oQueryInfos[$fld->id - 1]->Operation == "FILLED"){
											$jHtml .= ' selected="selected" ';
										}
										$jHtml .= ' value="FILLED">'.$this -> oResources->rsc_operator_filled.'</option>';
										$jHtml .= '<option  ';
										if($oQueryInfos[$fld->id - 1]->Operation == "NOTFILLED"){
											$jHtml .= ' selected="selected" ';
										}
										$jHtml .= ' value="NOTFILLED">'.$this -> oResources->rsc_operator_notfilled.'</option>';
									}
									/*
									if( $fld->type == 3 )
									{
										// sauf textes / email / liste entiers / numériques
										$jHtml .= '<option  ';
										if($oQueryInfos[$fld->id - 1]->Operation == "INFERIOR"){
											$jHtml .= ' selected="selected" '; 
										}
										$jHtml .= ' value="INFERIOR">INFERIOR</option>';
										$jHtml .= '<option  ';
										if($oQueryInfos[$fld->id - 1]->Operation == "SUPERIOR"){
											$jHtml .= ' selected="selected" '; 
										}
										$jHtml .= ' value="SUPERIOR">SUPERIOR</option>';
									}
									*/
									if($fld->type == 2)
									{
										// que date
										$jHtml .= '<option  ';
										if($oQueryInfos[$fld->id - 1]->Operation == "AGO"){
											$jHtml .= ' selected="selected" '; 
										}
										$jHtml .= ' value="AGO">'.$this -> oResources->rsc_operator_ago.'</option>';
										$jHtml .= '<option  ';
										if($oQueryInfos[$fld->id - 1]->Operation == "IN"){
											$jHtml .= ' selected="selected" '; 
										}
										$jHtml .= ' value="IN">'.$this -> oResources->rsc_operator_in.'</option>';
									}							
								$jHtml .= '</select>';
							$jHtml .= '</td>';
						
							// la valeur
							
							$jHtml .= '<td>';
							if($fld->type == 5)
							{
								$jHtml .= '<select ';
									if($idquery==0 || ($oQueryInfos[$fld->id - 1]->Operation == "NONE" || $oQueryInfos[$fld->id - 1]->Operation == "FILLED" || $oQueryInfos[$fld->id - 1]->Operation == "UNFILLED") ){
										$jHtml .=' style="display:none" ';
									}
									$jHtml .=' class="fld_value">';
									// si on est sur les valeurs possibles
									$fld_col_tab = explode(';;;',$fld->values);
									$res_col_fld ='';
										foreach($fld_col_tab as $col_fld){
											$fld_col_t = explode('___',$col_fld);
											if($fld_col_t[0]>=0 && strlen($fld_col_t[1])>0){
											$res_col_fld .= '<option ';
											if($fld_col_t[0] == $oQueryInfos[$fld->id - 1]->Value)
											{
												$res_col_fld .= ' selected="selected" ';
											}
											$res_col_fld .= ' value="'.$fld_col_t[0] .'">';
											$res_col_fld .= $fld_col_t[1];
											$res_col_fld .= '</option>';
											}
										}
									$jHtml .= $res_col_fld;
								$jHtml .= '</select>';
							}
							else if($fld->type == 2){
								$jHtml .= '<input ';
								if($idquery==0 || ($oQueryInfos[$fld->id - 1]->Operation == "NONE" || $oQueryInfos[$fld->id - 1]->Operation == "FILLED" || $oQueryInfos[$fld->id - 1]->Operation == "UNFILLED") ){
									$jHtml .=' style="display:none" ';
								}
								$jHtml .= ' type="text" id="'.$oQueryInfos[$fld->id - 1]->Value.'" class="fld_value numeric" value="" />';
							}
							else if($fld->type == 3){
								$jHtml .= '<input ';
								if($idquery==0 || ($oQueryInfos[$fld->id - 1]->Operation == "NONE" || $oQueryInfos[$fld->id - 1]->Operation == "FILLED" || $oQueryInfos[$fld->id - 1]->Operation == "UNFILLED") ){
									$jHtml .=' style="display:none" ';
								}
								$jHtml .= ' type="text" class="fld_value numeric" value="'.$oQueryInfos[$fld->id - 1]->Value.'" />';
							}
							else
							{
								$jHtml .= '<input ';
								if($idquery==0 || ($oQueryInfos[$fld->id - 1]->Operation == "NONE" || $oQueryInfos[$fld->id - 1]->Operation == "FILLED" || $oQueryInfos[$fld->id - 1]->Operation == "UNFILLED") ){
									$jHtml .=' style="display:none" ';
								}
								$jHtml .= ' type="text" class="fld_value" value="'.$oQueryInfos[$fld->id - 1]->Value.'" />';
							}						
						$jHtml .= '</td>';
				
					$jHtml .= '</tr>';
					$u++;
				}
			}
			$jHtml .= '</table>';						
				
			return($jHtml);			
		}else{
			// API ne fonctionne pas
			echo -1;
		}
		
	
	// fin fonction
	}




	
   
	public function GetSubscribers($id_query)
	{
		try{
			$vars = getVarWithoutSession();
			$line_txt = '';
			$result = $this->_filter->GetSubscriberForFilter(array('_nidFilter'=>$id_query));
			// print_r($result);
			if(!empty($result->GetSubscriberForFilterResult) && isset($result->GetSubscriberForFilterResult -> ArrayOfArrayOfString))
			{		
				if(count($result->GetSubscriberForFilterResult -> ArrayOfArrayOfString )> 1)
				{
					// print_r($result->GetSubscriberForFilterResult -> ArrayOfArrayOfString);
					// une ligne par user
					foreach($result->GetSubscriberForFilterResult ->ArrayOfArrayOfString as $line)
					{
						
						$i = 0;
						$id_user = 0;
						$email_user = '';
						$abo_user = '';
						$desabo_user = '';
						$status_user = 0;
						$line_txt_val = '';
						$line_txt_val_temp_1 = '';
						$line_txt_val_temp_2 = '';
						$line_txt_val_temp_3 = '';
						$line_txt_val_temp_4 = '';
						// une ligne par champ
						// pour chaque ligne on boucle sur chaque champ D_SUBS
						// on doit faire : 4,0,1,2,3
						foreach($line->ArrayOfString as $liner)
						{
						
							if($i == 0)
							{
								$id_user = $liner->string[1];
							} 
							
							if($i  == 1)
							{
								$line_txt_val_temp_1 = '<td>' . $liner->string[1].'</td>';
							}
							else if($i == 2)
							{
								$line_txt_val_temp_2 .= '<td>';
								if(strlen($liner->string[1])>2){
									 $line_txt_val_temp_2 .= transFromISOToDate($liner->string[1],$vars['CMFR__api_date_lang']);
								}
								$line_txt_val_temp_2 .= '</td>';
							}
							else if($i == 3)
							{
								$line_txt_val_temp_3 .= '<td>';
								if(strlen($liner->string[1])>2){
									 $line_txt_val_temp_3 .= transFromISOToDate($liner->string[1],$vars['CMFR__api_date_lang']);
								}
								$line_txt_val_temp_3 .= '</td>';
							}							
							else if($i == 4)
							{
								$line_txt_val_temp_4 .= '<td>';
								if($liner->string[1] == 0){
									$line_txt_val_temp_4 .=  '<img src="../wp-content/plugins/cheetahmail/img/_icon_subscribers.png" />';
								}else if($liner->string[1] >=1 && $liner->string[1]<=2){
									$line_txt_val_temp_4 .=  '<img src="../wp-content/plugins/cheetahmail/img/_icon_unsubscribers.png" />';
								}
								else if($liner->string[1] == 9){
									$line_txt_val_temp_4 .=  '<img src="../wp-content/plugins/cheetahmail/img/_icon_spam.png" />';
								}else{
									$line_txt_val_temp_4 .=  '<img src="../wp-content/plugins/cheetahmail/img/_icon_npai.png" />';
								}	
								
								$line_txt_val_temp_4 .= '</td>';
								$status_user = $liner->string[1];
							}

							$i++;
						}
						// on consolide la ligne avec les infos dans l'ordre : 
						$line_txt_val .= $line_txt_val_temp_4 . $line_txt_val_temp_1 . $line_txt_val_temp_2 . $line_txt_val_temp_3;
						
						// partie boutons action
						$line_txt_val .= '<td>';
							if($status_user <2)
							{
								$line_txt_val .= '<div class="actions_switcher"> </div>';
								$line_txt_val .= '<div style="display: none;" id="'.$id_user.'" class="partial_buttons">';
								if($status_user == 0)
								{
									$line_txt_val .= '<span id="update" class="action_subscribers update">'.$this -> oResources->rsc_table_action_update.'</span>';
									$line_txt_val .= '<span id="unsubscribe" class="action_subscribers unsubscribe">'.$this -> oResources->rsc_table_action_unsubscribe.'</span>';
								}
								else if($status_user == 1)
								{
									$line_txt_val .= '<span id="update" class="action_subscribers update">'.$this -> oResources->rsc_table_action_update.'</span>';
									$line_txt_val .= '<span id="subscribe" class="action_subscribers subscribe">'.$this -> oResources->rsc_table_action_forcesubscribe.'</span>';
									$line_txt_val .= '<span id="delete" class="action_subscribers delete">'.$this -> oResources->rsc_table_action_delete.'</span>';
								}
								$line_txt_val .= '</div>';
								$line_txt_val .= '<div style="display:none" class="partial_loading">';							
									$line_txt_val .= '<img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif">';							
								$line_txt_val .= '</div>';	
							}
						$line_txt_val .= '</td>';

						$line_txt[] = '<tr id="'. $id_user .'">' . $line_txt_val . '</tr>';
						
						// print_r($line_txt);
					} // fin foreach
					return $line_txt;
				}// fin multi resultst
				else
				{
					// un seul resultat
					// print_r($result->GetSubscriberForFilterResult ->ArrayOfArrayOfString->ArrayOfString);
						$i = 0;
						$id_user = 0;
						$email_user = '';
						$abo_user = '';
						$desabo_user = '';
						$status_user = 0;
						$line_txt_val = '';
						$line_txt_val_temp_1 = '';
						$line_txt_val_temp_2 = '';
						$line_txt_val_temp_3 = '';
						$line_txt_val_temp_4 = '';
						// une ligne par champ
						// print_r($result->GetSubscriberForFilterResult ->ArrayOfArrayOfString->ArrayOfString);
						$liner = $result->GetSubscriberForFilterResult ->ArrayOfArrayOfString->ArrayOfString;
						
							// pour chaque ligne on boucle sur chaque champ D_SUBS
							// on doit faire : 4,0,1,2,3
							
							
								
									$id_user = $liner[0]->string[1];
									
									$line_txt_val_temp_1 = '<td>' . $liner[1]->string[1].'</td>';									
								
									$line_txt_val_temp_2 .= '<td>';
									if(strlen($liner[2]->string[1])>2){
										 $line_txt_val_temp_2 .= transFromISOToDate($liner[2]->string[1],$vars['CMFR__api_date_lang']);
									}
									$line_txt_val_temp_2 .= '</td>';								
								
									$line_txt_val_temp_3 .= '<td>';
									if(strlen($liner[3]->string[1])>2){
										 $line_txt_val_temp_3 .= transFromISOToDate($liner[3]->string[1],$vars['CMFR__api_date_lang']);
									}
									$line_txt_val_temp_3 .= '</td>';
															
									$line_txt_val_temp_4 .= '<td>';
									if($liner[4]->string[1] == 0){
										$line_txt_val_temp_4 .=  '<img src="../wp-content/plugins/cheetahmail/img/_icon_subscribers.png" />';
									}else if($liner[4]->string[1] >=1 && $liner[4]->string[1]<=2){
										$line_txt_val_temp_4 .=  '<img src="../wp-content/plugins/cheetahmail/img/_icon_unsubscribers.png" />';
									}
									else if($liner[4]->string[1] == 9){
										$line_txt_val_temp_4 .=  '<img src="../wp-content/plugins/cheetahmail/img/_icon_spam.png" />';
									}else{
										$line_txt_val_temp_4 .=  '<img src="../wp-content/plugins/cheetahmail/img/_icon_npai.png" />';
									}	
									
									$line_txt_val_temp_4 .= '</td>';
									$status_user = $liner[4]->string[1];
								

								
							
							// on consolide la ligne avec les infos dans l'ordre : 
							$line_txt_val = $line_txt_val_temp_4 . $line_txt_val_temp_1 . $line_txt_val_temp_2 . $line_txt_val_temp_3;
							// echo $line_txt_val;
							// partie boutons action
							$line_txt_val .= '<td>';
								if($status_user <2)
								{
									$line_txt_val .= '<div class="actions_switcher"> </div>';
									$line_txt_val .= '<div style="display: none;" id="'.$id_user.'" class="partial_buttons">';
									if($status_user == 0)
									{
										$line_txt_val .= '<span id="update" class="action_subscribers update">'.$this -> oResources->rsc_table_action_update.'</span>';
										$line_txt_val .= '<span id="unsubscribe" class="action_subscribers unsubscribe">'.$this -> oResources->rsc_table_action_unsubscribe.'</span>';
									}
									else if($status_user == 1)
									{
										$line_txt_val .= '<span id="update" class="action_subscribers update">'.$this -> oResources->rsc_table_action_update.'</span>';
										$line_txt_val .= '<span id="subscribe" class="action_subscribers subscribe">'.$this -> oResources->rsc_table_action_forcesubscribe.'</span>';
										$line_txt_val .= '<span id="delete" class="action_subscribers delete">'.$this -> oResources->rsc_table_action_delete.'</span>';
									}
									$line_txt_val .= '</div>';
									$line_txt_val .= '<div style="display:none" class="partial_loading">';							
										$line_txt_val .= '<img src="../wp-content/plugins/cheetahmail/img/mini_loader.gif">';							
									$line_txt_val .= '</div>';	
								}
							$line_txt_val .= '</td>';

							$line_txt[] = '<tr id="'. $id_user .'">' . $line_txt_val . '</tr>';	
						// var_dump($line_txt);
						return $line_txt;
					}
				
				
			}
			else
			{
				// pas de resultat
				return 0;
			}
		} catch (SoapFault $e) {return $e;}				
	}
    

	
	
	
		
	public function listDoubleTracking($selected = 0)
	{
		try{
			$result = $this->_bodymanager->GetListWebAnalytics();
		}catch(Exception $e){
			return 0;
			break;
		}
		
		$list = '';
		// $list = '<option value="0">-----</option>';
		
		if(count($result->GetListWebAnalyticsResult->WebAnalyticDetails)>1){
			
			foreach( $result->GetListWebAnalyticsResult->WebAnalyticDetails as $row )
			{
				// print_r ($row);
				if( $selected > 0 && $row->IdWA == $selected)
				{
					$list .= '<option selected="selected" value="'.$row->IdWA.'">'.$row->Libelle.'</option>';
				}
				else
				{
					$list .= '<option value="'.$row->IdWA.'">'.$row->Libelle.'</option>';
				}
			}
			
		}else if(!empty($result->GetListWebAnalyticsResult->WebAnalyticDetails)){
			$list .= '<option value="'.$result->GetListWebAnalyticsResult->WebAnalyticDetails->IdWA.'">'.$result->GetListWebAnalyticsResult->WebAnalyticDetails->Libelle.'</option>';
		}else{
		
		}
		return($list);
	}

	
	
	
	
	
	

	
/*
******************************************************************
GESTION DES DOMAINES ENVOIS / CONFIGS
******************************************************************
*/
	
		
	// function pour installation premier domaine our les configs envoi
    public function GetFirstDomain()
    {
        try{
            $result = $this->_configs->ListDomain(); 
			if(count($result -> ListDomainResult -> Domain)>1){
				// plusieurs domaines
				foreach ($result -> ListDomainResult -> Domain as $dom) {
					return $dom -> idDomain . '|' . $dom  -> DomainName;
					break;
				} 
			}else{
				// un seul domaine
				return $result -> ListDomainResult ->Domain -> idDomain . '|' . $result -> ListDomainResult ->Domain  -> DomainName;
				break;
			}
        } catch (SoapFault $e)
        {
            return("-1");
        }
    }
	
	// function pour installation premier domaine pour les configs envoi
    public function setTheDomain($idconf,$iddomain)
    {
        try{
			$this->_configs -> SetDomain(array('idConf' =>$idconf,'idDomain'=>$iddomain));
			return true;
        } catch (SoapFault $e)
        {
            return false;
        }
    }	
	
	public function listDomain($selected = 0)
	{
		try{
			$result = $this->_configs->ListDomain();
		}catch(Exception $e){
			return 0;
			break;
		}
		
		if(count($result->ListDomainResult->Domain)>1){
			$list = '';
			foreach( $result->ListDomainResult->Domain as $row )
			{
				// print_r ($row);
				if( $selected > 0 && $row->idDomain == $selected)
				{
					$list .= '<option selected="selected" value="'.$row->idDomain.'">'.$row->DomainName.'</option>';
				}
				else
				{
					$list .= '<option value="'.$row->idDomain.'">'.$row->DomainName.'</option>';
				}
			}
			
		}else{
			$list .= '<option value="'.$result->ListDomainResult->Domain->idDomain.'">'.$result->ListDomainResult->Domain->DomainName.'</option>';
		}
		return($list);
	}

	// methode pour récupérer les infos d'une conf à  partir de son IDCONFIG
	public function GetConfigById($idConfig)
	{
		 try{
			$array_conf = array('idConf' => $idConfig);
			$my_conf = $this->_configs -> GetConfig($array_conf)->GetConfigResult;
			return $my_conf;
		 } 
		 catch (SoapFault $e){return -1;}
	}
	
	// methode pour créer les configs à  l'installation du module	
    public function AddConfig($idmlist,$name,$mailfrom, $mailfromaddress,$mailnpai,$mailreply,$mailto,$maildep,$html_unsubs,$txt_unsubs,$html_footer,$txt_footer,$html_header,$txt_header,$dkim)
    {
        try{
			// tableau des params de la conf
			$array_conf = array( 
			'_config' => array(		
			   'idMlist'=> $idmlist,
				'idConf' => -1,
				'name' =>$name,
				'mailFrom' => $mailfrom,
				'mailFromAddr' => $mailfromaddress,
				'mailRetNpai' => $mailnpai,
				'mailReply' => $mailreply,
				'mailTo' => $mailto,
				'mailDep' => $maildep,
				'htmlUnsubs' => $html_unsubs,
				'txtUnsubs' => $txt_unsubs,
				'htmlFooter' => $html_footer,
				'txtFooter' => $txt_footer,
				'htmlHeader' => $html_header,
				'txtHeader' => $txt_header,
				'customHeaderKey' => '',
				'customHeaderValue' => '',
				'verpSend' =>'ReturnPath_Seulement',
				'charset' => 'UTF_8',
				'miroir' => true,
				'isDkim' => true		
				)
			);
			$my_conf = $this->_configs -> CreateConfig($array_conf)->CreateConfigResult;
			// on associe le domaine à la conf
			$this->_configs -> SetDomain(array('idConf' =>$my_conf,'idDomain'=>$dkim));
			return  $my_conf;
        } 
		catch (SoapFault $e){return -1;}
    }
	
	// methode pour mettre à  jour une configuration d'envoi	
    public function UpdateConfigs($idmlist,$idconfig,$name,$mailfrom, $mailfromaddress,$mailnpai,$mailreply,$html_unsubs,$txt_unsubs,$html_footer,$txt_footer,$html_header,$txt_header)
    {
        try{
			// tableau des params de la conf
			$array_conf = array( 
			'_config' => array(		
				'idMlist'=> $idmlist,
				'idConf' => $idconfig,
				'name' =>$name,
				'mailFrom' => $mailfrom,
				'mailFromAddr' => $mailfromaddress,
				'mailRetNpai' => $mailnpai,
				'mailReply' => $mailreply,
				'mailTo' => MAILTO,
				'mailDep' => MAILDEP,
				'htmlUnsubs' => $html_unsubs,
				'txtUnsubs' => $txt_unsubs,
				'htmlFooter' => $html_footer,
				'txtFooter' => $txt_footer,
				'htmlHeader' => $html_header,
				'txtHeader' => $txt_header,
				'customHeaderKey' => '',
				'customHeaderValue' => '',
				'verpSend' =>'ReturnPath_Seulement',
				'charset' => 'UTF_8',
				'miroir' => true,
				'isDkim' => true		
				)
			);
			
			
			$my_conf = $this->_configs -> UpdateConfig($array_conf)->UpdateConfigResult;
			// var_dump($array_conf);
			// print_r($my_conf);
			return  $my_conf;
        } 
		catch (SoapFault $e){return $e;}
    }
	
	// methode pour mettre à  jour une configuration d'envoi	
    public function DeleteConfig($idconf)
    {
        try{
			// tableau des params de la conf
			$array_conf = array('_IdConf' =>$idconf);
			$my_conf = $this->_configs -> Delete($array_conf)->DeleteResult;
			return  0;
        } 
		catch (SoapFault $e){return -1;}
    }

   
 
/*
******************************************************************
GESTION DES TEMPLATES
******************************************************************
*/	
	
	// function pour récupérer les templates
	public function GetTemplatesList()
	{
		$vars = getVarWithoutSession();
		$tpl_array = array();
		try{
		$list_template = $this->_chronocontact -> GetTemplates() -> GetTemplatesResult;
		// var_dump($list_template);
		}catch(Exception $e){		
			$list_template = array();
		}
		if(count($list_template -> ArrayOfString)>1 && !empty($list_template)){
			foreach($list_template -> ArrayOfString  as $line){				
				if( $line->string[0] != 'Id' && strpos($line->string[1],'|||||')){
					// print_r($line->string[0]. ' - ' . $line->string[1].'<br />');
					// $line_details = $this->_chronocontact ->GetTemplate(array('templateId'=>$line->string[0]));					
					$tpl_array[$line->string[0]]['id'] = $line->string[0];
					
						$good_temp = explode('|||||',$line->string[1]);
						
						
						$good_name = $good_temp[0];
						$good_date = $good_temp[1];
					
					$tpl_array[$line->string[0]]['name'] = $good_name;
					$tpl_array[$line->string[0]]['date'] = transFromISOToDate($good_date,$vars['CMFR__api_date_lang']);
				}
				
			}
		}else{
			$tpl_array[0]['id'] = 0;
			$tpl_array[0]['name'] = $this -> oResources->rsc_tpl_notpl;
			$tpl_array[0]['name'] = $this -> oResources->rsc_tpl_nodate;
		}
		// print_r($tpl_array);
		return $tpl_array;
		
	}
		
	// function pour ajouter un template (objet / html / txt)
	public function AddTemplate($name,$html,$txt,$subject)
	{
		$array_template = array( 
			'TemplateName' => $name,
			'SourceHTML' => $html,
			'SourceTXT' => $txt,
			'subject' => $subject
		);
		$my_template = $this->_chronocontact -> CreateTemplate($array_template)->CreateTemplateResult;
		return $my_template;
	}
	
	// function pour supprimer un template
	public function DeleteTemplateById($idtemplate)
	{
		$array_template = array('templateId' => $idtemplate);
		$delete_template = $this->_chronocontact -> DeleteTemplate($array_template)->DeleteTemplateResult;
		return 0;
	}

	// function pour récupérer les templates
	public function GetTemplateById($idtemplate)
	{
		$tpl_array = array();
		$Mytemplate = $this->_chronocontact -> GetTemplate(array('templateId'=>$idtemplate)) -> GetTemplateResult;
		// var_dump($Mytemplate);
	
		if( !empty($Mytemplate)){
			$tpl_array['id'] = $Mytemplate->id;
			if(strpos($Mytemplate->name,'|||||')){
			
				$good_temp = explode('|||||',$Mytemplate->name);
				$good_name = $good_temp[0];
				$good_date = $good_temp[1];
				
			}else{
				$good_name = $Mytemplate->name;
				$good_date = '';			
			}
			
			$tpl_array['name'] = $good_name;
			$tpl_array['date'] = $good_date;
			$tpl_array['subject'] = $Mytemplate->subject;
			$tpl_array['html'] = $Mytemplate->htmlSource;
			$tpl_array['txt'] = $Mytemplate->txtSource;
		}
		
		// print_r($tpl_array);
		return $tpl_array;
		
	}
	
		
/*
******************************************************************
GESTION DES CAMPAGNES
******************************************************************
*/
	
    public function GetCampaignsList($state = 'EN_PREPARATION')
    {
		if($state == "EN_PREPARATION"){
			try 
			{
				$Params_campaigns_list = array('_status' => $state);
				$result_campaigns_list = $this ->_campaigns-> List($Params_campaigns_list)  -> ListResult;
				
				return $result_campaigns_list;
			} 
			catch(Exception $e)
			{
				return -2;
			}
		}else if($state == "TERMINE"){
			try 
			{
				$Params_campaigns_list = array('_status' => $state);
				$result_campaigns_list = $this ->_stats-> List($Params_campaigns_list)  -> ListResult;
				return $result_campaigns_list;
			} 
			catch(Exception $e)
			{
				return -2;
			}
		}
    }

	
	public function getIdCampByChrono($idchrono)
	{
		try 
		{
			return $this -> _chronocontact -> getChrono(array('IdChrono'=>$idchrono))->getChronoResult -> IdCamp;
		}
		catch(Exception $e)
		{
			return -2;
		}
	}

	
    public function AddCamp($name,$target,$config,$wishdate="0001-01-01T00:00:00",$subject,$format,$html,$txt,$ea)
    {
        try{
			// tableau des params de la camp
			$array_camp = 
			array( 
			'campaignParams' => array(
				'isPrivate'=> 0,
				'description' => $name,
				'filters' =>array(
					'behavioralFilterId' => 0,
					'fieldFilterId' => $target,
					'sqlQueryFilterId' => 0,
					'targetId' => 0
				),
				'folderId' => 0
			),
			'sentParams' => array(
				'speed' => 'SPEED_MAX',
				'configId' => $config,
				'wishdate' => $wishdate,
				'percentil' => 100,
				'randomize' => true,
				'mailboxMonitor' => 0,
				'emailAnalytics' => $ea
			),
			'messageParams' => array(
				'subject' => $subject,
				'format' => $format,
				'priority' => 3,
				'htmlSrc' => $html,
				'txtSrc' => $txt
			)
			);
			
			
			$my_camp = $this->_campaigns -> Create($array_camp)->CreateResult;
			return  $my_camp;
        } 
		catch (SoapFault $e){return $e;}
    }


    public function UpdateCampaignById($idcamp,$name,$subject,$html,$txt,$target)
    {		
        try 
        {
			$Params_campaigns_up = array('campaignId' =>$idcamp,'parameters' => array('isPrivate' => false,'description'=>$name,'filters'=>array('behavioralFilterId'=>0,'fieldFilterId'=>$target,'sqlQueryFilterId'=>0,'targetId'=>0),'folderId'=>0));
			$result_campaigns_up = $this ->_campaigns-> UpdateCampaign($Params_campaigns_up) -> UpdateCampaignResult;
			
			$Params_campaigns_contents_up = array('campaignId' =>$idcamp,'parameters' => array('subject' => $subject,'format'=>3,'priority'=>3,'htmlSrc'=>$html,'txtSrc'=>$txt));
			$result_campaigns_contents_up = $this ->_campaigns-> UpdateMessage($Params_campaigns_contents_up) -> UpdateMessageResult;
			
			return $result_campaigns_contents_up;
        } 
        catch(Exception $e)
        {
            return -2;
        }
    }
	
	
    public function DeleteCampaign($idcamp)
    {
		
        try 
        {
			$Params_campaigns_del = array('campaignId' =>$idcamp);
			$result_campaigns_del = $this ->_campaigns-> Delete($Params_campaigns_del)  -> DeleteResult;
			return $result_campaigns_del;
        } 
        catch(Exception $e)
        {
            return -2;
        }
    }
			
    public function GetCampaignByd($idcamp)
    {
		
        try 
        {
			$Params_campaigns_get = array('campaignId' =>$idcamp);
			$result_campaigns_get = $this ->_campaigns-> GetCampaign($Params_campaigns_get)  -> GetCampaignResult;
			return $result_campaigns_get;
        } 
        catch(Exception $e)
        {
            return -2;
        }
    }
			
    public function GetContentsCampaign($idcamp)
    {
        try 
        {
			$Params_campaigns = array('campaignId' => $idcamp);
			$result_campaigns = $this ->_campaigns-> GetSourceOfCampaign($Params_campaigns)  -> GetSourceOfCampaignResult;
			return $result_campaigns->SourceDetails;
        } 
        catch(Exception $e)
        {
            return -2;
        }
    }
	
    public function SendCampaignBAT($idcamp)
    {
        try 
        {
			$tab_config_values = getVarWithoutSession();
			$Params_campaign_duple = array('campaignId' => $idcamp);
			$result_campaign_duple = $this ->_campaigns-> DuplicateCampaign ($Params_campaign_duple) -> DuplicateCampaignResult;
			
			$table_datas_campaign = $this->GetCampaignByd($result_campaign_duple);
			$table_contents_campaign = $this->GetContentsCampaign($result_campaign_duple);
			
			$desc = $table_datas_campaign ->description;
			$subject = $table_contents_campaign->subject;
			$html = $table_contents_campaign->htmlsrc;
			$txt = $table_contents_campaign->txtsrc;
			$format = $table_contents_campaign->format;
			
			$description_temp = $this -> getVar('CMFR__prefix_bat');
			$description_temp = $description_temp['CMFR__prefix_bat'];

			$fieldFilterId_temp = $this -> getVar('CMFR__idquery_bat');
			$fieldFilterId_temp = $fieldFilterId_temp['CMFR__idquery_bat'];
			
			$Params_campaign = array('campaignId' => $result_campaign_duple,'parameters' => array('isPrivate' => false,'description'=> $description_temp.$desc,'filters'=>array('behavioralFilterId'=>0,'fieldFilterId' => $fieldFilterId_temp,'sqlQueryFilterId' => 0, 'targetId' => 0),'folderId' => 0 ) );
			$update_params_campaign = $this -> _campaigns ->UpdateCampaign ($Params_campaign) -> UpdateCampaignResult;
			// return $update_params_campaign;
			
			$subjet_temp = $this -> getVar('CMFR__prefix_bat');
			$subjet_temp = $subjet_temp['CMFR__prefix_bat'];

			
			
			// DOUBLE TRACKING OU PAS

			if($tab_config_values['CMFR__api_doubletracking_enabled'] && $tab_config_values['CMFR__api_doubletracking_id'] > 0){
				// mode double tracking
				$html = $this -> TrackHTMLLinks($html,true,1,$tab_config_values['CMFR__api_doubletracking_id'],$result_campaign_duple);
				$txt = $this -> TrackHTMLLinks($txt,false,1,$tab_config_values['CMFR__api_doubletracking_id'],$result_campaign_duple);
			}else{
				// mode simple tracking
				$html = $this -> TrackHTMLLinks($html,true);
				$txt = $this -> TrackHTMLLinks($txt,false);
			}
		
		
			$Params_sent = array('campaignId' => $result_campaign_duple,'parameters' => array('subject' => $subjet_temp . $subject,'format'=>$format,'priority'=>3,'htmlSrc' => $html,'txtSrc' => $txt) );
			$update_params_sent = $this -> _campaigns ->UpdateMessage($Params_sent) -> UpdateMessageResult;
			// return $update_params_sent;	
			
			$this->_campaigns->Start(array('campaignId'=>$result_campaign_duple));
			return 0;
        } 
        catch(Exception $e)
        {
            print_r($e);
        }
    }

    public function SendCampaign($idcamp,$date)
    {
        try 
        {
			$tab_config_values = getVarWithoutSession();
			$table_contents_campaign = $this->GetContentsCampaign($idcamp);
			$subject = $table_contents_campaign->subject;
			$html = $table_contents_campaign->htmlsrc;
			$txt = $table_contents_campaign->txtsrc;
			$format = $table_contents_campaign->format;

			// DOUBLE TRACKING OU PAS

			if($tab_config_values['CMFR__api_doubletracking_enabled'] && $tab_config_values['CMFR__api_doubletracking_id'] > 0)
			{
				// mode double tracking
				$html = $this->TrackHTMLLinks($html,true,1,$tab_config_values['CMFR__api_doubletracking_id'],$idcamp);
				$txt = $this->TrackHTMLLinks($txt,false,1,$tab_config_values['CMFR__api_doubletracking_id'],$idcamp);
			}
			else
			{
				// mode simple tracking
				$html = $this->TrackHTMLLinks($html,true);
				$txt = $this->TrackHTMLLinks($txt,false);
			}

			
			// on tracke
			$Params_sent = array('campaignId' => $idcamp,'parameters' => array('subject' =>$subject,'format'=>$format,'priority'=>3,'htmlSrc' => $html,'txtSrc' => $txt ) );
			$update_params_sent = $this -> _campaigns ->UpdateMessage($Params_sent) -> UpdateMessageResult;		
			// on update la wishdate			
			$wishdate = $date;		
			// on envoie
			$Params_campaigns = array('campaignId' => $idcamp,'idSent'=>1,'parameters'=>array('speed'=>'SPEED_MAX','configId'=>$tab_config_values['idconf_campaign'],'wishdate'=>$wishdate,'percentil'=>100,'randomize'=>true,'mailboxMonitor'=>false,'emailAnalytics'=>$tab_config_values['ea']));
			$result_campaigns = $this ->_campaigns-> UpdateSent($Params_campaigns)  -> UpdateSentResult;
			return 0;

        } 
        catch(Exception $e)
        {
            return -2;
        }
    }

	public function GetStats($idcamp)
    {
        try 
        {
			$Params_stats = array('CampaignId' => $idcamp);
			$result_stats = $this ->_stats-> Get($Params_stats)  -> GetResult;
			return $result_stats;
        } 
        catch(Exception $e)
        {
            return $e;
        }
    }

	
/*
******************************************************************
GESTION DES CHRONOS
******************************************************************
*/
		
	// function pour mettre à  jour les templates (objet / html / txt) des subs / unsubs sur le serveur
	public function AddChronocontact($name,$idcamp,$idtemplate)
	{
		$array_chronocontact = array( 
			'ChronoName' => $name,
			'IdCampagne' => $idcamp,
			'IdTemplate' => $idtemplate
		);
		$my_chronocontact = $this ->_chronocontact -> CreateChrono($array_chronocontact)->CreateChronoResult;
		return $my_chronocontact;
	}	
		
	// function pour supprimer un chrono
	public function DeleteChronocontact($idchrono)
	{
		$array_chronocontact = array('IdChrono' => $idchrono);
		$my_chronocontact = $this ->_chronocontact -> DeleteChrono($array_chronocontact)->CreateChronoResult;
		return 0;
	}	
	

	
	
/*
******************************************************************
GESTION DE  LA PREVIEW
******************************************************************
*/

	// function pour supprimer un chrono
	public function getPreviewContent($content)
	{
		// print_r($content);
		$vars = getVarWithoutSession();
		// on recupere le user s'il existe
		$email_preview = $this -> getVar('CMFR__email_preview');
		$email_preview = $email_preview['CMFR__email_preview'];
		if($content!='' && strlen($content)>0){			
			if($email_preview!=''){					
				$data_user_id = $this -> FindByEmail($email_preview);			
				$data_user = $this -> GetUnitUserById($data_user_id);
				// $user_data_initial = preg_match_all("/$U\((.*?)\)/is",$content,$titre);
				$test = preg_match_all("/$U\((.*?)\)/is",$content,$titre);
				
				$result_user_to_replace = $titre[1];
			
				//print_r($result_user_to_replace );
				foreach($result_user_to_replace as $fld_u)
				{				
					$txt_u = '';	
					
					if(strpos($fld_u,',') !== false){
						$fld_u_tab = explode(',',$fld_u);
						if($fld_u_tab[0] >= 0)
						{
							// id du fld à  ramener
							$txt_u = $data_user['FLD' . $fld_u_tab[0]];
							
							if(isset($fld_u_tab[2]))
							{									
								// on a un formattage
								$format = str_replace('&quot;','"',$fld_u_tab[2]);
								
								if($format == '"Lowercase"'){
									$txt_u = strtolower($txt_u);
								}else if($format == '"Uppercase"'){
									$txt_u = strtoupper($txt_u);
								}else if($format == '"First"'){
									$txt_u = ucfirst($txt_u);
								}else if($format == '"Allfirst"'){
									$txt_u = ucwords($txt_u);
								}								
							}							
						}
						if(isset($fld_u_tab[1]))
						{
							// on a une valeur par défaut
							$default_value_one = str_replace('&quot;','',$fld_u_tab[1]);
							$default_value = str_replace('"','',$default_value_one);
							if($txt_u == ''){
								$txt_u = $default_value;
							}						
						}
						$content = str_replace('$U('.$fld_u.')',$txt_u,$content);
					}else{
						if($fld_u > 0){
							$txt_u = $data_user['FLD' . $fld_u];
						}else{
							// $txt_u = 'pas cool<br >';
						}
						$content = str_replace('$U('.$fld_u.')',$txt_u,$content);
					}	
					
					
					
					
				}
				$content = str_replace('$C(10)',transFromISOToDate(date("Y-m-d").'T'.date('H:i:d'),$vars['CMFR__api_date_lang'],1),$content);
				return $content;
			}else{
				return $content;
			}
		}else{
			return '';
		}
		
	}	
	



// FIN CLASSE
  
}


?>