/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */


	CKEDITOR.editorConfig = function( config ) {
		// Define changes to default configuration here. For example:
		// config.language = 'fr';
		// config.startupMode = 'source';
		config.toolbar = 'Full';
		config.toolbar_Full = [
			{ name: 'clipboard', items : [ 'Source','-','PasteText','PasteFromWord','-','Undo','Redo','-', 'RemoveFormat' ] },
			// { name: 'clipboard', items : [ 'Source','-', 'Cut','Copy','Paste','PasteText','PasteFromWord','-','-','Undo','Redo','-', 'RemoveFormat' ] },
			{ name: 'insert', items : [ 'Link','Unlink','Anchor', 'Image','Table','HorizontalRule','SpecialChar' ] },		
			{ name: 'WordPress', items : [ 'addFromWP' ,'addPersoFromWP' ,'addImgFromWP','addMirrorPage'] },		
			'/',
			{ name: 'basicstyles', items : [ 'Bold','Italic','Underline', 'Font','FontSize','TextColor','BGColor','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Strike','Subscript','Superscript' ] },
			{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ] }
		];
		if(document.location.href.indexOf('subscriptions') == -1){
		config.extraPlugins = 'addFromWP,addPersoFromWP,addImgFromWP,addMirrorPage';
		}else{
		config.extraPlugins = 'addFromWP,addPersoFromWP,addImgFromWP';
		}
	};

	
	
	// ajout de la page mirroir
	CKEDITOR.plugins.add('addMirrorPage',
	{
		init: function(editor)
		{
			var pluginName = 'addMirrorPage';
			editor.ui.addButton('addMirrorPage',
			{
				label: 'Add mirror page link',
				command: pluginName
			});
			
			editor.addCommand('addMirrorPage',
			{
				exec : function( editor )
				{  
					CKEDITOR.currentInstance.insertHtml('$H(1)');	
				}
			});
			
		}
	});
	
	
	
	// ajout d'articles de worpress
	CKEDITOR.plugins.add('addFromWP',
	{
		init: function(editor)
		{
			var pluginName = 'addFromWP';
			editor.ui.addButton('addFromWP',
			{
				label: 'Add a Post/Page content',
				command: pluginName
			});
			
			editor.addCommand('addFromWP',
			{
				exec : function( editor )
				{  
					var my_instance = CKEDITOR.currentInstance.name;
					get_from_wp(my_instance);	
					// console.log('get_from_wp : ' + my_instance)					
				}
			});
			
		}
	});

	// ajout de perso
	CKEDITOR.plugins.add('addPersoFromWP',
	{
		init: function(editor)
		{
			var pluginName = 'addPersoFromWP';
			editor.ui.addButton('addPersoFromWP',
			{
				label: 'Add a user field',
				command: pluginName
			});
			
			editor.addCommand('addPersoFromWP',
			{
				exec : function( editor )
				{  
					var my_instance = CKEDITOR.currentInstance.name;
					get_user_field(my_instance);				
					// console.log('get_from_wp : ' + my_instance)					
				}
			});
			
		}
	});


	// ajout d'une image de wordpress
	CKEDITOR.plugins.add('addImgFromWP',
	{
		init: function(editor)
		{
			var pluginName = 'addImgFromWP';
			editor.ui.addButton('addImgFromWP',
			{
				label: 'Add an image from wp',
				command: pluginName
			});
			
			editor.addCommand('addImgFromWP',
			{
				exec : function( editor )
				{  
					var my_instance = CKEDITOR.currentInstance.name;
					get_images_from_wp(my_instance);				
					// console.log('get_from_wp : ' + my_instance)					
				}
			});
			
		}
	});
	