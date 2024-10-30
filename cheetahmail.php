<?php
/*
 Plugin Name: Experian CheetahMail - Wordpress Plugin
 Plugin URI: http://www.experian-cheetahmail.fr/
 Description: Experian CheetahMail : Wordpress Plugin
 Author: Experian CheetahMail
 Version: 1.1
 Author URI: http://www.experian-cheetahmail.fr/
 License: GPLv2 or later
*/

// Definition des globales du plugin
define( "EXPERIAN_PLUGIN_FILE_PATH", __FILE__);
define( "EXPERIAN_PLUGIN_URL", dirname( __FILE__ ) ); 
define( "CURRENT_VERSION", '1.1' ); 
define( "EXPERIAN_SLUG", 'EXPERIAN_SLUG' );
define('DOMAIN_PLUGIN', 'cheetahmail');

// contrôle de l'appel de la page depuis l'admin
if( !defined( "ABSPATH" ) ) die( _e("Aren't you supposed to come here via WP-Admin?") );


// class API
include(dirname( __FILE__ ) . '/ajax/api.php');


// vues des pages de l'admin
include(dirname( __FILE__ ) . '/views.php');
// WIDGETS
include(dirname( __FILE__ ) . '/widgets/unsubscriptions.php');
include(dirname( __FILE__ ) . '/widgets/subscriptions.php');
// CRON
include(dirname( __FILE__ ) . '/crons/newsletter_send_cron.php');



// CLASSE EXPERIAN DU PLUGIN GLOBAL
class cheetahmail 
{

	function  __construct() 
	{
		admin_init_styles_scripts();
		if( is_admin() )
		{   	
			add_action('admin_menu', 'admin_menu');		
			// ON TRADUIT LE PLUGIN
			load_plugin_textdomain('cheetahmail', false, basename( dirname( __FILE__ ) ) . '/languages' );
			Autotrad();
			
		}	
	}   		
}
 

// on instancie la classe experian
 
if (class_exists('cheetahmail')) 
{
   $cheetahmail = new cheetahmail();
}



/*  GESTION DESINSTALLATION PLUGIN */

