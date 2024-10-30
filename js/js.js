/*
*******************************************************************************************
FONCTIONS COMMUNES
*******************************************************************************************
*/

	// on desffiche un layer potentiel

	jQuery('body').live('keyup, keydown', function(event) 
	{
		if (event.keyCode == '27') {
				jQuery('#layer_back, #layer_front').fadeOut('slow',function(){
				jQuery(this).remove();
				});				
				
				jQuery('.layer_back_overlay, .layer_front_overlay').fadeOut('slow',function(){
				jQuery(this).remove();
				});
		}
	}
	);		


	// function pour empêcher les échappements dans la structure de bdd
	
	jQuery('._fld_fixed_value, .fld').live('keydown focus keyup',function()
	{
		var t = jQuery(this).val();
		t = t.replace('"','');
		t = t.replace('\'','');
		jQuery(this).val(t);		
	}
	);

	
	
	
	// slider accordeon dans settings

	jQuery('.slider').live('click',function()
	{
		var oI = jQuery(this).attr('id').split('_')[1];
		if(!jQuery('#sliding_' + oI).is(':visible')){
			jQuery('.slider').removeClass('active');		
			jQuery('#slider_' + oI).addClass('active');		
			jQuery('.sliding').slideUp('fast');		
			jQuery('#sliding_' + oI).slideDown('slow');
		}
	}
	);		
		
	//gestion du switch html / txt dans la preview

	jQuery('.switcher').live('click',function()
	{
		var oI = jQuery(this).attr('id');
		jQuery('.switcher').removeClass('active');
		jQuery('.switcher[id=' + oI+']').addClass('active');
		jQuery('.switch').css('display','none');
		jQuery('.switch[id=' + oI+']').css('display','block');
	}
	);

	// gestion fermeture du layer

	jQuery('.shut').live('click',function()
	{
		var oI = jQuery(this).attr('id');
		jQuery('#layer_back,#layer_front').fadeOut('slow',function(){
			jQuery(this).remove();
		});
	}
	);

	
	jQuery(document).ready(function() 
	{
		// gestion des infobulles
		if(jQuery('.tipsyer').length>0){
			jQuery('.tipsyer').tipsy({gravity: 's',fade: true,delayIn: 100,delayOut: 100,html: true});
		}
	}
	);
	
	// gestion onglets
	jQuery('.heading_elt').live('click',function()
	{
		var oI = jQuery(this).attr('id').split('_')[1];
		jQuery(this).parent().find('.heading_elt').removeClass('active');
		jQuery(this).parent().find('#elt_' + oI).addClass('active');
		jQuery(this).parent().parent().parent().find('.toggelize').css('display','none');
		jQuery(this).parent().parent().parent().find('#referred_' + oI).css('display','block');	
	}
	);




	// gestion des sous menus
	jQuery('.sub-menu-item').live('click',function()
	{
		var oI = jQuery(this).find('a').attr('id');
		jQuery(this).parent().find('.sub-menu-item').find('a').removeClass('active');
		jQuery(this).find('a').addClass('active');
		jQuery('.container').css('display','none');
		jQuery('.form_wrapper').prepend('<div class="loading_temp"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
		
		setTimeout(function(){
			jQuery('.loading_temp').remove();
			jQuery('.c_' + oI).css('display','block');
		},500);

	}
	);	
		

	
	// function pour dire si une checbox est checkée ou pas
	function return_value_checkbox(div)
	{
		if(jQuery('#'+div+':checked').length>0){
			return 1;
		}else{
			return 0;
		}
	}
	
	
	
		
	// gestion des colorpickers
		
	function ColorPickMe(div,div_input)
	{			
		
		jQuery(div_input).wpColorPicker();


		jQuery('.colorpicker').hide();
		jQuery(div_input).live('click',function() {
			jQuery(this).parent().find('.colorpicker').fadeIn();
		});
		
		jQuery(document).mousedown(function() {
			jQuery('.colorpicker').each(function() {
				var display = jQuery(this).css('display');
				if ( display == 'block' )
					jQuery(this).fadeOut();
			});
		});
		
	}

	
	
	
	
	
	
	
	
	
	
	
	// function affichage layer envoyer / programmer
	function show_send_layer(idd,fonction)
	{
		var date_send = new Date();
		var month = date_send.getMonth();
		var month_ok = '';
		switch(month){
			case 0 : month_ok = '01'; break;
			case 1 : month_ok = '02'; break;
			case 2 : month_ok = '03'; break;
			case 3 : month_ok = '04'; break;
			case 4 : month_ok = '05'; break;
			case 5 : month_ok = '06'; break;
			case 6 : month_ok = '07'; break;
			case 7 : month_ok = '08'; break;
			case 8 : month_ok = '09'; break;
			case 9 : month_ok = '10'; break;
			case 10 : month_ok = '11'; break;
			case 11 : month_ok = '12'; break;
		}

		// var date_default = date_send.getFullYear()+'-'+month_ok+'-'+date_send.getDate()+'T'+date_send.getHours()+':'+date_send.getMinutes()+':'+date_send.getSeconds();
		var date_default = date_send.getFullYear()+'-'+month_ok+'-'+date_send.getDate();
	
	if(jQuery('.layer_front_send').length>0){
			// on ne fait rien, le layer est déjà là
		}else{
			var valoris = '';
			valoris += '<div class="layer_back_send" style="display:none"></div>';
			valoris += '<div class="layer_front_send" style="display:none" id="'+idd+'">';
				valoris += '<h4>Send Campaign</h4>';			
				valoris += '<div class="alternate_style_full">';
					// valoris += '<div style="padding:0 11%;">';
						// valoris += '<label for="date_send_campaign">Date d&rsquo;envoi : </label>';
					// valoris += '</div>';
					valoris += '<div style="padding:0 11%;">';
						valoris += '<input type="text" id="date_send_campaign" name="date_send_campaign" value="'+date_default+'" class="datepicker" />';
						
						valoris += '<select id="hour_send_campaign" name="hour_send_campaign">';
							valoris += '<option value="00">00</option>';	valoris += '<option value="01">01</option>';
							valoris += '<option value="02">02</option>';	valoris += '<option value="03">03</option>';
							valoris += '<option value="04">04</option>';	valoris += '<option value="05">05</option>';
							valoris += '<option value="06">06</option>';	valoris += '<option value="07">07</option>';
							valoris += '<option value="08">08</option>';	valoris += '<option value="09">09</option>';
							valoris += '<option value="10">10</option>';	valoris += '<option value="11">11</option>';
							valoris += '<option value="12">12</option>';	valoris += '<option value="13">13</option>';
							valoris += '<option value="14">14</option>';	valoris += '<option value="15">15</option>';
							valoris += '<option value="16">16</option>';	valoris += '<option value="17">17</option>';
							valoris += '<option value="18">18</option>';	valoris += '<option value="19">19</option>';
							valoris += '<option value="20">20</option>';	valoris += '<option value="21">21</option>';
							valoris += '<option value="22">22</option>';	valoris += '<option value="23">23</option>';
						valoris += '</select>';

						valoris += '<select id="minutes_send_campaign" name="minutes_send_campaign">';
						
							valoris += '<option value="00">00</option>';	valoris += '<option value="01">01</option>';
							valoris += '<option value="02">02</option>';	valoris += '<option value="03">03</option>';
							valoris += '<option value="04">04</option>';	valoris += '<option value="05">05</option>';
							valoris += '<option value="06">06</option>';	valoris += '<option value="07">07</option>';
							valoris += '<option value="08">08</option>';	valoris += '<option value="09">09</option>';
							
							valoris += '<option value="10">10</option>';	valoris += '<option value="11">11</option>';
							valoris += '<option value="12">12</option>';	valoris += '<option value="13">13</option>';
							valoris += '<option value="14">14</option>';	valoris += '<option value="15">15</option>';
							valoris += '<option value="16">16</option>';	valoris += '<option value="17">17</option>';
							valoris += '<option value="18">18</option>';	valoris += '<option value="19">19</option>'	
							
							valoris += '<option value="20">20</option>';	valoris += '<option value="21">21</option>';
							valoris += '<option value="22">22</option>';	valoris += '<option value="23">23</option>';
							valoris += '<option value="24">24</option>';	valoris += '<option value="25">25</option>';
							valoris += '<option value="26">26</option>';	valoris += '<option value="27">27</option>';
							valoris += '<option value="28">28</option>';	valoris += '<option value="29">29</option>';
							
							valoris += '<option value="30">30</option>';	valoris += '<option value="31">31</option>';
							valoris += '<option value="32">32</option>';	valoris += '<option value="33">33</option>';
							valoris += '<option value="34">34</option>';	valoris += '<option value="35">35</option>';
							valoris += '<option value="36">36</option>';	valoris += '<option value="37">37</option>';
							valoris += '<option value="38">38</option>';	valoris += '<option value="39">39</option>';
							
							valoris += '<option value="40">40</option>';	valoris += '<option value="41">41</option>';
							valoris += '<option value="42">42</option>';	valoris += '<option value="43">43</option>';
							valoris += '<option value="44">44</option>';	valoris += '<option value="45">45</option>';
							valoris += '<option value="46">46</option>';	valoris += '<option value="47">47</option>';
							valoris += '<option value="48">48</option>';	valoris += '<option value="49">49</option>';
						
							valoris += '<option value="50">50</option>';	valoris += '<option value="51">51</option>';
							valoris += '<option value="52">52</option>';	valoris += '<option value="53">53</option>';
							valoris += '<option value="54">54</option>';	valoris += '<option value="55">55</option>';
							valoris += '<option value="56">56</option>';	valoris += '<option value="57">57</option>';
							valoris += '<option value="58">58</option>';	valoris += '<option value="59">59</option>';
							
							valoris += '<option value="60">60</option>';
							
						valoris += '</select>';
					valoris += '</div>';
				valoris += '</div>';
				valoris += '<p>';
					valoris += '<span class="valid"><input type="button" value="cancel" class="cancel" /></span>';
					valoris += '<span class="valid"><input type="button" value="valid" class="validation" /></span>';
				valoris += '</p>';
			valoris += '</div>';			
			jQuery('body').append(valoris);
			jQuery('#date_send_campaign').datepicker({
				dateFormat : 'yy-mm-dd'
			});
			jQuery('.layer_back_send').fadeTo('slow',0.8);
			jQuery('.layer_front_send').fadeTo('slow',1.0);
		}
	}	

	// function si succès
	function success_send_layer()
	{	
		var id_campaign = jQuery('.layer_front_send').attr('id');
		var date_campaign = jQuery('#date_send_campaign').val();
		var hour_campaign = jQuery('#hour_send_campaign').val();
		var minutes_campaign = jQuery('#minutes_send_campaign').val();
		var date_ok_campaign = date_campaign + 'T'+ hour_campaign + ':'+minutes_campaign+':00';
		jQuery('.layer_front_send p').html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
			
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/send_campaign.php",
			data: { 
				type:1,
				id_campaign:id_campaign,
				wishdate:date_ok_campaign
			},
			 success: function(data){
				if(data==0){				
					_load_camps(1,'#return_table_preparing_campaigns');
					_load_camps(2,'#return_table_sent_campaigns');
					show_growl(2,rsc_camp_sheduled);
				}
				else
				{
					show_growl(3,rsc_error);					
				}
				jQuery('.layer_back_send,.layer_front_send').fadeOut('fast',function(){jQuery(this).remove();});
			}// fin success
		});	

	}
	
	jQuery('.layer_front_send .validation').live('click',function()
	{ 
		success_send_layer();
	}
	);
	
	// function desaffichage layer supprimer
	function hide_send_layer()
	{
		if(jQuery('.layer_front_send').length>0){
			jQuery('.layer_back_send, .layer_front_send').fadeOut('fast').delay(10).remove();
		}else{
			// on ne fait rien
		}
	}	
	
	jQuery('.layer_front_send .cancel').live('click',function(){ hide_send_layer(); });
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	// function affichage layer supprimer
	function show_del_layer(type,idd,fonction)
	{
		if(jQuery('.layer_front_alert').length>0){
			// on ne fait rien, le layer est déjà là
		}else{
			var valoris = '';
			valoris += '<div class="layer_back_alert" style="display:none"></div>';
			valoris += '<div class="layer_front_alert" style="display:none" id="'+idd+'">';
			if(type==1){
				valoris += '<h4>Delete template</h4>';
			}else if(type==2){
				valoris += '<h4>Delete campaign</h4>';
			}			
				valoris += '<p>';
					valoris += '<span class="valid"><input type="button" value="cancel" class="cancel" /></span>';
					valoris += '<span class="valid"><input type="button" value="valid" class="validation" title="'+fonction+'" /></span>';
				valoris += '</p>';
			valoris += '</div>';			
			jQuery('body').append(valoris);
			jQuery('.layer_back_alert').fadeTo('slow',0.8);
			jQuery('.layer_front_alert').fadeTo('slow',1.0);
		}
	}	

	// function si succès
	function success_del_layer(func,val)
	{	
		jQuery('.layer_front_alert p').html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
		if(eval(func+'('+val+')')){
			jQuery('.layer_front_alert').fadeOut('slow');
		};		
	}
	
	jQuery('.layer_front_alert .validation').live('click',function()
	{ 
		var t = jQuery(this).attr('title'); 
		var v = jQuery('.layer_front_alert').attr('id'); 		
		success_del_layer(t,v);
	}
	);
	
	// function desaffichage layer supprimer
	function hide_del_layer()
	{
		if(jQuery('.layer_front_alert').length>0){
			jQuery('.layer_back_alert, .layer_front_alert').fadeOut('fast').delay(10).remove();
		}else{
			// on ne fait rien
		}
	}	
	
	jQuery('.layer_front_alert .cancel').live('click',function(){ hide_del_layer(); });
		
	// GESTION DES HTML 2 TXT TRIGGERS
	jQuery('#generate_txt').live('click',function(){html_txt(2,'campaign_html','campaign_txt');})
	jQuery('#generate_txt_edit').live('click',function(){html_txt(2,'campaign_html','campaign_txt');});	
	jQuery('#generate_tpl_txt').live('click',function(){ html_txt(2,'ws_html_template','ws_txt_template');});	
	jQuery('#generate_tpl_txt_edit').live('click',function(){ html_txt(2,'template_html','template_txt');});		

	jQuery('#generate_txt_config_header').live('click',function(){html_txt(1,'ws_html_header','ws_txt_header');});	
	jQuery('#generate_txt_config_body').live('click',function(){ html_txt(1,'ws_html_body','ws_txt_body');});	
	jQuery('#generate_txt_config_footer').live('click',function(){ html_txt(1,'ws_html_footer','ws_txt_footer');});		
	
	function html_txt(type,div_from,div_return)
	{	
		// type : 1  : config 
		// type : 2 : camp et template
		
		if(type == 2){
			var g = jQuery('#' + div_from).val();
			var t = jQuery('#' + div_return).val();
			jQuery.ajax({
				type: "POST",
				url: "../wp-content/plugins/cheetahmail/ajax/convert_to_text.php",
				data: { html:g},
				 success: function(data){
					if(data.length >= 0){
						jQuery('#' + div_return).val(jQuery.trim(data));				
					}else{
						jQuery('#' + div_return).val(t);
					}								
				}// fin success
			});	
		}else{
			// console.log(div_from);
			// console.log(div_return);
			var g = jQuery('.load:visible').parent().parent().parent().find('.'+div_from).val();
			var t = jQuery('.load:visible').parent().parent().parent().find('#' + div_return).val();
			// console.log(g);
			// console.log(t);
			
			jQuery.ajax({
				type: "POST",
				url: "../wp-content/plugins/cheetahmail/ajax/convert_to_text.php",
				data: { html:g},
				 success: function(data){
					if(data.length >= 0){
						jQuery('.load:visible').parent().parent().parent().find('#' + div_return).val(jQuery.trim(data));
					}else{
						jQuery('.load:visible').parent().parent().parent().find('#' + div_return).val(t);
					}								
				}// fin success
			});			
		}
	}

	
