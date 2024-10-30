<?php
if( !class_exists( "Subscriptions" ) )
{	
    class Subscriptions extends WP_Widget
    {		
    	var $experian_ws;		
    	function Subscriptions()
	    {
            // Widget configuration: Classe/Description
             $widget_ops = array( "classname"=>"subscriptions_widget", "description"=>__( "rsc_plugin_subs_description", DOMAIN_PLUGIN ));
            // Widget configuration: Taille/Id
            $control_ops = array( "width"=>200, "height"=>250, "id_base"=>"subscriptions_widget" );
            // Creation du widget.
            $this->WP_Widget( "subscriptions_widget", __( "rsc_plugin_subs_name", DOMAIN_PLUGIN ), $widget_ops, $control_ops );
            // Creation du shortcode.    
            add_filter( "subscription_newsletter", "do_shortcode" );
            add_filter( "subscription_newsletter", "shortcode_unautop" );
            add_shortcode( "subscription_newsletter", array( $this, "widget_shortcode" ) );            
	    }
	    
	    // Creation du shortcode : [subscription_newsletter texte="votre message ici"] 
	    function widget_shortcode( $atts, $content = null )
	    {
	    	global $wp_widget_factory;
	    	extract( shortcode_atts( array( "texte"=>FALSE ), $atts ) );
	    	$widget_name = "Subscriptions";
	    	if( !is_a( $wp_widget_factory->widgets[ $widget_name ], "WP_Widget" ) )
	    	{
		    	$wp_class = "WP_Widget_".ucwords( strtolower( $class ) );
		    	if( !is_a( $wp_widget_factory->widgets[ $wp_class ], "WP_Widget" ) )
		    	{
		    	    $tanslated_value =  __( "%s: Widget class not found. Make sure this widget exists and the class name is correct", "widgets" );
		    		return "<p>".sprintf( $tanslated_value, "<strong>".$class."</strong>" )."</p>";
		    	}
		    	else $class = $wp_class;
	   		}
	   		ob_start();
	   		the_widget($widget_name, $atts, null );
	   		$output='';
	    	if( $texte && !isset($_POST[ "email_newsletter" ]) ) $output .= $texte;
	    	$output .= ob_get_contents();
	    	ob_end_clean();
	    	return $output;
	    }
	        
	    // Widget : affichage sur le front
	    function widget( $args, $instance )
	    {
	    	if( isset( $_POST[ "email_newsletter" ] ))
	    	{
				$tp = array();
				foreach($_POST as $var_post=>$val)
				{
					if($var_post == "email_newsletter"){
						// nothing
					}else{
						$tp[$var_post] = $val;
					}
				}
				
	    		$returnWs = $this->_sendEmailAndAddUser( strtolower($_POST[ "email_newsletter" ]),$tp);					
				$this->_buildSubscriptionForm( $args, $instance, $returnWs);
	    	}else {
				// Formulaire d'inscription a la newsletter
	    		$this->_buildSubscriptionForm( $args, $instance , $returnWs);
	    	}
	    }
	    
	    // Widget : option du widget, sortie sur le back 
	    function form( $instance )
	    {
	    	// Widget configuration: Valeurs par default ou si elles existent, les valeurs enregistrees.
	    	$defaults = array
	    	(
	    		"widget_title"=>__("rsc_plugin_subs_title",DOMAIN_PLUGIN),  
				"validation"=>__("rsc_plugin_subs_msg_success",DOMAIN_PLUGIN),
				"description"=>__("rsc_plugin_subs_fld_instruction",DOMAIN_PLUGIN)
	    	);
	    	$instance = wp_parse_args( $instance, $defaults );

			echo ' <p>';
			echo '<label for="'.$this->get_field_id( "widget_title" ).'">'. __( "rsc_plugin_subs_form_title", DOMAIN_PLUGIN ) .'</label> ';
			echo '<input id="'.$this->get_field_id( "widget_title" ).'" name="'.$this->get_field_name( "widget_title" ).'" value="'.htmlspecialchars( $instance[ "widget_title" ] ).'"  style="width:100%;" type="text" />';
			echo ' </p>';
						
			echo ' <p>';
			echo ' <label for="'. $this->get_field_id( "description" ).'">'. __( "rsc_plugin_subs_form_desc", DOMAIN_PLUGIN ) .'</label> ';
			echo '<input style="width:100%;" type="text" id="'.$this->get_field_id( "description" ).'" name="'.$this->get_field_name( "description" ).'" value="'.htmlspecialchars( $instance[ "description" ] ).'" />';
			echo ' </p>';
			
			echo ' <p>';
			echo '<label for="'.$this->get_field_id( "validation" ).'">'.__( "rsc_plugin_subs_form_validation", DOMAIN_PLUGIN ).'</label> ';
			echo '<input style="width:100%;" type="text" id="'.$this->get_field_id( "validation" ).'" name="'.$this->get_field_name( "validation" ).'" value="'.htmlspecialchars( $instance[ "validation" ] ).'" />';
			echo ' </p>';
          
	    }
	    
	    //Sauvegarde les options du widget 
	    function update( $new_instance, $old_instance )
	    {
			$instance = $old_instance;
			$instance[ "widget_title" ] = strip_tags( $new_instance[ "widget_title" ] );
		    $instance[ "description" ] = strip_tags( $new_instance[ "description" ] );
		    $instance[ "validation" ] = strip_tags( $new_instance[ "validation" ] );
		    return $instance;		    
	    }
		
		
	    // Construit le formulaire qui sera affiche sur le Front.
		private function _buildSubscriptionForm( $args=array(), $instance, $error=null )
		{		    
			extract( $args );
			$tab_config_values = getVar();
			$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);
			// Les variables de notre plugin.
			if (isset($instance[ "widget_title" ])){
				$widget_title = apply_filters( "widget_title", $instance[ "widget_title" ] );
				$description = apply_filters( "description", $instance[ "description" ] );
			}
			// Avant notre widget (Definit par les themes).
			echo $before_widget;
			// Affiche le titre entoure par la classe titre du theme en cours.
			$buffer = "";
			$buffer .= '<a name="cm_subs"></a>';
			if ( isset($widget_title) ) echo $before_title.$widget_title.$after_title;
			// Affiche le message de description que l'administrateur a rentre dans la partie administrateur
			if ( isset($description)  && ( $error != 1 || $error == null )) $buffer .= "<p> ".$description." </p>";

			$result = get_option('CMFR__db_mapping');
			$return_tab = json_decode($result);
			$def_bdd = $return_tab;
		
			
		
			$form = "";
			
			$form .= '<div class="subscription-widget">';
				if($error == 1){
					$form .= '<div id="message success"><p><span style="color:#3f9803">'.$oResources->rsc_plugin_subs_success.'</span></p></div>';	
				}else if ($error != null)
				{
					$form .= '<div id="message error"><p><span style="color:#ac0000">'.$error.'</span></p></div>';
				}
				if($error != 1 || $error == null){
					$form .= '<form action="#cm_subs" method="post">';
						
						$form .= '<input type="text" name="email_newsletter" value="'.$_GET['email'].'" /> ';
						// AJOUTER LES CHAMPS DE TOPPAGE 
						foreach($def_bdd as $fld)
						{	
							
							if($fld->toppage == 1){
								// input type  hidden
								$form .= '<input type="hidden" id="'.$fld->id.'" name="'.$fld->id.'" value="'.$fld->fixed_value.'" />';					
							}
						}
						// $form .= '<br />';
						$form .= '<input style="margin-top:7px;" type="submit" value="'.$oResources->rsc_plugin_subs_button.'" />';
					$form .= '</form>';
				}

			$form .= '</div>';
			if( strpos( $buffer, "{subscription_form}" ) !== false )
			{
			    $buffer = str_replace( "{subscription_form}", $form, $buffer );
			}
			else $buffer .= $form;
			echo $buffer;
			echo $after_widget;
        } 
		 
		
		
		//  Ajoute l'email dans la liste des users ou reactive l'inscription a la newsletterEt envoi du mail de confirmation d'inscription a la newsletter

		private function _sendEmailAndAddUser( $email,$ar = array() )
		{

			// pour tester l'email synthaxiquement
			$test_email_synthax = preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#",$email );
			// on recup toute la config JSON
			$tab_config_values = getVar();
			$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
			
			if($test_email_synthax){
							
				$oIdlist = $tab_config_values['CMFR__api_idmlist'];
				$oLogin = $tab_config_values['CMFR__api_login'];
				$oPassword = $tab_config_values['CMFR__api_password'];
			
				$oCamp = $tab_config_values['CMFR__idcamp_subs'];
				$oChronocontact = $tab_config_values['CMFR__idchrono_subs'];
				$oHTML = $tab_config_values['CMFR__html_subs'];
				$oTXT = $tab_config_values['CMFR__txt_subs'];
				$oSubject = $tab_config_values['CMFR__subject_subs'];
								
				// on instancie notre client
				$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
				
				// on essaye d'ajouter
				$new_iduser = $MyEMST -> AddByEmail($email);
				
				if($new_iduser > 0)
				{
					// on a soit ajouté soit récupéré
					
					// on update le user (champ de toppage)
					$u = $MyEMST -> UpdateUserInfosFromBlank($new_iduser,$ar);
					// on tracke
					if($tab_config_values['CMFR__api_doubletracking_enabled'] && $tab_config_values['CMFR__api_doubletracking_id'] > 0)
					{
						// mode double tracking
						$oHTML = $MyEMST->TrackHTMLLinks($oHTML,true,1,$tab_config_values['CMFR__api_doubletracking_id'],$oCamp);
						$oTXT = $MyEMST->TrackHTMLLinks($oTXT,false,1,$tab_config_values['CMFR__api_doubletracking_id'],$oCamp);
					}
					else
					{
						// mode simple tracking
						$oHTML = $MyEMST->TrackHTMLLinks($oHTML,true);
						$oTXT = $MyEMST->TrackHTMLLinks($oTXT,false);
					}
					
					// on fait le tab de params
					$array_chrono = array('chronoId'=>$oChronocontact,'userId' => $new_iduser,'HTMLsource' =>$oHTML,'TXTsource' =>$oTXT,'subject' =>$oSubject,'attachementPath' =>'','deleteAttachementFile' =>1);					
					$new_subscription_email = $MyEMST -> _chronocontact -> SendMailHTML($array_chrono)->SendMailHTMLResult;
					return 1;	
				}else{
					// email foiré : mais abonné
					return '<span style="color:#ac0000">'.$oResources->rsc_plugin_subs_error.'</span>';				
				}			
			}else{
				// email mal formé
				return '<span style="color:#ac0000">'.$oResources->rsc_plugin_subs_empty.'</span>';
			}
		}
		
	}
}



	
			
			
			
function register_widgets_subscription()
{
	register_widget( "Subscriptions" );
}

function unregister_widgets_subscription()
{
	wp_unregister_sidebar_widget( "Subscriptions" );
	unregister_widget( "Subscriptions" );	
}

add_action( "widgets_init", "register_widgets_subscription" );
?>