function my_uninstall_hook()
{ 
	// we delete all cheetahmail plugin options, all cheetahmail informations are not deleted
	delete_option("CMFR__is_configured");			
	delete_option("CMFR__api_idmlist");
	delete_option("CMFR__api_login");
	delete_option("CMFR__api_password");
	delete_option("CMFR__api_date_lang");
	delete_option("CMFR__api_doubletracking_enabled");
	delete_option("CMFR__api_doubletracking_id");
	delete_option("CMFR__api_dkim_id");
	delete_option("CMFR__api_dkim_label");
	delete_option("CMFR__prefix_email");
	delete_option("CMFR__prefix_bat");
	delete_option("CMFR__prefix_nl");
	delete_option("CMFR__prefix_target");
	delete_option("CMFR__idconf_subs");
	delete_option("CMFR__idconf_unsubs");
	delete_option("CMFR__idconf_nl");
	delete_option("CMFR__idconf_campaign");						
	delete_option("CMFR__idchrono_subs");			
	delete_option("CMFR__idchrono_unsubs");
	delete_option("CMFR__idcamp_subs");			
	delete_option("CMFR__idcamp_unsubs");		
	delete_option("CMFR__idquery_nl");
	delete_option("CMFR__idquery_bat");
	delete_option("CMFR__idquery_campaign");
	delete_option("CMFR__idquery_unsubs");			
	delete_option("CMFR__idquery_bat_emails");			
	delete_option("CMFR__email_preview");	
	delete_option("CMFR__shortcodes_style");				
	delete_option("CMFR__id_tracked_ems_link");			
	delete_option("CMFR__id_tracked_wp_link");
	delete_option("CMFR__url_desabo");
	delete_option("CMFR__url_abo");			
	delete_option("CMFR__ea");			
	delete_option("CMFR__nl_date_last_sent");		
	delete_option("CMFR__nl_activation");			
	delete_option("CMFR__nl_type_elements");
	delete_option("CMFR__nl_order_elements");
	delete_option("CMFR__nl_nb_elements");
	delete_option("CMFR__nl_frequency");			
	delete_option("CMFR__nl_image");
	delete_option("CMFR__nl_link");		
	delete_option("CMFR__nl_coment");		
	delete_option("CMFR__nl_title_fontface");				
	delete_option("CMFR__nl_title_color");
	delete_option("CMFR__nl_title_size");
	delete_option("CMFR__nl_title_underline");
	delete_option("CMFR__nl_title_bold");			
	delete_option("CMFR__nl_title_italic");
	delete_option("CMFR__nl_title_uppercase");
	delete_option("CMFR__nl_content_fontface");					
	delete_option("CMFR__nl_content_color");
	delete_option("CMFR__nl_content_size");
	delete_option("CMFR__nl_content_underline");
	delete_option("CMFR__nl_content_bold");				
	delete_option("CMFR__nl_content_italic");
	delete_option("CMFR__nl_content_uppercase");
	delete_option("CMFR__nl_link_defaulttext");					
	delete_option("CMFR__nl_link_fontface");				
	delete_option("CMFR__nl_link_color");
	delete_option("CMFR__nl_link_size");
	delete_option("CMFR__nl_link_underline");
	delete_option("CMFR__nl_link_bold");			
	delete_option("CMFR__nl_link_italic");
	delete_option("CMFR__nl_link_uppercase");
	delete_option("CMFR__nl_coment_fontface");				
	delete_option("CMFR__nl_coment_color");
	delete_option("CMFR__nl_coment_size");
	delete_option("CMFR__nl_coment_underline");
	delete_option("CMFR__nl_coment_bold");			
	delete_option("CMFR__nl_coment_italic");
	delete_option("CMFR__nl_coment_uppercase");	
	delete_option("CMFR__unsubs_text_top");
	delete_option("CMFR__unsubs_text_link");		
	delete_option("CMFR__unsubs_text_bottom");			
	delete_option('CMFR__subject_subs');
	delete_option('CMFR__html_subs');
	delete_option('CMFR__txt_subs');
	delete_option('CMFR__subject_unsubs');
	delete_option('CMFR__html_unsubs');
	delete_option('CMFR__txt_unsubs');
	delete_option('CMFR__subject_nl');
	delete_option('CMFR__wrapper_top_nl');
	delete_option('CMFR__wrapper_bottom_nl');
	delete_option('CMFR__subject_email');
	delete_option('CMFR__html_email');
	delete_option('CMFR__txt_email');				
	delete_option('CMFR__db_mapping');		
	delete_option('CMFR__RESSOURCES');		
}

if ( function_exists('register_uninstall_hook') ) register_uninstall_hook(__FILE__, 'my_uninstall_hook');





// function pour connaitre une valeur

function getVar($var_to_search = '')
{
	global $wpdb;
	if($var_to_search != ''){
		$alloptions[$var_to_search] = get_option($var_to_search);
	}else{
		$alloptions_db = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE '%CMFR__%' " );
		$alloptions = array();
		foreach ( (array) $alloptions_db as $o ) {
			$alloptions[$o->option_name] = $o->option_value;
		}
	}
	return $alloptions;
}	
	
// FUNCTION DE GESTION DES JS ET STYLES
	
