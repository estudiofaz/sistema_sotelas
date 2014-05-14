<?php 
class Zend_View_Helper_SetupEditor {

	function setupEditor ($textareaId){
	
		/*
		return "< script type=\"text/javascript\">
	    	CKEDITOR .replace ( '" . $textareaId . "' );
	        	< / script >";
		*/
		
		return "<script>
			     window.onload = function() {
			        CKEDITOR.replace( 'editor1', {
			        language: 'pt-br',
		        		        
                    filebrowserBrowseUrl 		: '../layout/adm/ckeditor/kcfinder/browse.php?type=files',
                    filebrowserImageBrowseUrl 	: '../layout/adm/ckeditor/kcfinder/browse.php?type=images',
                    
                    filebrowserUploadUrl 		: '../layout/adm/ckeditor/kcfinder/upload.php?type=files',
                    filebrowserImageUploadUrl 	: '../layout/adm/ckeditor/kcfinder/upload.php?type=images'
		            
					});
			      };
      			</script>";
	}

}

?>