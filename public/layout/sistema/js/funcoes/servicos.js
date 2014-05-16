$(document).ready(function(){
    //inicio do autocomplete
	var ulr = jQuery('#url').val();
	var clientes = new Array();	
	
	$.ajax({
        type:'JSON',
        url: ulr+'/sistema/ajax/clientes',
        
        success: function(response) {
            
            var felipe = eval(response);
            
            
            for(i=0;i<felipe.length;i++){
            	
       		 clientes.push(felipe[i].nome);
       		 
       	 }
            
        },
        error: function(resp) {
            alert(resp.responseText);
            alert('erro');
        }
    });	
		
		$("#autocomplete" ).autocomplete({ 
			source: clientes
			
		
		
	});

	// fim autocomplete
		
		//inicio do clinte especifico
	$('#autocomplete').focusout(function(){
		 
		 
		$.ajax({
	        type:'JSON',
	        url: ulr+'/sistema/ajax/cliente/nome/'+$(this).val(),
	        
	        success: function(response) {
	            
	            var felipe = eval(response);
	            
	            if(felipe != ''){
		            jQuery('#endereco').val(felipe[0].nm_endereco+" - "+felipe[0].nm_bairro);
		            jQuery('#idAjax').val(felipe[0].idCliente);
		            jQuery('#divModal').hide();
	            }else{
	            	$('#autocomplete').val('');
	            	 jQuery('#endereco').val('');
	            	jQuery('#divModal').show();
	            }
	            
	        },
	        error: function(resp) {
	            alert(resp.responseText);
	            alert('erro');
	        }
	    });
		
		
	});	
		
		
		
    
 });