/*
*******************************************************************************************
FONCTIONS GROWL
*******************************************************************************************
*/



	
	// function afficher
	function show_growl(type,msg)
	{
		if(jQuery('.growl').length>0){
			// on ne fait rien, le layer est déjà là
		}else{
			var valoris = '';
			valoris += '<div class="growl" style="display:none">';
				valoris += '<h4';
				if(type==1){
					// information
					valoris += ' class="informationning"> ' + rsc_g_information;
				}else if( type == 2){
					// success
					valoris += ' class="successing"> ' + rsc_g_success;				
				} else if( type ==3){
					// error
					valoris += ' class="alerting"> ' + rsc_g_error;
				}
				valoris += '</h4>';
				valoris += '<p>';
					valoris += msg;
				valoris += '</p>';
			valoris += '</div>';			
			jQuery('body').append(valoris);
			jQuery('.growl').slideDown(400);
			setTimeout("hide_growl()",5000);
		}
	}	

	// function desaffichage
	function hide_growl()
	{
		if(jQuery('.growl').length>0){
			jQuery('.growl').slideUp(600,function(){
				jQuery(this).remove();
			});
		}
	}	

	



	
	
	
	// affiche le layer au survol
	jQuery('.actions_switcher').live('mouseover',function()
	{		
		if(jQuery(this).parent().find('.partial_buttons:visible').length==0){
			jQuery('.partial_buttons').css('display','none');
			var pos = jQuery(this).position();
			var pos_left = pos.left - 103;
			var pos_top = pos.top + 20;
			jQuery(this).parent().find('.partial_buttons').css('left',pos_left);
			jQuery(this).parent().find('.partial_buttons').css('top',pos_top);
			jQuery(this).parent().find('.partial_buttons').slideDown('fast');			
		}
	}
	);
	
	
	// desaffiche tout au rollout
	
	jQuery('.experian_wrapper').live('hover',function()
	{
		// jQuery('.partial_buttons').css('display','none');
		jQuery('.partial_buttons').slideUp('fast');
	}
	);

	jQuery('.partial_buttons').live('mouseleave',function()
	{
		// jQuery('.partial_buttons').css('display','none');
		jQuery('.partial_buttons').slideUp('fast');
	}
	);

// recherche dans un tableau
	
	jQuery('.search_in').live('keydown focus keyup',function()
	{
		jQuery(this).val(jQuery(this).val().toLowerCase())
		var id_tbl = jQuery(this).attr('id');
		var val_search_tbl = jQuery(this).val();
		var i = 0;
		if(val_search_tbl != ""){
			jQuery.each(jQuery('#tbl'+id_tbl+' tr'),function(index,value){
				if(i > 0){
					if(jQuery(this).not(':contains("'+val_search_tbl+'")').length>0 ){
						jQuery(this).fadeOut('fast');
					}else{
						jQuery(this).fadeIn('fast');
					}					
				}
				i++;
			});
		}else{
			jQuery('#tbl'+id_tbl+' tr').fadeIn('fast');
		}
	}
	);



	
	
	
/*
*******************************************************************************************
FONCTIONS INSTALLATION DU MODULE  
FONCTION GESTION SETTINGS
*******************************************************************************************
*/

// function installation du module  

jQuery('#submit_init').live('click',function()
{

	var ws_idmlist = jQuery('#idmlist').val();
	var ws_login = jQuery('#ws_login').val();
	var ws_password = jQuery('#ws_password').val();
	
	jQuery('#submit_init').parent().fadeOut('fast');
	jQuery('#submit_init').parent().parent().append('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/cheetahmail/ajax/installation.php",
		data: { i:ws_idmlist, l:ws_login,p:ws_password},
		 success: function(data){
			jQuery('#submit_init').parent().fadeOut('fast');
			if(data == -3 || data == -2){
				// erreur params
				show_growl(3,rsc_params_error);
				jQuery('#submit_init').parent().fadeIn('fast');
			}else if(data == -1){
				// erreur WS
				show_growl(3,rsc_error);
				jQuery('#submit_init').parent().fadeIn('fast');
			}else if(data == 0){
				jQuery('#submit_init').parent().remove();
				show_growl(2,rsc_installation_done);
				setTimeout('document.location.href="admin.php?page=settings"',2000);				
			}
							
			
		}// fin success
	});
}
);






/*
GESTION DE LA REINSTALLATION
*/

jQuery('#submit_change_api_key').live('click',function()
{

	// on utilisae les données nouvellement saisies
	var ws_idmlist = jQuery('#idmlist').val();
	var ws_login = jQuery('#ws_login').val();
	var ws_password = jQuery('#ws_password').val();
	
	var valid_ws_idmlist = jQuery('#valid_idmlist').val();
	var valid_ws_login = jQuery('#valid_ws_login').val();
	var valid_ws_password = jQuery('#valid_ws_password').val();	
	
	// on va les comparer aux anciennes, si elles ne sont pas les mêmes on essaye de faire l'installation.
	if(
	ws_idmlist>0 && ws_login>4 && ws_password.length>3 && 
	ws_idmlist != valid_ws_idmlist && ws_login != valid_ws_login && ws_password != valid_ws_password 
	){
		// on peut tenter la réinstallation
		jQuery('#submit_change_api_key').parent().fadeOut('fast');
		jQuery('#submit_change_api_key').parent().parent().append('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
		
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/installation.php",
			data: { i:ws_idmlist, l:ws_login,p:ws_password},
			 success: function(data){
			 
				jQuery('#submit_change_api_key').parent().fadeOut('fast');
				
				if(data == -3 || data == -2){
					// erreur params
					show_growl(3,rsc_params_error);
					jQuery('#idmlist, #wp_login, #wp_password').attr('readonly','readonly');
					jQuery('#submit_change_api_key').parent().fadeIn('fast').attr('disabled','disabled');
				}else if(data == -1){
					// erreur WS
					show_growl(3,rsc_error);
					jQuery('#idmlist, #wp_login, #wp_password').attr('readonly','readonly');
					jQuery('#submit_change_api_key').parent().fadeIn('fast').attr('disabled','disabled');
				}else if(data == 0){
					jQuery('#submit_change_api_key').parent().remove();
					show_growl(2,rsc_installation_done);
					setTimeout('document.location.href="admin.php?page=settings"',2000);				
				}
								
				
			}// fin success
		});		
	}else{
		// erreur on ne relance pas l'installation
		show_growl(3,rsc_error);
		jQuery('#idmlist, #wp_login, #wp_password').attr('readonly','readonly');
		jQuery('#submit_change_api_key').parent().fadeIn('fast').attr('disabled','disabled');
	}
	

}
);






// function mise à jour de la page settings  

jQuery('#submit_update_settings').live('click',function()
{
	// ici on recupere les valeurs anciennes et pas les variables potentiellement modifiées sur le premier pavet
	var ws_idmlist = jQuery('#valid_idmlist').val();
	var ws_login = jQuery('#valid_ws_login').val();
	var ws_password = jQuery('#valid_ws_password').val();
	
	var ws_date_lang = jQuery('#ws_date_lang option:selected').val();	
	var ws_dkim_id = jQuery('#ws_domain option:selected').val();	
	var ws_dkim_label = jQuery('#ws_domain option:selected').text();

	var ws_prefix_nl = jQuery('#prefix_nl').val();	
	var ws_prefix_email = jQuery('#prefix_email').val();	
	var ws_prefix_bat = jQuery('#prefix_bat').val();	
	var ws_prefix_target = jQuery('#prefix_target').val();	
	var ws_batquery_emails = jQuery('#batquery_emails').val();
	
	var ws_email_preview = jQuery('#email_preview').val();
	if(ws_email_preview.length < 7 || ws_email_preview.indexOf('@') == -1 || ws_email_preview.indexOf('.') == -1)
	{
		ws_email_preview = '';
	}

	var ws_id_wp_desabo = jQuery('#ws_desabo').val();	
	var ws_url_desabo = jQuery('option[value="' + ws_id_wp_desabo+'"]').attr('title');

	var ws_id_wp_abo = jQuery('#ws_abo').val();
	
	var ws_ea = return_value_checkbox('ws_ea');
	
	var ws_wa = return_value_checkbox('ws_doubletracking');
	var ws_wa_id = jQuery('#ws_doubletracking_id option:selected').val();
	
	var ws_shortcodes_style = return_value_checkbox('ws_shortcodes_style');
		
	var ws_unsubs_text_top = jQuery('#ws_unsubs_text_top').val();	
	var ws_unsubs_text_link = jQuery('#ws_unsubs_text_link').val();	
	var ws_unsubs_text_bottom = jQuery('#ws_unsubs_text_bottom').val();	
		
	// on teste les valeurs
	if( 
	ws_idmlist>0 && ws_login.length > 3 && ws_password.length > 10 
	&& ws_prefix_nl.length > 0 && ws_prefix_email.length > 0 && ws_prefix_bat.length > 0 && ws_prefix_target.length > 0 && ws_batquery_emails.length > 0
	&& ws_id_wp_desabo.length>0 && ws_id_wp_abo.length>0 && ws_unsubs_text_link.length>0
	){
	jQuery('#submit_update_settings').parent().fadeOut('fast');
	jQuery('#submit_update_settings').parent().parent().append('<div class="loading_area" style="text-align:center"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/cheetahmail/ajax/update_settings.php",
		data: {
		i:ws_idmlist, l:ws_login,p:ws_password,lang:ws_date_lang,dkim_id:ws_dkim_id,dkim_label:ws_dkim_label,prefix_nl:ws_prefix_nl,prefix_email:ws_prefix_email,prefix_bat:ws_prefix_bat,prefix_target:ws_prefix_target,email_preview:ws_email_preview,batquery_emails:ws_batquery_emails,id_desabo:ws_id_wp_desabo,url_desabo:ws_url_desabo,txtbefore_desabo:ws_unsubs_text_top,txt_desabo:ws_unsubs_text_link,txtafter_desabo:ws_unsubs_text_bottom,url_abo:ws_id_wp_abo,ea:ws_ea,wa_enabled:ws_wa,wa_id:ws_wa_id,shortcodes_style:ws_shortcodes_style
		},
		 success: function(data){
			
			if(data == -1 || data == -2){
				// erreur WS
				jQuery('#submit_update_settings').parent().fadeIn('fast');
				show_growl(3,rsc_error);
				jQuery('.loading_area').remove();				
			}else if(data == 0){
				jQuery('#submit_update_settings').parent().fadeIn('fast');
				show_growl(2,rsc_settings_saved);
				jQuery('.loading_area').remove();
			}						
			
		} // fin success
	});
	}else{
		// un param est NOK
		show_growl(3,rsc_params_error);
	}
}
);




