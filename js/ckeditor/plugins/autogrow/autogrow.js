(function()
{
   CKEDITOR.plugins.autogrow =
   {
      getHeightDelta : function( editor )
      {
         var contents = CKEDITOR.document.getById( 'cke_contents_' + editor.name );
         var outer = contents.getAscendant( 'table' ).getParent().getParent().getParent();
     
         // Get the height delta between the outer table and the content area.
         var delta =  ( outer.$.offsetHeight || 0 ) - ( contents.$.clientHeight || 0 );
         return delta;
      },
     
      getEffectiveHeight : function( height, maxheight, minheight, padding )
      {
         var totalheight = parseInt(height,10) + parseInt(padding,10);
         if ( totalheight < minheight )
            totalheight = minheight;
         else
         {
            if ( maxheight && maxheight > 0 && totalheight > maxheight )
               totalheight = maxheight;
         }
     
         return totalheight;
      }
   };
   function checkSize ( evt )
   {
      var editor = evt.editor;
      var delta = plugin.getHeightDelta(editor) ;
      var maxheight = editor.config.autogrow_maxheight  ;
      var minheight = editor.config.autogrow_minheight ;
      var padding = editor.config.autogrow_padding ;
      var $body = editor.document.$.body;
      var newHeight = delta + $body.offsetHeight;
      //add a little padding as sometimes it just doesn't go big enough
      //especially if you remove Plugin resize
      newHeight = plugin.getEffectiveHeight( newHeight , maxheight, minheight, padding );
      var contents = CKEDITOR.document.getById( 'cke_contents_' + editor.name );
      newHeight = Math.max( newHeight, 0 ) + 'px';
      if(contents.getStyle('height') != newHeight)
      {
         contents.setStyle( 'height', newHeight );
      }
   };
      
   var plugin = CKEDITOR.plugins.autogrow;
   
   CKEDITOR.plugins.add( 'autogrow',
   {
      init : function( editor )
      {
               editor.on( 'insertHtml', checkSize );
               editor.on( 'insertElement', checkSize );
               editor.on( 'selectionChange', checkSize );
               editor.on( 'instanceReady', checkSize );
      }
   } );
})();

CKEDITOR.config.autogrow_maxheight=0;
CKEDITOR.config.autogrow_minheight=50;
CKEDITOR.config.autogrow_padding = 30;