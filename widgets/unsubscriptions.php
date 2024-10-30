<?php
if( !class_exists( "Unsubscriptions" ) )
{
    class Unsubscriptions extends WP_Widget
    {
    	var $experian_ws;
    	function Unsubscriptions()
	    {
	        // Widget configuration: Classe / Description
            $widget_ops = array( "classname"=>"subscriptions_widget", "description"=>__( "rsc_plugin_unsubs_description", DOMAIN_PLUGIN ) );
            // Widget configuration: Taille / Id
            $control_ops = array( "width"=>200, "height"=>250, "id_base"=>"unsubscriptions_widget" );
            // Creation du widget.
            $this->WP_Widget( "unsubscriptions_widget", __( "rsc_plugin_unsubs_name", DOMAIN_PLUGIN ), $widget_ops, $control_ops );
            // Creation du shortcode.    
           add_filter( "unsubscription_newsletter", "do_shortcode" );
           add_filter( "unsubscription_newsletter", "shortcode_unautop" );
           add_shortcode( "unsubscription_newsletter", array( $this, "widget_shortcode" ) );            
	    }
	    
	    // Creation du shortcode : [unsubscription_newsletter texte="votre message ici"]

	    function widget_shortcode( $atts, $content=null )
	    {
	    	global $wp_widget_factory;
	    	extract( shortcode_atts( array ( "texte"=>FALSE ), $atts) );
	    	$widget_name = "Unsubscriptions";
	    	if( !is_a( $wp_widget_factory->widgets[ $widget_name ], "WP_Widget" ) )
	    	{
		    	$wp_class = "WP_Widget_".ucwords( strtolower( $class ) );
		    	if( !is_a( $wp_widget_factory->widgets[ $wp_class ], "WP_Widget" ) )
		    	{
		    	    $tanslated_value =  __( "%s: Widget class not found. Make sure this widget exists and the class name is correct", "widgets" );
		    		return "<p>".sprintf( $tanslated_value,"<strong>".$class."</strong>" )."</p>";
		    	}
		    	else
		    	{
		    		$class = $wp_class;
		    	}
	   		}
	   		ob_start();
	   		the_widget($widget_name, $atts, null );
	    	$output='';
	    	if( $texte && !isset($_POST[ "delete_email_newsletter" ]) ) $output .= $texte;
	    	$output .= ob_get_contents();
	    	ob_end_clean();
	    	return $output;
	    }
	        
	
	    // Widget : affichage sur le front
	    function widget( $args, $instance )
	    {
	    	if( isset( $_POST[ "delete_email_newsletter" ] ))
	    	{
	    		$returnWs = $this->_sendEmailAndUpdateUser( strtolower($_POST[ "delete_email_newsletter" ]) );					
				$this->_buildUnsubscriptionForm( $args, $instance, $returnWs);
	    	}else {
				// Formulaire d'inscription a la newsletter
	    		$this->_buildUnsubscriptionForm( $args, $instance , $returnWs);
	    	}
	    }



		
	    
	    // Widget : option du widget, sortie sur le back 
	    function form( $instance )
	    {
	    	// Widget configuration: Valeurs par default ou si elles existent, les valeurs enregistrees.
	    		    	$defaults = array
	    	(
	    		"widget_title"=>__("rsc_plugin_unsubs_title",DOMAIN_PLUGIN),  
				"validation"=>__("rsc_plugin_unsubs_msg_success",DOMAIN_PLUGIN),
				"description"=>__("rsc_plugin_unsubs_fld_instruction",DOMAIN_PLUGIN)
	    	);
	        $instance = wp_parse_args( $instance, $defaults );
			
			
			

			echo ' <p>';
			echo '<label for="'.$this->get_field_id( "widget_title" ).'">'. __( "rsc_plugin_unsubs_form_title", DOMAIN_PLUGIN ) .'</label> ';
			echo '<input id="'.$this->get_field_id( "widget_title" ).'" name="'.$this->get_field_name( "widget_title" ).'" value="'.htmlspecialchars( $instance[ "widget_title" ] ).'"  style="width:100%;" type="text" />';
			echo ' </p>';
					



					
			echo ' <p>';
			echo ' <label for="'. $this->get_field_id( "description" ).'">'. __( "rsc_plugin_unsubs_form_desc", DOMAIN_PLUGIN ) .'</label> ';
			echo '<input style="width:100%;" type="text" id="'.$this->get_field_id( "description" ).'" name="'.$this->get_field_name( "description" ).'" value="'.htmlspecialchars( $instance[ "description" ] ).'" />';
			echo ' </p>';
			
			
			
			
			
			
			echo ' <p>';
			echo '<label for="'.$this->get_field_id( "validation" ).'">'.__( "rsc_plugin_unsubs_form_validation", DOMAIN_PLUGIN ).'</label> ';
			echo '<input style="width:100%;" type="text" id="'.$this->get_field_id( "validation" ).'" name="'.$this->get_field_name( "validation" ).'" value="'.htmlspecialchars( $instance[ "validation" ] ).'" />';
			echo ' </p>';
          


			/*
	        ?>
            <p>
                <?php $translated_value = __( "Title", "widgets" ); ?>
	    		<label
                    for="<?php echo $this->get_field_id( "widget_title" ); ?>"
                 ><?php echo $translated_value; ?> : </label>
                 <?php $translated_value = htmlspecialchars( $instance[ "widget_title" ] ); ?>
	    		<input 
	    			required
                    id="<?php echo $this->get_field_id( "widget_title" ); ?>" 
	    			name="<?php echo $this->get_field_name( "widget_title" ); ?>" 
	    			value="<?php echo $translated_value; ?>" 
	    			style="width:100%;"
	    			type="text"
                />
	    	</p>
            <p>
                <?php $translated_value = __( "Description", "widgets" ); ?>
                <label
                    for="<?php echo $this->get_field_id( "description" ); ?>"
                    ><?php echo $translated_value; ?> : </label>
                 <?php $translated_value = htmlspecialchars( $instance[ "description" ] ); ?>
                <input
                	required
					style="width:100%;"
					type="text"
                    id="<?php echo $this->get_field_id( "description" ); ?>"
                    name="<?php echo $this->get_field_name( "description" ); ?>"
                    value="<?php echo $translated_value; ?>"
                />
            </p>
             <p>
                <?php $translated_value = __( "Validation message", "widgets" ); ?>
                <label
                    for="<?php echo $this->get_field_id( "validation" ); ?>"
                ><?php echo $translated_value; ?> : </label>
                 <?php $translated_value = htmlspecialchars( $instance[ "validation" ] ); ?>
                <input
					style="width:100%;"
					type="text"
                    id="<?php echo $this->get_field_id( "validation" ); ?>"
                    name="<?php echo $this->get_field_name( "validation" ); ?>"
                    value="<?php echo $translated_value; ?>"
                />
            </p>
            <?php
			*/
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
		
	    //Construit le formulaire qui sera affiche sur le Front pour se desinscrire a la newsletter.

		private function _buildUnsubscriptionForm($args=array(), $instance, $error=null)
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
			$buffer .= '<a name="cm_unsubs"></a>';
			if ( isset($widget_title) ) echo $before_title.$widget_title.$after_title;
			// Affiche le message de description que l'administrateur a rentre dans la partie administrateur
			
			if ( isset($description) && ( $error != 1 || $error == null )) $buffer .= "<p> ".$description." </p>";
			$form = "";
			$form .= "<div class=\"unsubscription-widget\">";
				if($error == 1){
					$form .= '<div id="message success"><p><span style="color:#3f9803">'.$oResources->rsc_plugin_unsubs_success.'</span></p></div>';	
				}else if ($error != null)
				{
					$form .= '<div id="message error"><p><span style="color:#ac0000">'.$error.'</span></p></div>';
				}
				if($error != 1 || $error == null){	
					$form .= '<form action="#cm_unsubs" method="post">';
					$form .= ' <input type="text" name="delete_email_newsletter" value="'.$_GET['email'].'" />';
					
					$form .= ' <input style="margin-top:7px;" type="submit" value="'.$oResources->rsc_plugin_unsubs_button.'" />';
					$form .= '</form>';
				}
			$form .= "</div>";
			if( strpos( $buffer, "{unsubscription_form}" ) !== false ) $buffer = str_replace( "{unsubscription_form}", $form, $buffer );
			else $buffer .= $form;
			echo $buffer;
			// Apres le widget (definit par le theme).
			echo $after_widget;
		} 
		

		/*		
		// Construit le message de desinscription qui sera affiche sur le Front.
		
		private function _buildConfirmationEmail( $args=array(), $instance, $error=null )
		{
		    $buffer = "";
		    extract( $args );
		    if (isset($instance[ "widget_title" ])){
			    // Les variables de notre plugin.
				$widget_title = apply_filters( "widget_title", $instance[ "widget_title" ] );
				$description = apply_filters( "description", $instance[ "description" ] );
		    }
			// Avant notre widget (Definit par les themes).
			echo $before_widget;
			// Affiche le titre entoure par la classe titre du theme en cours.
			if ( isset($widget_title) ) echo $before_title . $widget_title . $after_title;
			if( isset( $instance[ "validation" ] ) && $instance[ "validation" ] != null )
			{
				$buffer .= "<p>".__( $instance[ "validation" ], 'widgets' )." </p>";
			}
			else
			{
			    $translated_value = __( Unsubscriptions::WIDGET_CONFIG_VALIDATION_DEFAULT, "widgets" );
				$buffer .= "<p>".$translated_value." </p>";
			}
			echo $buffer;
			// Apres le widget (definit par le theme).
			echo $after_widget;
		}
		*/
	
		
		// Desabonne l'email dans la liste des users	Et envoi du mail de confirmation de desinscription a la newsletter

		private function _sendEmailAndUpdateUser( $email )
		{
			// pour tester l'email synthaxiquement
			$test_email_synthax = preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#",$email );
			
			// on recup toute la config JSON
			$tab_config_values = getVar();
			$oResources = json_decode($tab_config_values['CMFR__RESSOURCES']);	
						
			if($test_email_synthax){
				
					
				// on recup les fichiers du template

				$oIdlist = $tab_config_values['CMFR__api_idmlist'];
				$oLogin = $tab_config_values['CMFR__api_login'];
				$oPassword = $tab_config_values['CMFR__api_password'];
			
				$oCamp = $tab_config_values['CMFR__idcamp_unsubs'];			
				$oChronocontact = $tab_config_values['CMFR__idchrono_unsubs'];
				$oHTML = $tab_config_values['CMFR__html_unsubs'];
				$oTXT = $tab_config_values['CMFR__txt_unsubs'];
				$oSubject = $tab_config_values['CMFR__subject_unsubs'];

				// on instancie notre client
				$MyEMST = new emst($oIdlist,$oLogin,$oPassword);
				// on essaye de désabonner
				$new_iduser = $MyEMST -> UpdateByEmail($email,2);
				if($new_iduser > 0){
					// on a soit ajouté soit récupéré
					
					
					// on tracke
					if($tab_config_values['CMFR__api_doubletracking_enabled'] && $tab_config_values['CMFR__api_doubletracking_id'] > 0)
					{
						// mode double tracking
						$oHTML = $MyEMST->TrackHTMLLinks(utf8_encode($oHTML,true),1,$tab_config_values['CMFR__api_doubletracking_id'],$oCamp);
						$oTXT = $MyEMST->TrackHTMLLinks(utf8_encode($oTXT),false,1,$tab_config_values['CMFR__api_doubletracking_id'],$oCamp);
					}
					else
					{
						// mode simple tracking
						$oHTML = $MyEMST->TrackHTMLLinks(utf8_encode($oHTML),true);
						$oTXT = $MyEMST->TrackHTMLLinks(utf8_encode($oTXT),false);
					}
					
					$array_chrono = array('chronoId'=>$oChronocontact,'userId' => $new_iduser,'HTMLsource' => $oHTML,'TXTsource' => $oTXT,'subject' =>$oSubject,'attachementPath' =>'','deleteAttachementFile' =>1);
					
					$new_subscription_email = $MyEMST -> _chronocontact -> SendMailHTML($array_chrono)->SendMailHTMLResult;
					return 1;	
				}else{
					// email foiré : mais désabonné
					return '<span style="color:#ac0000">'.$oResources->rsc_plugin_unsubs_error.'</span>';				
				}			
			}else{
				// email mal formé
				return '<span style="color:#ac0000">'.$oResources->rsc_plugin_unsubs_empty.'</span>';
			}		    
    	}
    }
}

function register_widgets_unsubscription()
{
	register_widget( "Unsubscriptions" );
}

function unregister_widgets_unsubscription() 
{
	wp_unregister_sidebar_widget('Unsubscriptions' );
	unregister_widget( 'Unsubscriptions' );
}

add_action( "widgets_init",'register_widgets_unsubscription');