// function de gestion de la structure de bdd

function _load_structure(div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/get_structure_live.php",
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_nl_contents_load);				
			}else{
				jQuery(div_return).html(data);
				jQuery('.datepicker').datepicker({
					dateFormat : 'yy-mm-dd'
				});					
			}	
		} // fin success
	});	
}



// function pour dire si une checbox est checkée ou pas
function return_value_checkbox_live(div)
{
	if(jQuery(div).is(':checked')){
		return 1;
	}else{
		return 0;
	}
}
	
	
		
jQuery('#submit_update_structure').live('click',function()
{
	jQuery('#submit_update_structure').parent().fadeOut('fast');
	jQuery('#submit_update_structure').parent().parent().append('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	
	var txt_global = '';
	var table_fld = jQuery('#return_table_structure table tr');
	var c = table_fld.length;
	// pour chaque ligne
	jQuery.each(table_fld,function(index,value){
		var id_tr_current = jQuery(value).attr('title');
		var tds_current = jQuery(value).find('td');
		
		// pour chaque case de la ligne
		if(tds_current.length>0){
			var i = 0;		
				txt_global += '{';
				jQuery.each(tds_current,function(index,value){
					if(index == 0){
						// on fait la ligne ID depuis le title du tr
						txt_global += '"id":"' + jQuery(value).parent().attr('title')+'",';
						// type				
						txt_global += '"type":"' + jQuery(value).find('img').attr('title')+'",';
					}else if(index == 1){
						// name
						txt_global += '"display_name":"' + jQuery(value).find('._fld_display_value').val() +'",';
					}else if(index == 2){
						// values
						var txt = '';
						var m = jQuery(value).find('.minus').html();
						var m_tab = m.split('<br>');
						var t = m_tab.length;
						if(m_tab.length > 0)
						{
							jQuery.each(m_tab,function(index,value){
								var m_tab_split = value.split(':');
								if(m_tab_split.length>0 && m_tab_split[0].length>0 )
								{
									txt += m_tab_split[0] + '___' + m_tab_split[1] ;
									if( index < t)
									{
										txt += ';;;';
									}
								}
							});
						}
						txt_global += '"values":"' + txt +'",';
					}else if(index == 3){
						// format
						txt_global += '"formatting":"' + jQuery(value).find('._fld_formatting_value option:selected').val() +'",';
					}else if(index == 4){
						// size
						txt_global += '"size":"' + jQuery(value).find('._fld_size_value').val() + '",';
					}else if(index == 5){
						// sync
						txt_global += '"synchronize":"' + return_value_checkbox_live(jQuery(value).find('._fld_synchronize_value')) +'",';
					}else if(index == 6){
						// editable _fld_synchronize_value
						txt_global += '"editable":"' + return_value_checkbox_live(jQuery(value).find('._fld_editable_value')) +'",';
					}else if(index == 7){
						// displayed
						txt_global += '"displayed":"' + return_value_checkbox_live(jQuery(value).find('._fld_displayed_value')) + '",';
					}else if(index == 8){
						// toppage
						if(jQuery(value).find('._fld_toppage option:selected').val()){
						txt_global += '"toppage":"' + jQuery(value).find('._fld_toppage option:selected').val() + '",';
						}else{
						txt_global += '"toppage":"0",';
						}
					}else if(index == 9){
						// fixed value
						if(jQuery(value).find('._fld_fixed_value option').length > 0 ){
							txt_global += '"fixed_value":"' + jQuery(value).find('._fld_fixed_value option:selected').val() + '"';
						}else{
							if(jQuery(value).find('._fld_fixed_value').hasClass('datepicker')){
							// si class datepicker
								txt_global += '"fixed_value":"' + jQuery.trim(jQuery(value).find('._fld_fixed_value').val() + 'T00:00:00"');
							}else{
							// sinon
								txt_global += '"fixed_value":"' + jQuery.trim(jQuery(value).find('._fld_fixed_value').val() + '"');
							}
						}
					}
					else{}
					// console.log('index : ' + index + ' , value : '+  jQuery(value).html());
					i++;
				
				});
				if(index < (c - 1)){
					txt_global += '},';
				}else{
					txt_global += '}';
				}
		}
	});
	txt_global = '[' + txt_global + ']';
	
	// on recupere les infos du tableau
	if(txt_global.length>0)
	{	
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/update_structure.php",
			data: { 
				s:txt_global
			},
			 success: function(data){
				
				if(data == -1 || data == -2){
					// erreur WS
					show_growl(3,rsc_error);
					jQuery('.loading_area').remove();
					_load_structure('return_table_structure');
					jQuery('#submit_update_structure').parent().fadeIn('fast');
				}else if(data == 0){
					jQuery('.loading_area').remove();
					show_growl(2,rsc_structure_saved);
					jQuery('#submit_update_structure').parent().fadeIn('fast');
				}			
				
			} // fin success
		});
	}else{
		// param manquant
		show_growl(3,rsc_params_error);
		jQuery('.loading_area').remove();
	}
}
);

// si le user clique sur displayed, on check automatiquement synchronize
jQuery('._fld_displayed_value').live('click',function()
{
	jQuery(this).parent().parent().find('._fld_synchronize_value').attr('checked','checked');
}
);

// VUE PARTIELLE STRUCTURE

jQuery(document).ready(function()
	{	
		if(jQuery('#return_table_structure').length>0){
			_load_structure('#return_table_structure');
		}
	}
);








/*
*******************************************************************************************
FONCTION DE GESTION D'UNE CONFIGURATION D'ENVOI
*******************************************************************************************
*/

// function mise à jour d'une configuration

jQuery('#submit_conf').live('click',function()
{
	
	var type=jQuery(this).attr('title');
	var elt = jQuery(this);
	// 1 = subs
	// 2 = unsubs
	// 3 = nl
	// 4 = email
	
	var ws_from = jQuery(this).parent().parent().parent().parent().find('#ws_from').val();
	var ws_mailfromaddr = jQuery(this).parent().parent().parent().parent().find('#ws_mailfromaddr').val();
	var ws_mailnpai = jQuery(this).parent().parent().parent().parent().find('#ws_mailnpai').val();	
	var ws_mailreply = jQuery(this).parent().parent().parent().parent().find('#ws_mailreply').val();
	
	var ws_subject = jQuery(this).parent().parent().parent().parent().find('#ws_subject').val();	

	var ws_html_header = jQuery(this).parent().parent().parent().parent().find('.ws_html_header').val();	
	var ws_txt_header = jQuery(this).parent().parent().parent().parent().find('#ws_txt_header').val();

	var ws_html_body = jQuery(this).parent().parent().parent().parent().find('.ws_html_body').val();	
	var ws_txt_body = jQuery(this).parent().parent().parent().parent().find('#ws_txt_body').val();	
	
	var ws_html_footer = jQuery(this).parent().parent().parent().parent().find('.ws_html_footer').val();	
	var ws_txt_footer = jQuery(this).parent().parent().parent().parent().find('#ws_txt_footer').val();	
	
	// on teste tous les paramètres
	if(
	ws_from.length > 0 && ws_mailfromaddr.length > 0 && ws_mailnpai.length > 0
	&& ws_subject.length > 0 && ws_html_body.length > 0 && ws_txt_body.length > 0
	){
	jQuery(this).parent().parent().parent().parent().find('.loading_temp_maj').fadeIn('fast');
	jQuery(this).parent().parent().fadeOut('fast');
	
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/cheetahmail/ajax/update_config.php",
		data: { 
			type:type, 
			ws_from:ws_from, 
			ws_mailfromaddr:ws_mailfromaddr,
			ws_mailnpai:ws_mailnpai,
			ws_mailreply:ws_mailreply,			
			ws_subject:ws_subject,			
			ws_html_header:ws_html_header,
			ws_txt_header:ws_txt_header,
			ws_html_body:ws_html_body,
			ws_txt_body:ws_txt_body,
			ws_html_footer:ws_html_footer,
			ws_txt_footer:ws_txt_footer
		},
		 success: function(data){
			
			if(data == -1 || data == -2){
				// erreur WS
				jQuery(elt).parent().parent().fadeIn('fast');
				jQuery(elt).parent().parent().parent().parent().find('.loading_temp_maj').fadeOut('fast');
				show_growl(3,rsc_error);
			}else if(data == 0){
				jQuery(elt).parent().parent().fadeIn('fast');
				jQuery(elt).parent().parent().parent().parent().find('.loading_temp_maj').fadeOut('fast');
				if(type == 3){
					_load_content_nl_infos('#return_table_elements_nl');
				}
				
				// on recharge la preview
				if(type==1){_load_chrono_preview(1,'#return_preview_subs');}
				if(type==2){_load_chrono_preview(2,'#return_preview_unsubs');}
				
				show_growl(2,rsc_config_saved);
			}			
			
		} // fin success
	});
	}else{
		// param manquant
		show_growl(3,rsc_params_error);
	}
}
);




// function de preview trigger camp

function _load_chrono_preview(type,div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/preview_campaign_trigger.php",
		data : {type:type},
		type : "POST",
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_nl_contents_load);				
			}else{
				jQuery(div_return).html(data);					
			}	
		} // fin success
	});	
}





// VUE PARTIELLE CONFIGURATION ENVOI

jQuery(document).ready(function()
	{
	
		if(jQuery('#return_table_config_infos_1').length>0){
			_load_config_infos(1,'#return_table_config_infos_1');
		}

		if(jQuery('#return_table_config_infos_2').length>0){
			_load_config_infos(2,'#return_table_config_infos_2');
		}
		
		if(jQuery('#return_table_config_infos_3').length>0){
			_load_config_infos(3,'#return_table_config_infos_3');
		}

		if(jQuery('#return_table_config_infos_4').length>0){
			_load_config_infos(4,'#return_table_config_infos_4');
		}
		
				


	}
);

function _load_config_infos(type,div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_configs_infos.php?type="+type,
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_error);
			}else{
				jQuery(div_return).html(data);	
				// gestion des rich editor
				jQuery( 'textarea.rich-editor' ).ckeditor();
				
				// on lance les preview  car vue partielle dans vue partielle				
				if(type==1){
					_load_chrono_preview(1,'#return_preview_subs');
				}

				if(type==2){
					_load_chrono_preview(2,'#return_preview_unsubs');
				}
		
		
			}		
		} // fin success
	});
}







