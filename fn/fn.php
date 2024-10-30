<?php

// VARIABLES DE DEMARRAGE POUR FAIRE INSTALLATION :: CONFIGURATIONS

	// PREFIXE TARGET
	define('PREFIX_TARGET','WPTARGET_');
	
	define('EMAIL_PREVIEW','');
	define('DEFAULT_DOMAIN','mydomain.com');							//DEFAULT NOT EXISTING DOMAIN	
	define('DEFAULT_BAT_EMAIL','unknown@' . DEFAULT_DOMAIN);			//DEFAULT NOT EXISTING DOMAIN	
	
	define('MAILFROM','My from');										//MAILFROM	
	define('MAILFROMADDRESS','email_from@');							//MAILFROMADDRESS	
	define('MAILNPAI','email_npai@'.DEFAULT_DOMAIN);					//MAILNPAI	
	define('MAILREPLY','email_reply@'.DEFAULT_DOMAIN);					//MAILREPLY	
	define('MAILTO','Recipient');										//MAILTO	
	define('MAILDEP','RET');											//MAILDEP
	define('HTML_DEFAULT','<p>My HTML</p>');							//HTML_UNSUBS	
	define('TXT_DEFAULT','My Text');									//TXT_UNSUBS	
	define('HTML_FOOTER','<p>My Footer Html</p>');						//HTML_FOOTER	
	define('TXT_FOOTER','My Footer Text');								//TXT_FOOTER
	define('HTML_HEADER','<p>My Header Html</p>');						//HTML_HEADER	
	define('TXT_HEADER','My Header Text');								//TXT_HEADER
	
	// HOOK SPECIAL NL (WRAPPER INSTEAD OF BODY)
	define('WRAPPER_NL_TOP','<table><tr><td>');							//WRAPPER_NL_TOP
	define('WRAPPER_NL_BOTTOM','</td></tr></table>');					//WRAPPER_NL_BOTTOM
	
	
	
	// TEMPLATES
	define('TEMPLATE_NAME','Template Name');							//DEFAULT TEMPLATE NAME
	define('TEMPLATE_SUBJECT','Template Subject');						//DEFAULT TEMPLATE SUBJECT
	define('TEMPLATE_HTML','Template html body');						//DEFAULT TEMPLATE HTML
	define('TEMPLATE_TXT','Template txt body');		

	//DEFAULT TEMPLATE TXT
	define('TEMPLATE_NAMING','NEVER_DELETE_TEMPLATE');					//TEMPLATE SUBS UNSUBS NAMING

	// DEFAULT
	define('CAMP_DEFAULT_SUBJECT','My Subject');
	// SUBSCRIPTION
	define('CONFIG_SUBS_NAME','WP_SUBSCRIPTION_CONFIG');
	define('CONFIG_SUBS_ID',0);
	define('CAMP_SUBS_NAME','WP_SUBSCRIPTION_CAMP');
	
	// UNSUBSCRIPTION
	define('CONFIG_UNSUBS_NAME','WP_UNSUBSCRIPTION_CONFIG');
	define('CONFIG_UNSUBS_ID',0);
	define('CAMP_UNSUBS_NAME','WP_UNSUBSCRIPTION_CAMP');
	define('FILTER_UNSUBS_NAME','WP_UNSUBSCRIPTION_TARGET');
	
	// NEWSLETTER
	define('CONFIG_NL_NAME','WP_NEWSLETTER_CONFIG');
	define('CONFIG_NL_ID',0);
	define('PREFIX_NL','WPNL_');
	define('FILTER_NL_NAME',PREFIX_TARGET . 'NL_TARGET');

	
	// EMAILING
	define('CONFIG_EMAILING_NAME','WP_EMAILING_CONFIG');
	define('CONFIG_EMAILING_ID',0);
	define('PREFIX_EMAILING','WordPress_campaign_');
	define('FILTER_EMAILING_NAME',PREFIX_TARGET . 'EMAILING_TARGET');
	
	// BAT
	define('FILTER_BAT_NAME','WP_BAT_TARGET');
	define('FILTER_BAT_ID',0);
	define('PREFIX_BAT','(TEST) ');
	
	// LIENS DE TRACKINGS EMS / WP
	define('ID_TRACKED_LINK_EMS',2);
	define('ID_TRACKED_LINK_WP','-1');
	define('TRACKED_LINK_URL','\$H(2)');
	define('ID_TRACKED_LINK_URL_SUBSCRIBE',0);

	// ZONE UNSUBS
	define('LINK_UNSUBS_UP','<p><font face="Arial" size="1">Please click ');
	define('LINK_UNSUBS_TEXT','here');
	define('LINK_UNSUBS_DOWN',' to unsubscribe</font></p>');

	
	// NEWSLETTERS CONFIG
	define('NL_DATE_LAST_SENT',date('Y-m-d').'T'.date('H:i:s'));
	define('IDCAMP_NL','0');
	define('NL_ACTIVATE',0);
	define('NL_TYPE_ELEMENTS',0);
	define('NL_ORDER_ELEMENTS','DESC');
	define('NL_NB_ELEMENTS',5);
	define('NL_FREQUENCY',0);

	define('NL_IMAGE',0);
	define('NL_LINK',0);
	define('NL_COMENT',0);
	
	// NEWSLETTERS STYLES
	define('NL_TITLE_FONT',0);
	define('NL_TITLE_COLOR',"#000000");
	define('NL_TITLE_SIZE',"14");
	define('NL_TITLE_UNDERLINE',1);
	define('NL_TITLE_BOLD',1);
	define('NL_TITLE_ITALIC',0);
	define('NL_TITLE_UPPERCASE',0);
		
	define('NL_CONTENT_FONT',0);
	define('NL_CONTENT_COLOR','#666666');
	define('NL_CONTENT_SIZE',"12");
	define('NL_CONTENT_UNDERLINE',0);
	define('NL_CONTENT_BOLD',0);
	define('NL_CONTENT_ITALIC',0);
	define('NL_CONTENT_UPPERCASE',0);
		
	define('NL_LINK_DEFAULTTEXT','Read more >');	
	define('NL_LINK_FONT',0);
	define('NL_LINK_COLOR','#21759B');
	define('NL_LINK_SIZE',"12");
	define('NL_LINK_UNDERLINE',1);
	define('NL_LINK_BOLD',0);
	define('NL_LINK_ITALIC',1);
	define('NL_LINK_UPPERCASE',0);
		
	define('NL_COMENT_FONT',0);
	define('NL_COMENT_COLOR','#21759B');
	define('NL_COMENT_SIZE',"12");
	define('NL_COMENT_UNDERLINE',1);
	define('NL_COMENT_BOLD',0);
	define('NL_COMENT_ITALIC',1);
	define('NL_COMENT_UPPERCASE',0);

	
?>