function admin_init_styles_scripts()
{			
	if(is_admin())
	{
		wp_enqueue_script("thickbox");
		wp_enqueue_style("thickbox");

		wp_enqueue_script("editor");
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script("jquery-ui-datepicker", plugins_url( "cheetahmail/js/jquery.ui.datepicker.min.js", dirname( __FILE__ ) ),array('jquery', 'jquery-ui-core') );	    	
		wp_enqueue_style("jquery.ui.theme", plugins_url( "cheetahmail/css/datepicker/jquery.ui.datepicker.css", dirname( __FILE__ ) ) );

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		
		wp_enqueue_style("cheetahmail-styles", plugins_url( "cheetahmail/css/cheetahmail.css", dirname( __FILE__ ) ) );
		wp_enqueue_style("cheetahmail-styles-global", plugins_url( "cheetahmail/css/global_ecm.css", dirname( __FILE__ ) ) );
		
		wp_enqueue_script("cheetahmail-tipsy", plugins_url( "cheetahmail/js/jquery.tipsy.js", dirname( __FILE__ ) ) );	    	
		wp_enqueue_script("cheetahmail-js", plugins_url( "cheetahmail/js/js.js", dirname( __FILE__ ) ) );
		wp_enqueue_script("cheetahmail-cke", plugins_url( "cheetahmail/js/ckeditor/ckeditor.js", dirname( __FILE__ ) ) );
		wp_enqueue_script("cheetahmail-cke-adapter-jquery", plugins_url( "cheetahmail/js/ckeditor/adapters/jquery.js", dirname( __FILE__ ) ) );
		
		wp_enqueue_script("cheetahmail-highcharts", plugins_url( "cheetahmail/js/highcharts/highcharts.js", dirname( __FILE__ ) ) );
	}
	else
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script("jquery-ui-datepicker", plugins_url( "cheetahmail/js/jquery.ui.datepicker.min.js", dirname( __FILE__ ) ),array('jquery', 'jquery-ui-core') );	    	
		wp_enqueue_style("jquery.ui.theme", plugins_url( "cheetahmail/css/datepicker/jquery.ui.datepicker.css", dirname( __FILE__ ) ) );
		wp_enqueue_script("cheetahmail-js", plugins_url( "cheetahmail/shortcodes/form.js", dirname( __FILE__ ) ) );
		if(get_option( 'CMFR__shortcodes_style','1' ) == 1){
		wp_enqueue_style("cheetahmail-styles", plugins_url( "cheetahmail/shortcodes/form.css", dirname( __FILE__ ) ) );
		}
	}
}
	