/*
*******************************************************************************************
FONCTION DE VISUALISATION DES ABOS 
*******************************************************************************************
*/


// VUE PARTIELLE TABLEAUX USERS + VOLUME ABOS

jQuery(document).ready(function()
	{
		if(jQuery('#return_table_subscribers_infos').length>0){
			_load_subscribers_infos('#return_table_subscribers_infos');
		}
	}
);

function _load_subscribers_infos(div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_subscribers_infos.php",
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_subs_infos_load);
			}else{
				jQuery(div_return).html(data);					
			}
			

			
		} // fin success
	});
}








jQuery('#sync_users_from_wp').live('click',function()
{	
	var type = jQuery(this).attr('title');
	jQuery(this).parent().fadeOut('fast');
	jQuery(this).parent().parent().append('<div class="loading_spinner" style="text-align:center"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div>');	
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/cheetahmail/ajax/add_users_from_wp.php",
		data: { 
			type:type
		},
		 success: function(data){
			if(data == -2){
				show_growl(3,rsc_no_users);			
			}
			else if(data == -1){
				show_growl(3,rsc_users_sync);			
			}
			else{
				jQuery('#new_users_added').html(data);
				show_growl(2,rsc_sync_done);					
			}
			jQuery('.loading_spinner').remove();
			jQuery('#sync_users_from_wp').parent().fadeIn('fast');
		}// fin success
	});	

}
);







jQuery('#send_bat_trigger').live('click',function()
{	
	var f = jQuery(this);
	var type = jQuery(this).attr('title');
	jQuery(this).parent().fadeOut('fast');
	jQuery(this).parent().parent().append('<div class="loading_spinner" ><img width="100px" src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div>');	
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/cheetahmail/ajax/test_campaign_trigger.php",
		data: { 
			type:type
		},
		 success: function(data){
			if(data == 0){
				show_growl(2,rsc_test_sent);				
			}else{
				show_growl(3,rsc_error);				
			}
			jQuery('.loading_spinner').remove();
			jQuery(f).parent().fadeIn('fast');
		}// fin success
	});	

}
);




// function USERS

jQuery('.action_subscribers').live('click',function()
{
	var thi = jQuery(this);
	var id_user = jQuery(this).parent().attr('id');
	var at_user = jQuery('tr[id='+id_user+']').find('td').eq(1).html();	
	var type = jQuery(this).attr('id');
	
	if(type == 'subscribe')
	{
		jQuery(thi).parent().parent().find('.actions_switcher').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_buttons').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_loading').fadeIn('fast');
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/subscribe.php",
			data: { 
				type:1,
				at_user:at_user
			},
			 success: function(data){
				jQuery(thi).parent().parent().find('.actions_switcher').fadeOut('fast');
				jQuery(thi).parent().parent().find('.partial_buttons').fadeIn('fast');
				jQuery(thi).parent().parent().find('.partial_loading').fadeOut('fast');

				if(parseInt(data) > 0){
					show_growl(2, at_user + ' ' + rsc_user_subscribed);
					_load_subscribers_infos('#return_table_subscribers_infos');					
				}else{
					show_growl(3,rsc_error);				
				}
				
			}// fin success
		});	
	}	
	else if(type == 'unsubscribe')
	{
		jQuery(thi).parent().parent().find('.actions_switcher').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_buttons').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_loading').fadeIn('fast');

		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/subscribe.php",
			data: { 
				type:2,
				at_user:at_user
			},
			 success: function(data){
				jQuery(thi).parent().parent().find('.actions_switcher').fadeIn('fast');
				jQuery(thi).parent().parent().find('.partial_buttons').fadeIn('fast');
				jQuery(thi).parent().parent().find('.partial_loading').fadeOut('fast');

				if(data > 0){
					show_growl(2, at_user + ' ' +rsc_user_unsubscribed);
					_load_subscribers_infos('#return_table_subscribers_infos');					
				}else{
					show_growl(3,rsc_error);				
				}				
				
			}// fin success
		});			
	}
	else if(type == 'delete')
	{
		jQuery(thi).parent().parent().find('.actions_switcher').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_buttons').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_loading').fadeIn('fast');

		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/subscribe.php",
			data: { 
				type:-1,
				at_user:at_user
			},
			 success: function(data){
				jQuery(thi).parent().parent().find('.actions_switcher').fadeIn('fast');
				jQuery(thi).parent().parent().find('.partial_buttons').fadeIn('fast');
				jQuery(thi).parent().parent().find('.partial_loading').fadeOut('fast');

				if(data > 0){
					show_growl(2, at_user + ' ' +rsc_user_deleted);
					_load_subscribers_infos('#return_table_subscribers_infos');					
				}else{
					show_growl(3,rsc_error);				
				}				
				
			}// fin success
		});			
	}
	else if(type == 'update')
	{	
		// on met le layer edition	
		var jHtml = '<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>';
		jQuery('#layer_back, #layer_front').remove();
		jQuery('body').prepend('<div id="layer_back">&nbsp;</div>');jQuery('#layer_back').fadeTo('slow',0.5);
		jQuery('body').prepend('<div id="layer_front">'+jHtml+'</div>');jQuery('#layer_front').fadeIn('slow');

		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/update_user_view.php",
			data: { 
				type:2,
				id_user:id_user
			},
			 success: function(data){
				if(data < 0){
					show_growl(3,rsc_error);
					jQuery('#layer_back, #layer_front').remove();					
				}else{
					jQuery('#layer_front').html(data);	
					jQuery('.datepicker').datepicker({
						dateFormat : 'yy-mm-dd'
					});					
				}				
				
			}// fin success
		});			
	}		
}
);


jQuery('#submit_update_user').live('click',function()
{
		jQuery('#submit_update_user').parent().fadeOut('slow');
		jQuery('#table_update_user').append('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	
	
		if(jQuery('.fld').length>1){
			var c = parseInt(jQuery('.fld').length)-1;
		}
		var id_user = jQuery('#fld_0').val();		
		var tab = '';
		
		tab += '{';	
			
		jQuery.each(jQuery('.fld'),function(index,value){
			var g = '';		
			var id_fld = jQuery(value).attr('id').split('_')[1];
			var val_fld = jQuery(value).val();
			var type_fld = jQuery(value).parent().parent().find('td').eq(0).find('img').attr('title');		
			g += '';
			
			 			 
			 
			if(type_fld == 2){
				// date
				val_fld = val_fld.replace(" ","T");	
				if(val_fld.length<1){}
				else if(val_fld.length<=10){
					val_fld = val_fld+'T00:00:00';
					g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'"}';	
					if(index < c){g +=',';}						
				}
				else
				{
					g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'"}';	
					if(index < c){g +=',';}	
				}
					
			}else if(type_fld == 5){
					val_fld = jQuery(value).find('option:selected').val();
					g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'"}';	
					if(index < c){g +=',';}				
			}
			else{
				g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'"}';		
				if(index < c){
					g +=',';
				}	
			}		
			tab += g;
		});		
		tab += '}';
		
		jQuery.ajax({
			url: "../wp-content/plugins/cheetahmail/ajax/update_user.php",
			type:"post",
			data : {
			id_user:id_user,
			post_values:tab
			},
			success: function(data){
				if(data == -1 || data == -2){
					// erreur on affiche un message et un bouton de rechargement
					show_growl(3,rsc_error);
					jQuery('#submit_update_user').parent().fadeIn('slow');					
					jQuery('.loading_area').remove();					
				}else{
					show_growl(2,rsc_user_updated);
					jQuery('#layer_back, #layer_front').remove();					
									
				}	
			} // fin success
		});
	
	}
);


jQuery('.numeric').live('keyup',function()
{
	var val = parseInt(jQuery(this).val());
	if(isNaN(val)){
		val="";
	}
	jQuery(this).val(val);
}
);


jQuery('#email_search').live('keyup keydown focus blur',function()
{
		if(jQuery(this).val().length>0){
			// si le champ est rempli on active le bouton ok
			jQuery('#valid_email_search').removeAttr('disabled');
		}else{
			// si le champ est vide on désactive le bouton ok
			jQuery('#valid_email_search').attr('disabled','disabled');
		}
		
	}
);



jQuery('#valid_email_search').live('click',function()
{	
		if(jQuery('#email_search').val().length>0){
			search_at(jQuery('#email_search').val());
		}		
	}
);




/* GESTION TOUCHE ENTER DS FLD RECHERCHE */

	jQuery('body').live('keyup', function(event) 
	{
		if (event.keyCode == '13' || event.keyCode == '61' ) {
				var e_at = jQuery('#email_search').val();
				search_at(e_at);				
		}
	}
	);	
	

function search_at(email)
{
	jQuery('#ajax_area_search').html('<div class="loading_area"><br /><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_search_user.php",
		type:"post",
		data : {
		search:email
		},
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_error);				
			}else{
				jQuery('#ajax_area_search').html(data);					
			}	
		} // fin success
	});
	
	
	
}



/*
*******************************************************************************************
FONCTION DES NEWSLETTERS
*******************************************************************************************
*/


// VUE PARTIELLE TABLEAUX USERS + VOLUME ABOS


jQuery(document).ready(function()
	{
		if(jQuery('#return_table_settings_nl').length>0){
			_load_settings_nl_infos(1,'#return_table_settings_nl');
		}
		if(jQuery('#return_table_style_nl').length>0){
			_load_settings_nl_infos(2,'#return_table_style_nl');
		}
		if(jQuery('#return_table_preview_style_nl').length>0){
			_load_preview_style_nl('#return_table_preview_style_nl');
		}		
		if(jQuery('#return_table_sent_nl').length>0){
			_load_sent_nl_infos(3,'#return_table_sent_nl');
		}
		if(jQuery('#return_table_elements_nl').length>0){
			_load_content_nl_infos('#return_table_elements_nl');
		}
		
	}
);

function _load_settings_nl_infos(type,div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_settings_nl.php?type="+type,
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_nl_envelop_load);
			}else{
				jQuery(div_return).html(data);					
			}			
		} // fin success
	});
}


function _load_preview_style_nl(div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_style_preview_nl.php",
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_nl_envelop_load);
			}else{
				jQuery(div_return).html(data);					
			}			
		} // fin success
	});
}



function _load_content_nl_infos(div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_content_preview.php",
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_nl_contents_load);				
			}else{
				jQuery(div_return).html(data);					
			}	
		} // fin success
	});
}




function _load_sent_nl_infos(type,div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_campaigns_table.php?type="+type,
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_nl_infos_load);				
			}else{
				jQuery(div_return).html(data);	
				// gestion des colorpickers
				if(jQuery('.colorpicker').length>0){
					ColorPickMe('#cp_title','#ws_title_color');
					ColorPickMe('#cp_content','#ws_content_color');
					ColorPickMe('#cp_link','#ws_link_color');
					ColorPickMe('#cp_coment','#ws_coment_color');
				}
			}
			

			
		} // fin success
	});
}






// function update des settings STYLE NL 

