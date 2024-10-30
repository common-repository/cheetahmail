/*
*******************************************************************************************
FONCTIONS PLUGIN CHEETAHMAIL FRONTEND
*******************************************************************************************
*/



// function pour empêcher les échappements dans la structure de bdd

jQuery('.fld').live('keydown focus keyup',function()
{
	var t = jQuery(this).val();
	t = t.replace('"','');
	// t = t.replace('\'','');
	jQuery(this).val(t);		
}
);

	
	
	
// lancement des datepickers
jQuery(document).ready(function(){
	jQuery('.datepicker').datepicker({dateFormat : 'yy-mm-dd'});
});

// lancement des numerics
jQuery('.numeric').live('keyup',function()
{
	var val = parseInt(jQuery(this).val());
	if(isNaN(val)){
		val="";
	}
	jQuery(this).val(val);
}
);

// function ajout USERS
jQuery('#cheetahmail_form_submit').live('click',function()
{
	jQuery('#cheetahmail_form_submit').parent().fadeOut('slow');
	jQuery('#cheetahmail_form').append('<div class="loading_area"><div class="loading_spinner"><span class="img_spinner">&nbsp;</span></div></div>');

	if(jQuery('.fld').length>1){
		var c = parseInt(jQuery('.fld').length)-1;
	}
	var tab = '';

	tab += '{';

	jQuery.each(jQuery('.fld'),function(index,value){
		var g = '';		
		var id_fld = jQuery(value).attr('id').split('_')[1];
		var val_fld = jQuery(value).val();
		var attr_fld = jQuery(value).attr('title');	
		var type_fld = attr_fld.split('||')[0];		
		var format_fld = attr_fld.split('||')[1];		
		g += '';
		
					 
		 
		if(type_fld == 2)
		{
			// date
			val_fld = val_fld.replace(" ","T");	
			if(val_fld.length<1){}
			else if(val_fld.length<=10){
				val_fld = val_fld+'T00:00:00';
				g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'","format_fld":"'+format_fld+'"}';	
				if(index < c){g +=',';}						
			}
			else
			{
				g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'","format_fld":"'+format_fld+'"}';	
				if(index < c){g +=',';}	
			}
				
		}else if(type_fld == 5){
				val_fld = jQuery(value).find('option:selected').val();
				g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'","format_fld":"'+format_fld+'"}';	
				if(index < c){g +=',';}				
		}
		else
		{
		
			g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'","format_fld":"'+format_fld+'"}';		
			if(index < c){
				g +=',';
			}	
		}		
		tab += g;
	});		
	tab += '}';


var baseUrl = jQuery('#cheetahmail_form').attr('title');
	
	jQuery.ajax({
		url: baseUrl + "/wp-content/plugins/cheetahmail/shortcodes/insert_user.php",
		type:"post",
		data : {post_values:tab},
		success: function(d) {		
			jQuery('.fld[type="text"]').val('');
			jQuery('#cheetahmail_form').append(d);
			jQuery('#cheetahmail_form_submit').parent().fadeIn('slow');
			jQuery('.loading_area').remove() ;
			setTimeout(function(){
				jQuery('.cm_msg').remove();
			},5000);		
		}
	});
}
);



// function modification USERS

jQuery('#cheetahmail_form_update_submit').live('click',function()
{
	jQuery('#cheetahmail_form_submit').parent().fadeOut('slow');
	jQuery('#cheetahmail_form').append('<div class="loading_area"><div class="loading_spinner"><span class="img_spinner">&nbsp;</span></div></div>');

	if(jQuery('.fld').length>1){
		var c = parseInt(jQuery('.fld').length)-1;
	}
	var tab = '';

	tab += '{';

	jQuery.each(jQuery('.fld'),function(index,value){
		var g = '';		
		var id_fld = jQuery(value).attr('id').split('_')[1];
		var val_fld = jQuery(value).val();
		var attr_fld = jQuery(value).attr('title');	
		var type_fld = attr_fld.split('||')[0];		
		var format_fld = attr_fld.split('||')[1];		
		g += '';
		
					 
		 
		if(type_fld == 2)
		{
			// date
			val_fld = val_fld.replace(" ","T");	
			if(val_fld.length<1){}
			else if(val_fld.length<=10){
				val_fld = val_fld+'T00:00:00';
				g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'","format_fld":"'+format_fld+'"}';	
				if(index < c){g +=',';}						
			}
			else
			{
				g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'","format_fld":"'+format_fld+'"}';	
				if(index < c){g +=',';}	
			}
				
		}else if(type_fld == 5){
				val_fld = jQuery(value).find('option:selected').val();
				g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'","format_fld":"'+format_fld+'"}';	
				if(index < c){g +=',';}				
		}
		else
		{
		
			g +=  '"'+id_fld+'":{"id_fld":"'+id_fld+'","val_fld":"'+val_fld+'","type_fld":"'+type_fld+'","format_fld":"'+format_fld+'"}';		
			if(index < c){
				g +=',';
			}	
		}		
		tab += g;
	});		
	tab += '}';


	var baseUrl = jQuery('#cheetahmail_form').attr('title');
	
	jQuery.ajax({
		url: baseUrl + "/wp-content/plugins/cheetahmail/shortcodes/insert_user.php",
		type:"post",
		data : {post_values:tab},
		success: function(d) {		
			jQuery('#cheetahmail_form').append(d);
			jQuery('#cheetahmail_form_submit').parent().fadeIn('slow');
			jQuery('.loading_area').remove();
			setTimeout(function(){
				jQuery('.cm_msg').remove();
			},5000);		
		}
	});
}
);