// FUNCTION ECRITURE DU MENU
function admin_menu()
{		
	// on teste si le module est deja installé
	$is_installed = get_option( 'CMFR__is_configured', '1' );	
	
	if($is_installed == 0){ 
		// installation OK
		$test_install = true;
	}else{
		// installation NOK
		$test_install = false;
	}		
	
	// PLUGIN EST DEJA INSTALLE 	
	if($test_install)
	{
		// ONGLET DU MENU GENERAL
		$page_title_adm = "CheetahMail";
		$menu_title_adm = "CheetahMail";
		$capability_adm = "administrator";
		$function_adm = "installation_plugin_view" ;
		$menu_slug_adm = 'cheetahmail';
		$icon_url_adm = plugins_url( "/cheetahmail/img/plugin_icon.png", dirname( __FILE__ ) );
		add_menu_page( $page_title_adm, $menu_title_adm , $capability_adm, $menu_slug_adm, $function_adm, $icon_url_adm );		
		// settings
		$page_title_settings = __('menu_settings', DOMAIN_PLUGIN);
		$menu_title_settings = __('menu_settings', DOMAIN_PLUGIN);
		$capability_settings = "administrator";
		$function_settings = "update_plugin_view" ;
		$menu_slug_settings = 'settings';
		$icon_url_settings = plugins_url( "/cheetahmail/img/plugin_icon.png", dirname( __FILE__ ) );
		add_submenu_page( $menu_slug_adm, $page_title_settings, $menu_title_settings , $capability_settings, $menu_slug_settings, $function_settings, $icon_url_settings );		
		// subscription
		$page_title_subs = __('menu_subscriptions', DOMAIN_PLUGIN);
		$menu_title_subs =  __('menu_subscriptions', DOMAIN_PLUGIN);
		$capability_subs = "administrator";
		$function_subs = "subscriptions_plugin_view" ;
		$menu_slug_subs = 'subscriptions';
		$icon_url_subs = plugins_url( "/cheetahmail/img/plugin_icon.png", dirname( __FILE__ ) );
		add_submenu_page( $menu_slug_adm, $page_title_subs, $menu_title_subs , $capability_subs , $menu_slug_subs , $function_subs , $icon_url_subs );	
		// newsletters
		$page_title_nl = __('menu_newsletters', DOMAIN_PLUGIN);
		$menu_title_nl = __('menu_newsletters', DOMAIN_PLUGIN);
		$capability_nl = "administrator";
		$function_nl = "newsletters_plugin_view" ;
		$menu_slug_nl = 'newsletters';
		$icon_url_nl = plugins_url( "/cheetahmail/img/plugin_icon.png", dirname( __FILE__ ) );
		add_submenu_page( $menu_slug_adm, $page_title_nl, $menu_title_nl , $capability_nl , $menu_slug_nl , $function_nl , $icon_url_nl );			
		// emailings : configuration
		$page_title_emails_c = __('menu_emailing', DOMAIN_PLUGIN);
		$menu_title_emails_c = __('menu_emailing', DOMAIN_PLUGIN);
		$capability_emails_c = "administrator";
		$function_emails_c = "emailings_plugin_view" ;
		$menu_slug_emails_c = 'emails';
		$icon_url_emails_c = plugins_url( "/cheetahmail/img/plugin_icon.png", dirname( __FILE__ ) );
		add_submenu_page( $menu_slug_adm, $page_title_emails_c, $menu_title_emails_c , $capability_emails_c , $menu_slug_emails_c , $function_emails_c , $icon_url_emails_c );	
		
		// templates
		$page_title_templates_c = __('menu_templates', DOMAIN_PLUGIN);
		$menu_title_templates_c = __('menu_templates', DOMAIN_PLUGIN);
		$capability_templates_c = "administrator";
		$function_templates_c = "templates_plugin_view" ;
		$menu_slug_templates_c = 'templates';
		$icon_url_templates_c = plugins_url( "/cheetahmail/img/plugin_icon.png", dirname( __FILE__ ) );
		add_submenu_page( $menu_slug_adm, $page_title_templates_c, $menu_title_templates_c , $capability_templates_c , $menu_slug_templates_c , $function_templates_c , $icon_url_templates_c );							
				
		
		// Targets
		$page_title_targets_c = __('menu_targets', DOMAIN_PLUGIN);
		$menu_title_targets_c = __('menu_targets', DOMAIN_PLUGIN);
		$capability_targets_c = "administrator";
		$function_targets_c = "targets_plugin_view" ;
		$menu_slug_targets_c = 'targets';
		$icon_url_targets_c = plugins_url( "/cheetahmail/img/plugin_icon.png", dirname( __FILE__ ) );
		add_submenu_page( $menu_slug_adm, $page_title_targets_c, $menu_title_targets_c , $capability_targets_c , $menu_slug_targets_c , $function_targets_c , $icon_url_targets_c );							
		
		// ON RETIRE CHEETAHMAIL EN TROP
		remove_submenu_page('cheetahmail','cheetahmail');
	}	
	else
	{
		// settings 
		$page_title_adm = "CheetahMail";
		$menu_title_adm = "CheetahMail";
		$capability_adm = "administrator";
		$function_adm = "installation_plugin_view" ;
		$menu_slug_adm = 'cheetahmail';
		$icon_url_adm = plugins_url( "/cheetahmail/img/plugin_icon.png", dirname( __FILE__ ) );
		add_menu_page( $page_title_adm, $menu_title_adm , $capability_adm, $menu_slug_adm, $function_adm, $icon_url_adm );
	}
}

/* gestion shortcodes */

function FullSubscriptionForm()
{
	$MyEMST = new emst(get_option('CMFR__api_idmlist'),get_option('CMFR__api_login'),get_option('CMFR__api_password'));
	$def_bdd =  $MyEMST -> getStructureLiveForForm();
	$jHtml = include(dirname( __FILE__ ) .'/fn/js.php');
	load_textdomain('cheetahmail', basename( dirname( __FILE__ ) ) . '/languages' );
	return($jHtml  . $def_bdd);
}