jQuery('#submit_change_nl_settings').live('click',function()
{

	var ws_nl_active = return_value_checkbox('ws_activation');	
	var ws_nl_target = jQuery('#ws_target option:selected').val();	
	
	var ws_nl_type_elements = jQuery('#ws_type_elements option:selected').val();
	var ws_nl_nb_elements = jQuery('#ws_nb_elements option:selected').val();
	var ws_nl_order_elements = jQuery('#ws_order_elements option:selected').val();
	var ws_nl_frequency = jQuery('#ws_frequency option:selected').val();	
	
	var ws_title_fontface = jQuery('#ws_title_fontface option:selected').val();
	var ws_title_color = jQuery('#ws_title_color').val();
	var ws_title_size = jQuery('#ws_title_size').val();
	var ws_title_underline = return_value_checkbox('ws_title_underline');
	var ws_title_bold = return_value_checkbox('ws_title_bold');
	var ws_title_italic = return_value_checkbox('ws_title_italic');
	var ws_title_uppercase = return_value_checkbox('ws_title_uppercase');
	
	var ws_content_fontface = jQuery('#ws_content_fontface option:selected').val();
	var ws_content_color = jQuery('#ws_content_color').val();
	var ws_content_size = jQuery('#ws_content_size').val();
	var ws_content_underline = return_value_checkbox('ws_content_underline');
	var ws_content_bold = return_value_checkbox('ws_content_bold');
	var ws_content_italic = return_value_checkbox('ws_content_italic');
	var ws_content_uppercase = return_value_checkbox('ws_content_uppercase');
	
	var ws_link_defaulttext = jQuery('#ws_link_defaulttext').val();
	var ws_link_fontface = jQuery('#ws_link_fontface option:selected').val();
	var ws_link_color = jQuery('#ws_link_color').val();
	var ws_link_size = jQuery('#ws_link_size').val();
	var ws_link_underline = return_value_checkbox('ws_link_underline');
	var ws_link_bold = return_value_checkbox('ws_link_bold');
	var ws_link_italic = return_value_checkbox('ws_link_italic');
	var ws_link_uppercase = return_value_checkbox('ws_link_uppercase');
	
	var ws_coment_fontface = jQuery('#ws_coment_fontface option:selected').val();
	var ws_coment_color = jQuery('#ws_coment_color').val();
	var ws_coment_size = jQuery('#ws_coment_size').val();
	var ws_coment_underline = return_value_checkbox('ws_coment_underline');
	var ws_coment_bold = return_value_checkbox('ws_coment_bold');
	var ws_coment_italic = return_value_checkbox('ws_coment_italic');
	var ws_coment_uppercase = return_value_checkbox('ws_coment_uppercase');
	
	var ws_nl_link =return_value_checkbox('ws_nl_link');
	var ws_nl_img =return_value_checkbox('ws_nl_img');
	var ws_nl_coment =jQuery('#ws_nl_coment').val();

	if(
	ws_title_color.length>0 &&  ws_title_size.length>0 && 
	ws_content_color.length>0 &&  ws_content_size.length>0 &&
	ws_link_color.length>0 &&  ws_link_size.length>0 && ws_link_defaulttext.length>0
	)
	{
		jQuery('#return_table_settings_nl, #return_table_style_nl').append('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
		
		jQuery('#submit_change_nl_settings').parent().fadeOut('fast');

		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/update_settings_nl.php",
			data: { 
			
				nl_active:ws_nl_active, 
				nl_type_elements:ws_nl_type_elements, 
				nl_nb_elements:ws_nl_nb_elements, 
				nl_order_elements:ws_nl_order_elements, 
				nl_frequency:ws_nl_frequency,
				nl_target:ws_nl_target,
				
				nl_title_fontface:ws_title_fontface, 
				nl_title_color:ws_title_color, 
				nl_title_size:ws_title_size, 
				nl_title_underline:ws_title_underline,
				nl_title_bold:ws_title_bold, 
				nl_title_italic:ws_title_italic, 
				nl_title_uppercase:ws_title_uppercase, 
				
				nl_content_fontface:ws_content_fontface, 
				nl_content_color:ws_content_color, 
				nl_content_size:ws_content_size, 
				nl_content_underline:ws_content_underline,
				nl_content_bold:ws_content_bold, 
				nl_content_italic:ws_content_italic, 
				nl_content_uppercase:ws_content_uppercase, 			
				
				nl_link_defaulttext:ws_link_defaulttext, 
				nl_link_fontface:ws_link_fontface, 
				nl_link_color:ws_link_color, 
				nl_link_size:ws_link_size, 
				nl_link_underline:ws_link_underline,
				nl_link_bold:ws_link_bold, 
				nl_link_italic:ws_link_italic, 
				nl_link_uppercase:ws_link_uppercase, 			

				nl_coment_fontface:ws_coment_fontface, 
				nl_coment_color:ws_coment_color, 
				nl_coment_size:ws_coment_size, 
				nl_coment_underline:ws_coment_underline,
				nl_coment_bold:ws_coment_bold, 
				nl_coment_italic:ws_coment_italic, 
				nl_coment_uppercase:ws_coment_uppercase, 			
				
				nl_link:ws_nl_link,
				nl_img:ws_nl_img,
				nl_coment:ws_nl_coment
				
			},
			 success: function(data){
				
				jQuery('.loading_area').remove();
				if(data == -1 || data == -2){
					// erreur WS
					jQuery('#submit_change_nl_settings').parent().fadeIn('fast');
					_load_settings_nl_infos(1,'#return_table_settings_nl');
					_load_settings_nl_infos(2,'#return_table_style_nl');
					_load_preview_style_nl('#return_table_preview_style_nl');
					show_growl(3,rsc_error);
					
				}else if(data == 0){
					jQuery('#submit_change_nl_settings').parent().fadeIn('fast');
					_load_content_nl_infos('#return_table_elements_nl');
					show_growl(2,rsc_nl_settings_saved);	
					// if(ws_nl_active == 1){
						jQuery('#sub_nl_elt').fadeIn('fast');
					// }else{
						// jQuery('#sub_nl_elt').fadeOut('fast');
					// }
					_load_preview_style_nl('#return_table_preview_style_nl');
				}
				
				
				
			} // fin success
		});
	}else{
		show_growl(3,rsc_params_error);
	}	
}
);


// (dés)affichage du cadre du style des liens
jQuery('#ws_nl_link').live('click',function()
{
	jQuery('#link_third_page').toggle();
}
);


// gestion du PUSH NL
jQuery('#send_nl_nl').live('click',function()
{
	var j = jQuery(this);
	jQuery(j).parent().parent().append('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery(j).parent().parent().find('.valid').fadeOut('fast');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/send_nl.php?type=send",
		success: function(data){
			if(data == -1){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_no_nl_topush);				
				jQuery('.loading_area').remove();
				jQuery(j).parent().parent().find('.valid').fadeIn('fast');				
			}else{
				show_growl(2,rsc_nl_topush);
				jQuery('.loading_area').remove();
				jQuery(j).parent().parent().find('.valid').fadeIn('fast');
			}
			

			
		} // fin success
	});	
}
);

// gestion du PUSH NL BAT
jQuery('#send_bat_nl').live('click',function()
{
	var j = jQuery(this);
	jQuery(j).parent().parent().append('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery(j).parent().parent().find('.valid').fadeOut('fast');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/send_nl.php?type=bat",
		success: function(data){
			if(data == -1){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,rsc_no_nl_topush);				
				jQuery('.loading_area').remove();
				jQuery(j).parent().parent().find('.valid').fadeIn('fast');				
			}else{
				show_growl(2,rsc_nl_topush);
				jQuery('.loading_area').remove();
				jQuery(j).parent().parent().find('.valid').fadeIn('fast');
			}
			

			
		} // fin success
	});		
}
);


/*
*******************************************************************************************
FONCTION DE GESTION DES TEMPLATES
*******************************************************************************************
*/

// function ajout de template

jQuery('#submit_add_template').live('click',function()
{

	var ws_name_template = jQuery('#ws_name_template').val();
	var ws_html_template = jQuery('#ws_html_template').val();
	var ws_txt_template = jQuery('#ws_txt_template').val();	
	var ws_subject_template = jQuery('#ws_subject_template').val();	
	
	if( ws_name_template.length>0 && ws_html_template.length>0 && ws_txt_template.length>0 && ws_subject_template.length>0)
	{
		jQuery('#submit_add_template').parent().fadeOut('fast');
		jQuery('#loading_area_tpl_add').fadeIn('fast');
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/add_template.php",
			data: {
				TemplateName:ws_name_template, 
				SourceHTML:ws_html_template, 
				SourceTXT:ws_txt_template,
				subject:ws_subject_template
			},
			 success: function(data){
				if(data == -2){
					// erreur WS
					jQuery('#submit_add_template').parent().fadeIn('slow');
					jQuery('#loading_area_tpl_add').fadeOut('fast');
					show_growl(3,rsc_error);
				}else if(data > 0){
					jQuery('#ws_name_template').val('');
					jQuery('#ws_subject_template').val('');
					jQuery('#ws_html_template').val('');
					jQuery('#ws_txt_template').val('');		
					jQuery('#submit_add_template').parent().fadeIn('slow');
					jQuery('#loading_area_tpl_add').fadeOut('fast');
					jQuery('#layer_front,#layer_back').remove();
					var date_create_tpl = new Date();
					var month = date_create_tpl.getMonth();
					var month_ok = '';
					switch(month){
						case 0 : month_ok = '01'; break;
						case 1 : month_ok = '02'; break;
						case 2 : month_ok = '03'; break;
						case 3 : month_ok = '04'; break;
						case 4 : month_ok = '05'; break;
						case 5 : month_ok = '06'; break;
						case 6 : month_ok = '07'; break;
						case 7 : month_ok = '08'; break;
						case 8 : month_ok = '09'; break;
						case 9 : month_ok = '10'; break;
						case 10 : month_ok = '11'; break;
						case 11 : month_ok = '12'; break;
					}					
					var date_default = date_create_tpl.getFullYear()+'-'+month_ok+'-'+date_create_tpl.getDate()+' '+date_create_tpl.getHours()+':'+date_create_tpl.getMinutes()+':'+date_create_tpl.getSeconds();
					jQuery('#ws_tpl_upload_campaign').append('<option value="'+data+'">'+ws_name_template+' ('+date_default+')</option>');
					_load_templates('#return_table_templates');				
					// _load_camps(1,'#return_table_preparing_campaigns');				
					show_growl(2,rsc_tpl_added);
				}
			} // fin success
		});
	}else{
		show_growl(3,rsc_params_error);
	}
}
);

// function update de template

jQuery('#submit_change_template').live('click',function()
{

	var ws_id_template = jQuery('#template_id').val();
	var ws_name_template = jQuery('#template_name').val();
	var ws_html_template = jQuery('#template_html').val();
	var ws_txt_template = jQuery('#template_txt').val();	
	var ws_subject_template = jQuery('#template_subject').val();	

	if(ws_id_template>0 && ws_name_template.length>0 &&  ws_html_template.length>0 &&  ws_txt_template.length>0 &&  ws_subject_template.length>0)
	{
		jQuery('#submit_change_template').parent().fadeOut('fast');
		jQuery('#loading_area_tpl_save').fadeIn('fast');
		
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/update_template.php",
			data: { 
				TemplateId:ws_id_template, 
				TemplateName:ws_name_template, 
				SourceHTML:ws_html_template, 
				SourceTXT:ws_txt_template,
				subject:ws_subject_template
			},
			 success: function(data){
				if(data == -1 || data == -2){
					// erreur WS
					jQuery('#submit_change_template').parent().fadeIn('fast');	
					jQuery('#loading_area_tpl_save').fadeOut('fast');				
					show_growl(3,rsc_error);
				}else if(data == 0){
					_load_templates('#return_table_templates');	
					jQuery('#submit_change_template').parent().fadeIn('fast');	
					jQuery('#loading_area_tpl_save').fadeOut('fast');
					jQuery('#layer_front,#layer_back').remove();
					
					// _load_camps(1,'#return_table_preparing_campaigns');
					show_growl(2,rsc_tpl_saved);
				}
				

				
			} // fin success
		});
	}else{
		show_growl(3,rsc_params_error);
	}
}
);

// function TEMPLATES

jQuery('.action_template').live('click',function()
{
	var thi = jQuery(this);
	var type = jQuery(this).attr('id');
	var id_template = jQuery(this).parent().attr('id');
	var name_template = jQuery(this).parent().parent().parent().find('td').eq(2).html();		
	
	if(type == 'edit')
	{
		jQuery('body').prepend('<div id="layer_back">&nbsp;</div>');jQuery('#layer_back').fadeTo('slow',0.5);
		jQuery('body').prepend('<div id="layer_front"><div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div></div>');jQuery('#layer_front').fadeIn('slow');				
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/get_template.php",
			data: { 
				idTemplate:id_template
			},
			 success: function(data){
				// on affiche le layer update
				jQuery('#layer_front').html(data);
				jQuery( 'textarea.rich-editor' ).ckeditor();
			}// fin success
		});	
	}
	else if(type == 'preview')
	{
		// on met le layer de preview
		var jHtml = '';
		jHtml += '';
		jHtml += '<h2>&quot;'+name_template+'&quot; <div class="shut">X</div></h2>';
		jHtml += '<div>';
		jHtml += '<p><iframe class="subj" src="../wp-content/plugins/cheetahmail/preview/template_preview.php?type=subject&idt='+id_template+'" /></p>';
		jHtml += '<p><label class="switcher active" id="1">HTML</label><label class="switcher" id="2">TXT</label></p>';
		jHtml += '<p class="switch" id="1"><iframe src="../wp-content/plugins/cheetahmail/preview/template_preview.php?type=html&idt='+id_template+'" /></p>';
		jHtml += '<p class="switch" id="2" style="display:none"><iframe src="../wp-content/plugins/cheetahmail/preview/template_preview.php?type=txt&idt='+id_template+'" /></p>';
		jHtml += '</div>';
		jQuery('body').prepend('<div id="layer_back">&nbsp;</div>');jQuery('#layer_back').fadeTo('slow',0.5);
		jQuery('body').prepend('<div id="layer_front">'+jHtml+'</div>');jQuery('#layer_front').fadeIn('slow');
		
	}
	else if(type == 'duplicate')
	{
		// on lance la duplication
		jQuery(thi).parent().parent().find('.actions_switcher').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_loading').fadeIn('fast');
		
		jQuery(thi).parent().fadeOut('fast');		
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/duplicate_template.php",
			data: { 
				idTemplate:id_template
			},
			 success: function(data){
				if(data == 0){
					_load_templates('#return_table_templates');	
					show_growl(2,rsc_tpl_duplicated);				
				}else{
					// erreur
					jQuery(thi).parent().parent().find('.actions_switcher').fadeIn('fast');
					jQuery(thi).parent().parent().find('.partial_loading').fadeOut('fast');					
					show_growl(3,rsc_error);
				}
			}// fin success
		});	// fin duplicate
	}	
	else if(type == 'delete')
	{
		show_del_layer(1,id_template,'delete_template');	
	}
}
);






