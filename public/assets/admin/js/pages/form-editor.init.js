
var elements = $( '.ckeditor-classic' );
elements.each( function() {
    ClassicEditor.create(this,{removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed']}).then(function(e){e.ui.view.editable.element.style.height="200px"}).catch(function(e){console.error(e)});
} );