add_shortcode('CheetahMailSubscriptionForm', 'FullSubscriptionForm');

function FullUpdateForm()
{
	if(isset($_GET['email'])){
	$MyEMST = new emst(get_option('CMFR__api_idmlist'),get_option('CMFR__api_login'),get_option('CMFR__api_password'));
	$def_bdd =  $MyEMST -> getStructureLiveForUpdateForm();
	$jHtml = include(dirname( __FILE__ ) .'/fn/js.php');
	return($jHtml  . $def_bdd);
	}else{
	return '';
	}
}

add_shortcode('CheetahMailUpdateForm', 'FullUpdateForm');

/* gestion traduction live ajax */

function Autotrad()
{

			// on génère la variable de configuration des traductions pour ajax
			$json = '';
			$json .= '{';
				
				// FN.FN			
				$json .= '"rsc_fn_defaultdomain":"'.__('rsc_fn_defaultdomain',DOMAIN_PLUGIN).'",';
				$json .= '"rsc_fn_mailfrom":"'.__('rsc_fn_mailfrom',DOMAIN_PLUGIN).'",';
				$json .= '"rsc_fn_mailto":"'.__('rsc_fn_mailto',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_btn_update":"'.__('rsc_btn_update',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_btn_add":"'.__('rsc_btn_add',DOMAIN_PLUGIN).'",';			
				
				// table 
				$json .= '"rsc_table_id":"'.__('rsc_table_id',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_date":"'.__('rsc_table_date',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_type":"'.__('rsc_table_type',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_size":"'.__('rsc_table_size',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_state":"'.__('rsc_table_state',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_name":"'.__('rsc_table_name',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_displaytext":"'.__('rsc_table_displaytext',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_operator":"'.__('rsc_table_operator',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_values":"'.__('rsc_table_values',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_actions":"'.__('rsc_table_actions',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_format":"'.__('rsc_table_format',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_sync":"'.__('rsc_table_sync',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_setformat":"'.__('rsc_table_setformat',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_setdefault":"'.__('rsc_table_setdefault',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_editable":"'.__('rsc_table_editable',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_table_displayed":"'.__('rsc_table_displayed',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_table_email":"'.__('rsc_table_email',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_subsdate":"'.__('rsc_table_subsdate',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_unsubsdate":"'.__('rsc_table_unsubsdate',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_recipients":"'.__('rsc_table_recipients',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_filtered":"'.__('rsc_table_filtered',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_bounces":"'.__('rsc_table_bounces',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_hardbounces":"'.__('rsc_table_hardbounces',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_softbounces":"'.__('rsc_table_softbounces',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_table_delivered":"'.__('rsc_table_delivered',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_unsubs":"'.__('rsc_table_unsubs',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_openers":"'.__('rsc_table_openers',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_openings":"'.__('rsc_table_openings',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_table_clickers":"'.__('rsc_table_clickers',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_clicks":"'.__('rsc_table_clicks',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_user_email":"'.__('rsc_table_user_email',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_user_login":"'.__('rsc_table_user_login',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_table_user_nicename":"'.__('rsc_table_user_nicename',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_user_displayname":"'.__('rsc_table_user_displayname',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_user_subsdate":"'.__('rsc_table_user_subsdate',DOMAIN_PLUGIN).'",';	
			
				// table inside		
				$json .= '"rsc_table_format_none":"'.__('rsc_table_format_none',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_format_lowercase":"'.__('rsc_table_format_lowercase',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_format_uppercase":"'.__('rsc_table_format_uppercase',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_format_first":"'.__('rsc_table_format_first',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_table_format_allfirst":"'.__('rsc_table_format_allfirst',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_format_zerofill":"'.__('rsc_table_format_zerofill',DOMAIN_PLUGIN).'",';				
				
				
				
				$json .= '"rsc_table_toppage":"'.__('rsc_table_toppage',DOMAIN_PLUGIN).'",';
				$json .= '"rsc_table_fixed_value":"'.__('rsc_table_fixed_value',DOMAIN_PLUGIN).'",';
				
				
				
				$json .= '"rsc_table_toppage_none":"'.__('rsc_table_toppage_none',DOMAIN_PLUGIN).'",';
				$json .= '"rsc_table_toppage_toppage":"'.__('rsc_table_toppage_toppage',DOMAIN_PLUGIN).'",';
				$json .= '"rsc_table_toppage_subs":"'.__('rsc_table_toppage_subs',DOMAIN_PLUGIN).'",';
				$json .= '"rsc_table_toppage_unsubs":"'.__('rsc_table_toppage_unsubs',DOMAIN_PLUGIN).'",';
				
				
				
				// table action list		
				$json .= '"rsc_table_action_edit":"'.__('rsc_table_action_edit',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_action_preview":"'.__('rsc_table_action_preview',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_action_send":"'.__('rsc_table_action_send',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_action_sendtest":"'.__('rsc_table_action_sendtest',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_table_action_duplicate":"'.__('rsc_table_action_duplicate',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_action_delete":"'.__('rsc_table_action_delete',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_table_action_viewusers":"'.__('rsc_table_action_viewusers',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_action_number":"'.__('rsc_table_action_number',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_action_seedetails":"'.__('rsc_table_action_seedetails',DOMAIN_PLUGIN).'",';				

				$json .= '"rsc_table_action_update":"'.__('action_table_update',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_action_unsubscribe":"'.__('action_table_unsubscribe',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_action_forcesubscribe":"'.__('action_table_forcesubscribe',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_table_action_delete":"'.__('action_table_delete',DOMAIN_PLUGIN).'",';				


				// abo/desabo
				$json .= '"rsc_email_sendbat":"'.__('rsc_email_sendbat',DOMAIN_PLUGIN).'",';	
				
				
				// others contents
				$json .= '"rsc_table_update_user_title":"'.__('rsc_table_update_user_title',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_table_update_no_result":"'.__('rsc_table_update_no_result',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_recipients":"'.__('rsc_content_recipients',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_name":"'.__('rsc_content_name',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_content_criterias":"'.__('rsc_content_criterias',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_content_results":"'.__('rsc_content_results',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_content_search":"'.__('rsc_content_search',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_content_subs_sentence_left":"'.__('rsc_content_subs_sentence_left',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_subs_sentence_right":"'.__('rsc_content_subs_sentence_right',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_unsubs_sentence_left":"'.__('rsc_content_unsubs_sentence_left',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_unsubs_sentence_right":"'.__('rsc_content_unsubs_sentence_right',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_search_sentence":"'.__('rsc_content_search_sentence',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_no_user_to_sync":"'.__('rsc_content_no_user_to_sync',DOMAIN_PLUGIN).'",';	

				// nl settings
				$json .= '"rsc_content_nl_activation":"'.__('rsc_content_nl_activation',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_target":"'.__('rsc_content_nl_target',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_type":"'.__('rsc_content_nl_type',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_content_nl_tooltip_type":"'.__('rsc_content_nl_tooltip_type',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_content_nl_type_post":"'.__('rsc_content_nl_type_post',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_content_nl_type_page":"'.__('rsc_content_nl_type_page',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_content_nl_elt":"'.__('rsc_content_nl_elt',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_elt_limit":"'.__('rsc_content_nl_elt_limit',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_tooltip_elt_limit":"'.__('rsc_content_nl_tooltip_elt_limit',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_elt_limit_all":"'.__('rsc_content_nl_elt_limit_all',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_elt_orderby":"'.__('rsc_content_nl_elt_orderby',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_tooltip_elt_orderby":"'.__('rsc_content_nl_tooltip_elt_orderby',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_elt_frequency":"'.__('rsc_content_nl_elt_frequency',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_tooltip_elt_frequency":"'.__('rsc_content_nl_tooltip_elt_frequency',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_elt_frequency_daily":"'.__('rsc_content_nl_elt_frequency_daily',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_elt_frequency_weekly":"'.__('rsc_content_nl_elt_frequency_weekly',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_elt_frequency_monthly":"'.__('rsc_content_nl_elt_frequency_monthly',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_addimage":"'.__('rsc_content_nl_addimage',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_addcoment":"'.__('rsc_content_nl_addcoment',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_addlink":"'.__('rsc_content_nl_addlink',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_title":"'.__('rsc_content_nl_style_title',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_content":"'.__('rsc_content_nl_style_content',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_coments":"'.__('rsc_content_nl_style_coments',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_link":"'.__('rsc_content_nl_style_link',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_link_text":"'.__('rsc_content_nl_style_link_text',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_color":"'.__('rsc_content_nl_style_color',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_fontface":"'.__('rsc_content_nl_style_fontface',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_size":"'.__('rsc_content_nl_style_size',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_bold":"'.__('rsc_content_nl_style_bold',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_underline":"'.__('rsc_content_nl_style_underline',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_italic":"'.__('rsc_content_nl_style_italic',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_style_uppercase":"'.__('rsc_content_nl_style_uppercase',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_last_nl":"'.__('rsc_content_nl_last_nl',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_send":"'.__('rsc_content_nl_send',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_content_nl_sendbat":"'.__('rsc_content_nl_sendbat',DOMAIN_PLUGIN).'",';				

				// templates
				$json .= '"rsc_tpl_name":"'.__('rsc_tpl_name',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_tpl_subject":"'.__('rsc_tpl_subject',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_tpl_html":"'.__('rsc_standard_html',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_tpl_txt":"'.__('rsc_standard_txt',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_tpl_notpl":"'.__('rsc_tpl_notpl',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_tpl_nodate":"'.__('rsc_tpl_nodate',DOMAIN_PLUGIN).'",';	
				
				$json .= '"rsc_tpl_camp_choosetpl":"'.__('camp_rsc_choosetpl',DOMAIN_PLUGIN).'",';	
			
				// campagnes
				$json .= '"rsc_camp_params":"'.__('rsc_camp_params',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_name":"'.__('rsc_camp_name',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_camp_subject":"'.__('rsc_camp_subject',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_html":"'.__('rsc_camp_html',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_txt":"'.__('rsc_camp_txt',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_target":"'.__('rsc_camp_target',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_camp_uploadtpl":"'.__('rsc_camp_uploadtpl',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_choosetpl":"'.__('rsc_camp_choosetpl',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_loadtpl":"'.__('rsc_camp_loadtpl',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_envelopp":"'.__('rsc_camp_envelopp',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_recipients":"'.__('rsc_camp_recipients',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_bounces":"'.__('rsc_camp_bounces',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_performance":"'.__('rsc_camp_performance',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_sentdate":"'.__('rsc_camp_sentdate',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_camp_nostats":"'.__('rsc_camp_nostats',DOMAIN_PLUGIN).'",';	

				// configs
				$json .= '"rsc_config_from":"'.__('rsc_config_from',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_tooltip_from":"'.__('rsc_config_tooltip_from',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_config_reply":"'.__('rsc_config_reply',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_subject":"'.__('rsc_config_subject',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_tooltip_subject":"'.__('rsc_config_tooltip_subject',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_emailfrom":"'.__('rsc_config_emailfrom',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_config_tooltip_emailfrom":"'.__('rsc_config_tooltip_emailfrom',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_npai":"'.__('rsc_config_npai',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_tooltip_npai":"'.__('rsc_config_tooltip_npai',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_emailreply":"'.__('rsc_config_emailreply',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_tooltip_emailreply":"'.__('rsc_config_tooltip_emailreply',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_date_sentence":"'.__('rsc_config_date_sentence',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_htmltotxt":"'.__('rsc_config_htmltotxt',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_html_header":"'.__('rsc_config_html_header',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_txt_header":"'.__('rsc_config_txt_header',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_wrapper_top":"'.__('rsc_config_wrapper_top',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_wrapper_bottom":"'.__('rsc_config_wrapper_bottom',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_body_html":"'.__('rsc_config_body_html',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_config_body_txt":"'.__('rsc_config_body_txt',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_html_footer":"'.__('rsc_config_html_footer',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_config_txt_footer":"'.__('rsc_config_txt_footer',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_html_unsubs":"'.__('rsc_config_html_unsubs',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_config_txt_unsubs":"'.__('rsc_config_txt_unsubs',DOMAIN_PLUGIN).'",';	


				// targets operators
				$json .= '"rsc_operator_none":"'.__('operator_none',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_operator_equal":"'.__('operator_equal',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_operator_different":"'.__('operator_different',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_operator_filled":"'.__('operator_filled',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_operator_notfilled":"'.__('operator_notfilled',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_operator_ago":"'.__('operator_ago',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_submenu_body":"'.__('rsc_submenu_body',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_operator_in":"'.__('operator_in',DOMAIN_PLUGIN).'",';	
			
				// target 
				$json .= '"rsc_table_content_name":"'.__('rsc_table_content_name',DOMAIN_PLUGIN).'",';	
			


				
				// sub menus
				$json .= '"rsc_submenu_subscribers":"'.__('rsc_submenu_subscribers',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_submenu_unsubscribers":"'.__('rsc_submenu_unsubscribers',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_submenu_search":"'.__('rsc_submenu_search',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_submenu_envelop":"'.__('rsc_submenu_envelop',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_submenu_header":"'.__('rsc_submenu_header',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_submenu_wrapper":"'.__('rsc_submenu_wrapper',DOMAIN_PLUGIN).'",';				
				$json .= '"rsc_submenu_body":"'.__('rsc_submenu_body',DOMAIN_PLUGIN).'",';			
				$json .= '"rsc_submenu_footer":"'.__('rsc_submenu_footer',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_submenu_unsubs":"'.__('rsc_submenu_unsubs',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_submenu_preview":"'.__('rsc_submenu_preview',DOMAIN_PLUGIN).'",';	 
						
				// shortcodes
				
				$json .= '"rsc_user_form_added":"'.__('rsc_js_user_form_added',DOMAIN_PLUGIN).'",';	 // X added / subscribed
				$json .= '"rsc_user_form_updated":"'.__('rsc_js_user_form_updated',DOMAIN_PLUGIN).'",';	 // X updated
				$json .= '"rsc_user_form_error":"'.__('rsc_js_user_form_error',DOMAIN_PLUGIN).'",';	 // error occured
						
				// Plugins
				$json .= '"rsc_plugin_error":"'.__('rsc_plugin_error',DOMAIN_PLUGIN).'",';	 
				
				//subs
				$json .= '"rsc_plugin_subs_button":"'.__('rsc_plugin_subs_button',DOMAIN_PLUGIN).'",';	 
				$json .= '"rsc_plugin_subs_error":"'.__('rsc_plugin_subs_msg_error',DOMAIN_PLUGIN).'",';	 
				$json .= '"rsc_plugin_subs_success":"'.__('rsc_plugin_subs_msg_success',DOMAIN_PLUGIN).'",';	 
				$json .= '"rsc_plugin_subs_empty":"'.__('rsc_plugin_subs_fld',DOMAIN_PLUGIN).'",';	
				
				//unsubs
				$json .= '"rsc_plugin_unsubs_button":"'.__('rsc_plugin_unsubs_button',DOMAIN_PLUGIN).'",';	 
				$json .= '"rsc_plugin_unsubs_error":"'.__('rsc_plugin_unsubs_msg_error',DOMAIN_PLUGIN).'",';	
				$json .= '"rsc_plugin_unsubs_success":"'.__('rsc_plugin_unsubs_msg_success',DOMAIN_PLUGIN).'",';
				$json .= '"rsc_plugin_unsubs_empty":"'.__('rsc_plugin_unsubs_fld',DOMAIN_PLUGIN).'"';
				
			$json .= '}';
			add_option('CMFR__RESSOURCES',$json,'no');
			update_option('CMFR__RESSOURCES',$json,'no');
}


?>