// function de suppression d'un template

function delete_template(id_template)
{
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/cheetahmail/ajax/delete_template.php",
		data: { 
			idTemplate:id_template
		},
		 success: function(data){
			if(data == 0){
				jQuery('tr[id='+id_template+']').remove();
				hide_del_layer();
				show_growl(2,rsc_tpl_deleted);
				jQuery('#ws_tpl_upload_campaign option[value='+id_template+']').remove();
				_load_templates_list_select('ws_tpl_upload_template');				
			}else{
				// erreur
				show_growl(3,rsc_error);
			}
		}// fin success
	});			
}



// function de chargement d'un template dans une campagne email
	
jQuery('#load_tpl').live('click',function()
{
	if(jQuery(this).parent().parent().find('#ws_tpl_upload_campaign option:selected').val() >0)
	{
		jQuery(this).parent().fadeOut('slow',function(){
			jQuery('#loading_area_tpl').fadeIn('fast');
		});
		var id_ct = jQuery(this);
		
		
		var type = jQuery(this).attr('title');		
		var ic = jQuery(this).parent().parent().parent().find('#campaign_id');
		var it = jQuery(this).parent().parent().parent().find('#ws_tpl_upload_campaign');
		var cs = jQuery(this).parent().parent().parent().find('#campaign_subject');
		var ch = jQuery(this).parent().parent().parent().find('#campaign_html');
		var ct = jQuery(this).parent().parent().parent().find('#campaign_txt');
		var id_campaign = jQuery(ic).val();
		var id_template = jQuery(it).val();	
		var campaign_subject = jQuery(cs).val();
		var campaign_html = jQuery(ch).val();
		var campaign_txt = jQuery(ct).val();
		
		if(id_template>0){
			jQuery.ajax({
				type: "POST",
				url: "../wp-content/plugins/cheetahmail/ajax/load_template.php",
				data:{ 
					TemplateId:id_template
				},
				 success: function(data){
					if(data != -2 &&  data != -1)
					{
						var tab_data = jQuery.parseJSON(data);
						// on affiche le layer update
						jQuery(cs).val(tab_data.subject);
						jQuery(ch).val(tab_data.html);
						jQuery(ct).val(tab_data.txt);					
						jQuery(id_ct).parent().parent().find('#ws_tpl_upload_campaign').val('-1');
						jQuery('#load_tpl').parent().fadeIn('fast',function(){
							jQuery('#loading_area_tpl').fadeOut('fast');
						});
						
					}
					else
					{
						// erreur de recuperation de template
						jQuery('#ws_tpl_upload_campaign').val('-1');
						jQuery('#load_tpl').parent().fadeIn('fast',function(){
							jQuery('#loading_area_tpl').fadeOut('fast');
						});
					}
				}// fin success
			});	
		}else{
			// aucun template
			jQuery(id_ct).parent().parent().find('#ws_tpl_upload_campaign').val('-1');
			jQuery('#load_tpl').parent().fadeIn('fast',function(){
				jQuery('#loading_area_tpl').fadeOut('fast');
			});
		}
	
	}else{
		// pas de template : on ne fait rien
		// console.log('nothing to do');
	}
}
);



// function de chargement d'un template pour add a template
jQuery('#load_tpl_tpl').live('click',function()
{
	if(jQuery(this).parent().parent().find('#ws_tpl_upload_template option:selected').val() >0)
	{
		jQuery(this).parent().fadeOut('slow',function(){
		jQuery('#loading_area_tpl_tpl').fadeIn('fast');
		});
		var id_ct = jQuery(this);
		
		
		var type = jQuery(this).attr('title');		
		var it = jQuery(this).parent().parent().parent().find('#ws_tpl_upload_template');
		var na = jQuery(this).parent().parent().parent().find('#ws_name_template');
		var cs = jQuery(this).parent().parent().parent().find('#ws_subject_template');
		var ch = jQuery(this).parent().parent().parent().find('#ws_html_template');
		var ct = jQuery(this).parent().parent().parent().find('#ws_txt_template');
		var id_template = jQuery(it).val();	
		
		if(id_template>0){
			jQuery.ajax({
				type: "POST",
				url: "../wp-content/plugins/cheetahmail/ajax/load_template.php",
				data:{ 
					TemplateId:id_template
				},
				 success: function(data){
					if(data != -2 &&  data != -1)
					{
						var tab_data = jQuery.parseJSON(data);
						// on affiche le layer update						
						jQuery(na).val(tab_data.name);
						jQuery(cs).val(tab_data.subject);
						jQuery(ch).val(tab_data.html);
						jQuery(ct).val(tab_data.txt);					
						jQuery(id_ct).parent().parent().find('#ws_tpl_upload_template').val('-1');
						jQuery('#load_tpl_tpl').parent().fadeIn('fast',function(){
							jQuery('#loading_area_tpl_tpl').fadeOut('fast');
						});
						
					}
					else
					{
						// erreur de recuperation de template
						jQuery('#ws_tpl_upload_template').val('-1');
						jQuery('#load_tpl_tpl').parent().fadeIn('fast',function(){
							jQuery('#loading_area_tpl_tpl').fadeOut('fast');
						});
					}
				}// fin success
			});	
		}else{
			// aucun template
			jQuery(id_ct).parent().parent().find('#ws_tpl_upload_template').val('-1');
			jQuery('#load_tpl_tpl').parent().fadeIn('fast');
			jQuery(id_ct).parent().find('#loading_area_tpl_tpl').fadeOut('fast');
		}
	
	}else{
		// pas de template : on ne fait rien
		// console.log('nothing to do');
	}
}
);






// VUE PARTIELLE TABLEAUX TEMPLATES

jQuery(document).ready(function()
	{
		if(jQuery('#return_table_templates').length>0){
			_load_templates('#return_table_templates');
			jQuery( 'textarea.rich-editor' ).ckeditor();
		}
	}
);

function _load_templates(div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_templates_table.php?ip="+new Date().getTime(),
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(3,templates);
			}else{
				jQuery(div_return).html(data);
				_load_templates_list_select('ws_tpl_upload_template');
				//html(data);					
			}
			

			
		} // fin success
	});
}


function _load_templates_list_select(div_return)
{
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/get_templates_select.php?ip="+new Date().getTime(),
		success: function(data){
			if(data == -1 || data == -2){
				// false : sleep
			}else{
				
				jQuery('#' + div_return).html(data);
			}
		} // fin success
	});
}





/*
*******************************************************************************************
CAMPAGNES
*******************************************************************************************
*/

// function ajout CAMPAIGN

jQuery('#submit_add_campaign').live('click',function()
{

	var ws_name_campaign = jQuery('#ws_name_campaign').val();
	var ws_html_campaign = jQuery('#campaign_html').val();
	var ws_txt_campaign = jQuery('#campaign_txt').val();	
	var ws_subject_campaign = jQuery('#campaign_subject').val();	
	var ws_target_campaign = jQuery('#ws_target option:selected').val();	
	
	if(ws_name_campaign.length>0 && ws_html_campaign.length>0 && ws_txt_campaign.length>0 && ws_subject_campaign.length>0)
	{
		jQuery('#submit_add_campaign').parent().fadeOut('fast');
		jQuery('#loading_area_camp_add').fadeIn('fast');
		
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/add_campaign.php",
			data: { 
				description:ws_name_campaign, 
				htmlSrc:ws_html_campaign, 
				txtSrc:ws_txt_campaign,
				subject:ws_subject_campaign,
				target:ws_target_campaign,
				wishdate:'0001-01-01T00:00:00'
			},
			 success: function(data){
				if(data == -1 || data == -2){
					// erreur WS
					jQuery('#submit_add_campaign').parent().fadeIn('fast');
					jQuery('#loading_area_camp_add').fadeOut('fast');
					show_growl(3,rsc_error);
				}else if(data == 0){
					jQuery('#ws_name_campaign').val('');
					jQuery('#campaign_subject').val('');
					jQuery('#campaign_html').val('');
					jQuery('#campaign_txt').val('');	
					

					
					jQuery('#submit_add_campaign').parent().fadeIn('slow');
					jQuery('#loading_area_camp_add').fadeOut('fast');
					_load_camps(1,'#return_table_preparing_campaigns');			
					show_growl(2,rsc_camp_added);
					

				}
				
				
			} // fin success
		});
	}else{
		show_growl(3,rsc_params_error);
	}	
}
);

// function CAMPAIGNS

jQuery('.action_campaign').live('click',function()
{
	var thi = jQuery(this);
	var id_campaign = jQuery(this).parent().attr('id');
	var name_campaign = jQuery('tr[id='+id_campaign+']').find('td').eq(2).html();	
	var type = jQuery(this).attr('id');
	
	if(type == 'edit')
	{
		jQuery('body').prepend('<div id="layer_back">&nbsp;</div>');jQuery('#layer_back').fadeTo('slow',0.5);
		jQuery('body').prepend('<div id="layer_front"><div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div></div>');jQuery('#layer_front').fadeIn('slow');				
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/get_campaign.php",
			data: { 
				id_campaign:id_campaign
			},
			 success: function(data){
				jQuery('#layer_front').html(data);
				jQuery( 'textarea.rich-editor' ).ckeditor();
			}// fin success
		});	
	}
	else if(type == 'preview')
	{

		jQuery('body').prepend('<div id="layer_back">&nbsp;</div>');jQuery('#layer_back').fadeTo('slow',0.5);
		jQuery('body').prepend('<div id="layer_front"><div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div></div>');jQuery('#layer_front').fadeIn('slow');				
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/preview_campaign.php",
			data: { 
				id_campaign:id_campaign
			},
			 success: function(data){
				// on affiche le layer update
				jQuery('#layer_front').html(data);
			}// fin success
		});	
				
	}
	else if(type == 'stats')
	{
		jQuery('body').prepend('<div id="layer_back">&nbsp;</div>');jQuery('#layer_back').fadeTo('slow',0.5);
		jQuery('body').prepend('<div id="layer_front"><div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div></div>');jQuery('#layer_front').fadeIn('slow');				
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/resume_campaign.php",
			data: { 
				id_campaign:id_campaign
			},
			 success: function(data){
				// on affiche le layer stats
				jQuery('#layer_front').html(data);
				draw_graphs('graphik_1');
				draw_graphs('graphik_2');
				draw_barchart('graphik_3');
			}// fin success
		});				
	}	
	else if(type == 'delete')
	{
		show_del_layer(2,id_campaign,'delete_campaign');				
	}	
	else if(type == 'send')
	{
		show_send_layer(id_campaign);		
	}
	else if(type == 'sendbat')
	{
		jQuery(thi).parent().parent().find('.actions_switcher').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_buttons').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_loading').fadeIn('fast');

		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/send_campaign.php",
			data: { 
				type:2,
				id_campaign:id_campaign
			},
			 success: function(data){
				if(data == 0){
					show_growl(2,rsc_test_sent);				
				}else{
					show_growl(3,rsc_error);				
				}
				jQuery(thi).parent().parent().find('.actions_switcher').fadeIn('fast');
				jQuery(thi).parent().parent().find('.partial_buttons').fadeIn('fast');
				jQuery(thi).parent().parent().find('.partial_loading').fadeOut('fast');
			}// fin success
		});			
	}
	else if(type == 'duplicate')
	{
		jQuery(thi).parent().parent().find('.actions_switcher').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_buttons').fadeOut('fast');
		jQuery(thi).parent().parent().find('.partial_loading').fadeIn('fast');
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/duplicate_campaign.php",
			data: { 
				type:2,
				id_campaign:id_campaign
			},
			 success: function(data){
				if(data > 0){
					jQuery(thi).parent().parent().find('.actions_switcher').fadeIn('fast');
					jQuery(thi).parent().parent().find('.partial_buttons').fadeIn('fast');
					jQuery(thi).parent().parent().find('.partial_loading').fadeOut('fast');
					_load_camps(1,'#return_table_preparing_campaigns');
					show_growl(2,rsc_camp_duplicated);
				}
				else
				{
					show_growl(3,rsc_error);
					jQuery(thi).parent().parent().find('.actions_switcher').fadeIn('fast');
					jQuery(thi).parent().parent().find('.partial_buttons').fadeIn('fast');
					jQuery(thi).parent().parent().find('.partial_loading').fadeOut('fast');
				}
			}// fin success
		});			
	}
}
);






// function de suppression d'une campagne

function delete_campaign(id_campaign)
{
	
	jQuery.ajax({
		type: "POST",
		url: "../wp-content/plugins/cheetahmail/ajax/delete_campaign.php",
		data: { 
			id_campaign:id_campaign
		},
		 success: function(data){
			if(data == 0){
				jQuery('tr[id='+id_campaign+']').remove();
				hide_del_layer();
				_load_camps(1,'#return_table_preparing_campaigns');
				show_growl(2,rsc_camp_deleted);
			}else{
				// erreur
				show_growl(3,rsc_error);				
			}
		}// fin success
	});			
}




// function update CAMPAIGN

jQuery('#submit_change_campaign').live('click',function()
{
	var id_campaign = jQuery('#layer_front').find('#campaign_id').val();
	var campaign_name = jQuery('#layer_front').find('#campaign_name').val();
	var campaign_target = jQuery('#layer_front').find('#ws_target option:selected').val();
	var campaign_subject = jQuery('#layer_front').find('#campaign_subject').val();
	var campaign_html = jQuery('#layer_front').find('#campaign_html').val();
	var campaign_txt = jQuery('#layer_front').find('#campaign_txt').val();
	
	if(id_campaign>0 && campaign_name.length>0 && campaign_subject.length>0 && campaign_html.length>0 && campaign_txt.length>0)
	{	
		jQuery('#submit_change_campaign').parent().fadeOut('fast');
		jQuery('#loading_area_camp_update').fadeIn('fast');
		
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/update_campaign.php",
			data:{ 
				campaignId:id_campaign,
				campaignName:campaign_name,
				subject:campaign_subject,
				target:campaign_target,
				SourceHTML:campaign_html,
				SourceTXT:campaign_txt
			},
			 success: function(data){
				// on affiche le layer update
				if(data==0){
					jQuery('#submit_change_campaign').parent().fadeIn('fast');
					jQuery('#loading_area_camp_update').fadeOut('fast');			
					jQuery('#layer_back,#layer_front').remove();
					_load_camps(1,'#return_table_preparing_campaigns');
					show_growl(2,rsc_camp_saved);
				}
				else
				{
					// erreur
					jQuery('#submit_change_campaign').parent().fadeIn('fast');
					jQuery('#loading_area_camp_update').fadeOut('fast');				
					show_growl(3,rsc_error);
				}
				
			}// fin success
		});	
	}else{	
		show_growl(3,rsc_params_error);	
	}
}
);







// VUE PARTIELLE TABLEAUX CAMPAGNES

jQuery(document).ready(function()
	{
		if(jQuery('#return_table_preparing_campaigns').length>0){
			_load_camps(1,'#return_table_preparing_campaigns');
		}
		if(jQuery('#return_table_sent_campaigns').length>0){
			_load_camps(2,'#return_table_sent_campaigns');
		}	
		if(jQuery('#return_table_sent_bat').length>0){
			_load_camps(4,'#return_table_sent_bat');
		}		
	}
);

function _load_camps(type,div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_campaigns_table.php?type="+type,
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(1,rsc_camp_notloaded);
			}else{
				jQuery(div_return).html(data);																		
			}
			

			
		} // fin success
	});
}











// function affichage de graphiques de stats

function draw_graphs(div_target)
{
	if(jQuery('#'+div_target).length>0){
		var chart;
		if(div_target == 'graphik_1')
		{
			
			// cas des recipients
			var title = 'Recipients repartition';
			var sub_title = 'Recipients repartition graph';
			var recipients_val = jQuery('#tbl_stats_recipients').html();
			var filtered_val = jQuery('#tbl_stats_filtered').html();
			var bounces_val = jQuery('#tbl_stats_bounces').html();
			var delivered_val = jQuery('#tbl_stats_delivered').html();
			
			var filtered_percentage = Math.round((filtered_val / recipients_val) *100);
			var bounces_percentage = Math.round((bounces_val / recipients_val) *100);
			var delivered_percentage = Math.round((delivered_val / recipients_val) *100);
			var obj = [
						['Filtered',filtered_percentage],
						['Bounces',bounces_percentage],
						{
							name: 'Delivered',
							y:delivered_percentage,
							sliced: true,
							selected: true
						}
					];
			
		}
		else if(div_target == 'graphik_2') 
		{
			// cas des bounces
			var title = 'Bounces ventilation';
			var sub_title = 'Bounces repartition graph';
			var recipients_val = jQuery('#tbl_stats_recipients').html();
			var bounces_val = jQuery('#tbl_stats_bounces').html();
			var hardbounces_val = jQuery('#tbl_stats_hardbounces').html();
			var softbounces_val = jQuery('#tbl_stats_softbounces').html();
			
			var bounces_percentage = Math.round((bounces_val / recipients_val) *100);
			var hardbounces_percentage = Math.round((hardbounces_val / bounces_val) *100);
			var softbounces_percentage = Math.round((softbounces_val / bounces_val) *100);
			var obj = [
						['softbounces',softbounces_percentage],
						{
							name: 'hardbounces',
							y:hardbounces_percentage,
							sliced: true,
							selected: true
						}
					];
		}
			
		chart = new Highcharts.Chart({
			chart: {
				renderTo: div_target,
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: {
				text: title
			},
			credits:{
				enabled: false
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage}%</b>',
				percentageDecimals: 1
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					
					dataLabels: {
						enabled: true,
						color: '#687884',
						connectorColor: '#000000',
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
						}
					}
				}
			},
			series: [{
				type: 'pie',
				name: sub_title,
				data: obj
			}],
			colors: [
				'#687884', 
				'#8698a6', 
				'#aec0cd'
			],
			exporting:{
				enabled:true
			}
		});
	}else{
		// on a pas de div graph
	}	
}



// function affichage de graphiques de stats
function draw_barchart(div_target)
{
	if(jQuery('#'+div_target).length>0){
	var chart;
	// cas des barcharts
	var title = 'Performance';
	var sub_title = 'Performance : ';
	var recipients_val = jQuery('#tbl_stats_recipients').html();
	var openers_val = jQuery('#tbl_stats_openers').html();
	var openings_val = jQuery('#tbl_stats_openings').html();
	var clickers_val = jQuery('#tbl_stats_clickers').html();
	var clicks_val = jQuery('#tbl_stats_clicks').html();
	var unsubs_val = jQuery('#tbl_stats_unsubs').html();		
	
	var campname = jQuery('#layer_front h2').html();
    campname = campname.replace('<div class="shut">X</div>', '' );
	
	chart = new Highcharts.Chart({
		chart: {
			renderTo: div_target,
			type: 'column'
		},
		title: {
			text: campname+' performance'
		},
		subtitle: {
			text: 'Keys Indicators'
		},
		xAxis: {
			categories: [
				'Recipients',
				'Openers',
				'Openings',
				'Clickers',
				'Clicks',
				'Unsubscriptions'
			]
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Number (recipients)'
			}
		},
		credits:{
			enabled: false
		},
		exporting:{
			enabled:true
		},		
		legend: {
			enabled:false,
			layout: 'vertical',
			backgroundColor: '#FFFFFF',
			align: 'left',
			verticalAlign: 'top',
			x: 100,
			y: 70,
			floating: true,
			shadow: true
		},
		tooltip: {
			formatter: function() {
				return ''+
					this.x +': '+ this.y +'  users';
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [
			{
			name: campname,
			data: [parseInt(recipients_val),parseInt(openers_val),parseInt(openings_val),parseInt(clickers_val),parseInt(clicks_val),parseInt(unsubs_val)]

			}
		],
		colors: [
			'#687884'
		]
	});
	}else{
		// pas de graph
	}	
}









/*
********************************************************
TARGETS
********************************************************
*/



// VUE PARTIELLE TABLEAUX TARGETS

jQuery(document).ready(function()
	{
		if(jQuery('#return_table_targets').length>0){
			_load_targets('#return_table_targets');
		}
	}
);

function _load_targets(div_return)
{
	jQuery(div_return).html('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');
	jQuery.ajax({
		url: "../wp-content/plugins/cheetahmail/ajax/write_targets_table.php",
		success: function(data){
			if(data == -1 || data == -2){
				// erreur on affiche un message et un bouton de rechargement
				show_growl(1,rsc_target_notloaded);
			}else{
				jQuery(div_return).html(data);				
			}			
		} // fin success
	});
}


// gestion de l'affichage ou pas de la valeur à saisir

jQuery('.fld_operator').live('change',function()
{
	var operator = jQuery(this).val();
	if(operator == "NONE" || operator == "FILLED" || operator == "NOTFILLED" ){
		jQuery(this).parent().parent().find('.fld_value').fadeOut('fast');
	}else{
		jQuery(this).parent().parent().find('.fld_value').fadeIn('fast');	
	}	
}
);




// function ajout TARGET

jQuery('#submit_add_target').live('click',function()
{
	jQuery('div.toggelize:last').append('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');

	var ws_name_target = jQuery('#ws_name_target').val();
	var ws_criterias = '';
		
	if(ws_name_target.length>0)
	{
		jQuery('#submit_add_target').parent().fadeOut('fast');
		var co = jQuery('.fld_operator').length;
		ws_criterias += '[';
		jQuery.each(jQuery('.fld_operator'),function(index,value){	
			var id_fld = jQuery(value).parent().parent().attr('title');
			var operator_fld = jQuery(value).val();
			var value_fld = jQuery(value).parent().parent().find('.fld_value').val();
			var type_fld = jQuery(value).parent().parent().find('td').eq(0).find('img').attr('title');
			if(operator_fld != "NONE"){
				// le champ a une valeur on le met en critère
				ws_criterias += '{';
					ws_criterias += '"IdField":"'+id_fld+'",';
					ws_criterias += '"Operation":"'+operator_fld+'",';
					ws_criterias += '"Value":"'+value_fld+'"';					
				ws_criterias += '},';							
			}
		});
		ws_criterias += ']';
		ws_criterias = ws_criterias.replace('},]','}]');
		
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/add_target.php",
			data:{
				description:ws_name_target, 
				criterias:ws_criterias
			},
			 success: function(data){
				if(data == -1 || data == -2){
					// erreur WS
					jQuery('#submit_add_target').parent().fadeIn('fast');
					jQuery('.loading_area').remove();
					show_growl(3,rsc_error);
				}else if(data == 0){
					// success
					jQuery('#ws_name_target').val('');
					jQuery('.fld_operator').val('NONE');
					jQuery('.fld_value').val('');					
					jQuery('#submit_add_target').parent().fadeIn('slow');
					jQuery('.loading_area').remove();
					_load_targets('#return_table_targets');	
					
					// switch to list mode
					jQuery('.heading_elt').removeClass('active');
					jQuery('#elt_1').addClass('active');
					jQuery('.toggelize').fadeOut('slow');
					jQuery('#referred_1').fadeIn('slow');
					
					
					show_growl(2,rsc_target_added);				
				}
				
				
			} // fin success
		});
	}else{
		jQuery('.loading_area').remove();
		show_growl(3,rsc_params_error);
	}	
}
);



// function update TARGET



jQuery('.action_target').live('click',function()
{
	var thi = jQuery(this);
	var id_target = jQuery(this).parent().attr('id');
	var name_target = jQuery('tr[id='+id_target+']').find('td').eq(1).html();	
	var number_target = jQuery('tr[id='+id_target+']').find('td').eq(2).html();	
	var type = jQuery(this).attr('id');
	
	if(type == 'edit')
	{
		jQuery('body').prepend('<div id="layer_back">&nbsp;</div>');jQuery('#layer_back').fadeTo('slow',0.5);
		jQuery('body').prepend('<div id="layer_front"><div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div></div>');jQuery('#layer_front').fadeIn('slow');				
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/write_target_edit_view.php",
			data: { 
				id_target:id_target,
				number_target:number_target,
				name_target:name_target
			},
			 success: function(data){
				jQuery('#layer_front').html(data);				
			}// fin success
		});	
	}
	else if(type == 'view')
	{

		jQuery('body').prepend('<div id="layer_back">&nbsp;</div>');jQuery('#layer_back').fadeTo('slow',0.5);
		jQuery('body').prepend('<div id="layer_front"><div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div></div>');jQuery('#layer_front').fadeIn('slow');				
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/write_target_users_view.php",
			data: { 
				id_target:id_target,
				number_target:number_target,
				name_target:name_target
			},
			 success: function(data){
				// on affiche le layer update
				jQuery('#layer_front').html(data);
			}// fin success
		});	
				
	}
	
}
);	
	
	
	
	
	
	
// function VRAI UPDATE TARGET

jQuery('#submit_update_target').live('click',function()
{

	jQuery('#layer_front div.toggelize').append('<div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div>');

	var ws_name_target = jQuery('#layer_front #ws_name_target').val();
	var ws_id_target = jQuery(this).parent().parent().attr('id');
	var ws_criterias = '';
		
	if(ws_name_target.length>0)
	{
		jQuery('#submit_update_target').parent().fadeOut('fast');
		jQuery('#loading_area_target_update').fadeIn('fast');
		var co = jQuery('#layer_front .fld_operator').length;
		ws_criterias += '[';
		jQuery.each(jQuery('#layer_front .fld_operator'),function(index,value){	
			var id_fld = jQuery(value).parent().parent().attr('title');
			var operator_fld = jQuery(value).val();
			var value_fld = jQuery(value).parent().parent().find('.fld_value').val();
			if(operator_fld != "NONE"){
				// le champ a une valeur on le met en critère
				ws_criterias += '{';
					ws_criterias += '"IdField":"'+id_fld+'",';
					ws_criterias += '"Operation":"'+operator_fld+'",';
					if(operator_fld == "NONE" || operator_fld == "FILLED" || operator_fld == "UNFILLED"){ 
					ws_criterias += '"Value":""';
					}else{
					ws_criterias += '"Value":"'+value_fld+'"';
					}
				ws_criterias += '},';							
			}
		});
		ws_criterias += ']';
		ws_criterias = ws_criterias.replace('},]','}]');
		
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/cheetahmail/ajax/update_target.php",
			data: { 
				idtarget:ws_id_target, 
				criterias:ws_criterias
			},
			 success: function(data){
				if(data == -1 || data == -2){
					// erreur WS
					jQuery('#submit_update_target').parent().fadeIn('fast');
					jQuery('.loading_area').remove();
					show_growl(3,rsc_error);
				}else if(data == 0){
					// success					
					jQuery('#submit_update_target').parent().fadeIn('slow');
					jQuery('.loading_area').remove();
					_load_targets('#return_table_targets');			
					show_growl(2,rsc_target_saved);				
				}
				
				
			} // fin success
		});
	}else{
		show_growl(3,rsc_params_error);
	}	
}
);



	

/*
********************************************************
WYSIWYG
********************************************************
*/

// function ajout de post / article

function get_from_wp(div)
{
	if(jQuery('#articles_from_wp_temp').length == 0){
		jQuery('body').append('<div id="articles_from_wp_temp" style="display:none"></div>');		
	}

	jQuery('body').append('<div class="layer_back_overlay"></div>');
	jQuery('.layer_back_overlay').fadeTo('slow',0.5);
	jQuery('body').append('<div class="layer_front_overlay" id="'+div+'"><br /><div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div></div>');	
	
	
	if(jQuery('#articles_from_wp_temp').html().length == 0){
		// on va rechercher son contenu	
		jQuery.ajax({
			url: "../wp-content/plugins/cheetahmail/ajax/list_wp_articles.php",
			success: function(data){
				// on affiche le layer update
				if(data==-1){
					// return 'No content, please <a href="#">reload</a>';
				}else{	
					var t ='<h2> '+ rsc_wy_add_article +'<div class="shut_layer_richtext">X</div></h2>';
						t += '<div class="search_article">';
							t += '<label for="search_value_articles"><img src="../wp-content/plugins/cheetahmail/img/_magnify_off.png" /> </label><input type="text" id="search_value_articles" value="" />';
						t += '</div>';
						t += '<div class="list_articles">';
							t += data;	
						t += '</div>';							
					jQuery('#articles_from_wp_temp').html(t);
					var html_list = jQuery('#articles_from_wp_temp').html();
					jQuery('.layer_front_overlay').html(html_list);
				}
			}
		});	
		
	}else{
		// les contenus ont déjà été chargés
		var html_list = jQuery('#articles_from_wp_temp').html();		
		jQuery('.layer_front_overlay').html(html_list);		
	}

	
}




// fonction de recherche dans les articles wordpress

jQuery('#search_value_articles').live('focus blur keyup keydown',function()
{
	var search_item = jQuery(this).val();
	if(search_item.length>0){
		jQuery(this).parent().parent().find('.element_wp_to_add').css('display','none');
		jQuery(this).parent().parent().find('.element_wp_to_add:contains("'+search_item+'")').css('display','block');
	}else{
		jQuery(this).parent().parent().find('.element_wp_to_add').css('display','block');
	}			
}
);





// AJOUT ARTICLE AU RICH TEXT ADITOR

jQuery('.element_wp_to_add').live('click',function()
{
	var content_item = jQuery(this).find('.full_content').val();
	var name_div = jQuery(this).parent().parent().attr('id');	
	CKEDITOR.instances[name_div].insertHtml(content_item);
	show_growl(2,rsc_wy_elt_added);	
			
}
);










// function desaffichage du layer wysiwyg
jQuery('.shut_layer_richtext').live('click',function()
{
	jQuery('.layer_back_overlay').remove();
	jQuery('.layer_front_overlay').remove();	
}
);






// function ajout de post / article

function get_user_field(div)
{
	if(jQuery('#userfield_temp').length == 0){
		jQuery('body').append('<div id="userfield_temp" style="display:none"></div>');		
	}

	jQuery('body').append('<div class="layer_back_overlay"></div>');
	jQuery('.layer_back_overlay').fadeTo('slow',0.5);
	jQuery('body').append('<div class="layer_front_overlay" id="'+div+'"><br /><div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div></div>');	
	
	if(jQuery('#userfield_temp').html().length == 0){
		// on va rechercher son contenu	
		jQuery.ajax({
			url: "../wp-content/plugins/cheetahmail/ajax/list_userfields.php",
			success: function(data){
				// on affiche le layer update
				if(data==-1){
					return 'An error occured, please <a href="#">reload</a>';
				}else{	
					var t ='<h2> '+ rsc_wy_add_userfield +' <div class="shut_layer_richtext">X</div></h2>';
						t += '<div class="search_userfield">';
							t += '<label for="search_value_userfield"><img src="../wp-content/plugins/cheetahmail/img/_magnify_off.png" /> </label><input type="text" id="search_value_userfield" value="" />';
						t += '</div>';
						t += '<div class="list_userfields">';
							t += data;	
						t += '</div>';							
					jQuery('#userfield_temp').html(t);
					var html_list = jQuery('#userfield_temp').html();
					jQuery('.layer_front_overlay').html(html_list);
				}
			}
		});	
		
	}else{
		// les contenus ont déjà été chargés
		var html_list = jQuery('#userfield_temp').html();		
		jQuery('.layer_front_overlay').html(html_list);		
	}

	
}





// fonction de recherche dans les user fields to add

jQuery('#search_value_userfield').live('focus blur keyup keydown',function()
{
	var search_item = jQuery(this).val();
	if(search_item.length>0){
		jQuery(this).parent().parent().find('tr').css('display','none');
		jQuery(this).parent().parent().find('td:contains("'+search_item+'")').parent().fadeIn('slow');
	}else{
		jQuery(this).parent().parent().find('.tr').css('display','block');
	}			
}
);





// AJOUT ARTICLE AU RICH TEXT ADITOR

jQuery('#submit_add_usrfield').live('click',function()
{
	var id_item = jQuery(this).parent().parent().parent().find('td').eq(0).html();
	var format_item = jQuery(this).parent().parent().parent().find('.u_format').val();
	var default_item = jQuery(this).parent().parent().parent().find('.u_default').val();
	
	
	// on tests si FLD1 alors pas de valeur oar défaut.
	if(id_item == 1){
		var content_item = '$U('+id_item+')';
	}else{
		if(format_item=="0"){
			var content_item = '$U('+id_item+',"'+default_item+'")';
		}else{
			var content_item = '$U('+id_item+',"'+default_item+'","'+format_item+'")';			
		}
	}
	var name_div = jQuery(this).parent().parent().parent().parent().parent().parent().parent().attr('ID');
	// console.log(name_div);	
	CKEDITOR.instances[name_div].insertHtml(content_item);
	show_growl(2,rsc_wy_fld_added);	
			
}
);









// function ajout d'image

function get_images_from_wp(div)
{
	if(jQuery('#img_from_wp_temp').length == 0){
		jQuery('body').append('<div id="img_from_wp_temp" style="display:none"></div>');		
	}

	jQuery('body').append('<div class="layer_back_overlay"></div>');
	jQuery('.layer_back_overlay').fadeTo('slow',0.5);
	jQuery('body').append('<div class="layer_front_overlay" id="'+div+'"><br /><div class="loading_area"><div class="loading_spinner"><img src="../wp-content/plugins/cheetahmail/img/layer-loader.gif" /></div></div></div>');	
	
	
	if(jQuery('#img_from_wp_temp').html().length == 0){
		// on va rechercher son contenu	
		jQuery.ajax({
			url: "../wp-content/plugins/cheetahmail/ajax/list_img_from_wp.php",
			success: function(data){
				// on affiche le layer update
				if(data==-1){
					// return 'An error occured, please <a href="#">reload</a>';
				}else{	
					var t ='<h2> '+ rsc_wy_add_img +' <div class="shut_layer_richtext">X</div></h2>';
						t += '<div class="list_img_from_wp">';
							t += data;	
						t += '</div>';							
					jQuery('#img_from_wp_temp').html(t);
					var html_list = jQuery('#img_from_wp_temp').html();
					jQuery('.layer_front_overlay').html(html_list);
				}
			}
		});	
		
	}else{
		// les contenus ont déjà été chargés
		var html_list = jQuery('#img_from_wp_temp').html();		
		jQuery('.layer_front_overlay').html(html_list);		
	}

	
}



// AJOUT IMAGE AU RICH TEXT EDITOR

jQuery('.bloc_img_wp').live('click',function()
{
	var id_item = jQuery(this).attr('id');
	var src_item = jQuery(this).find('img').attr('src');
	var content_item = '<img src="'+src_item+'" />';
	var name_div = jQuery(this).parent().parent().attr('id');	
	CKEDITOR.instances[name_div].insertHtml(content_item);
	show_growl(2,rsc_wy_img_added);				
}
);







// gestion des readonly enlevés au doubleclik

jQuery('#prefix_target, #prefix_nl, #prefix_email, #prefix_bat, #ws_html_body, #ws_txt_body').live('dblclick',function(){
	jQuery(this).removeAttr('readonly');
});


// cas de la partie API dans paramètress
jQuery('#idmlist, #ws_login, #ws_password').live('dblclick',function(){
	jQuery(this).removeAttr('readonly');
	if(!jQuery('#idmlist').attr('readonly') && !jQuery('#ws_login').attr('readonly') && !jQuery('#ws_password').attr('readonly') ){
		jQuery('#submit_change_api_key').removeAttr('disabled');
	}
	
	
});




