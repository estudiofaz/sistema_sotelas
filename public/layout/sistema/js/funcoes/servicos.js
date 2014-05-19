$(document).ready(function(){
    //inicio do autocomplete
	var ulr = jQuery('#url').val();
	var clientes = new Array();	

	
function verificaNumero(e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
}
	
function Person(label, value, id){

	    
		this.label = label;
	    this.value = value;
	    this.id = id;

	}
	
	$.ajax({
        type:'JSON',
        url: ulr+'/sistema/ajax/clientes',
        
        success: function(response) {
           // alert(response);
            var felipe = eval(response);
            
            for(i=0;i<felipe.length;i++){
            	clientes.push(new Person(felipe[i].label, felipe[i].value, felipe[i].id));
            }
            //alert(clientes);
        },
        error: function(resp) {
            alert(resp.responseText);
            alert('erro');
        }
    });	
		
		$("#autocomplete" ).autocomplete({ 
			source: clientes,
			select: function (event, ui) {
				$('#divModal').hide();
           	  var teste = ui.item.id;
		           	$.ajax({
		    	        type:'JSON',
		    	        url: ulr+'/sistema/ajax/cliente/id/'+ui.item.id,
		    	        
		    	        success: function(response) {
		    	            
		    	            var felipe = eval(response);
		    	            
		    	            $('#endereco').val(felipe[0].nm_endereco);
		    	            $('#bairro').val(felipe[0].nm_bairro);
		    	            $('#cidade').val(felipe[0].nm_cidade);
		    	           
		    	            $('#co_cliente').val(felipe[0].idCliente);
		    	            $('#telefone1').val(felipe[0].telefone1);
		    	            $('#telefone2').val(felipe[0].telefone2);
		    	            $('#telefone3').val(felipe[0].telefone3);
		    	            $("#estado").val(felipe[0].nm_estado);
		    	            
		    	        },
		    	        error: function(resp) {
		    	            alert(resp.responseText);
		    	            alert('erro');
		    	        }
		    	    });
            	 
            	 
            	  
              } 
			
		
		
	});

	// fim autocomplete
		
		
		
		$('#autocomplete').keyup(function(){
			 
			 
			$('#endereco').val('');
            $('#bairro').val('');
            $('#cidade').val('');
           
            $('#co_cliente').val('');
            $('#telefone1').val('');
            $('#telefone2').val('');
            $('#telefone3').val('');
            $("#estado").val('');
			
			
		});		
		
	$('#autocomplete').focusout(function(){
		 
		 if($('#co_cliente').val() == '' ){
			 
			 $('#divModal').show();
		 }
		
		
		
	});	
	
	$("#modal").fancybox({
        helpers: {
            title : {
                type : 'float'
            }
        }
    });
		
	
	
	// data orçamento
	
	$(".calendario").datepicker({
	    dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior'
	});
	
	
	// funcionario horarios
	
	$('.calendario').focusout(function(){
		
		
		$('#funcionario').val('');
		$('#horario').val('');
		$('#horario').prop('disabled', true);
	});
	
	$('#funcionario').change(function(){
		 var id = $(this).val()
		 var data = $("#dt_orcamento").val()
		 var array =  data.split("/");
		 var dataCorreta = array[2]+'-'+array[1]+'-'+array[0];
		 //alert(dataCorreta);
		$.ajax({
	        type:'JSON',
	        url: ulr+'/sistema/ajax/servico/idFuncionario/'+id+'/dt_orcamento/'+dataCorreta,
	        
	        success: function(response) {
	           // alert(response);
	            var felipe = eval(response);
	            
	            jQuery("#horario option").remove();
				$('#horario').prop('disabled', false);
				jQuery('<option/>').val(null).html('-- Horarios disponiveis --').appendTo("#hoario");

				for(i = 0; i < felipe.length; i++){
					
					if(felipe[i] != 'ocupado'){
					jQuery('<option/>').val(felipe[i]).html(felipe[i]).appendTo("#horario");
					}
					
				}			
	        },
	        error: function(resp) {
	            alert(resp.responseText);
	            alert('erro');
	        }
	    });	
		
	});
	
	
	
	//peças

	$('#peca').change(function(){
		
		var idProduto = $(this).val();
		
		$.ajax({
	        type:'JSON',
	        url: ulr+'/sistema/ajax/produto/idProduto/'+idProduto,
	        
	        success: function(response) {
	           // alert(response);
	            var felipe = eval(response);
	            
	            	$('#valor_peca').val(felipe[0].nu_preco);
	        },
	        error: function(resp) {
	            alert(resp.responseText);
	            alert('erro');
	        }
	    });	
		
		
		
	});
	

	// somente numeros
	
	$(".numeros").keypress(verificaNumero);
	
	// calculo valor total
	
	
	$("#qdt_pecas").focusout(function(){
		var valor = $("#valor_peca").val();
		var  quantidade = $("#qdt_pecas").val();
		var largura = $("#largura").val();
		var altura = $('#altura').val();
		
		$('#valor_total').val((largura*altura)*(quantidade* valor));
		
	});
	
	$("#largura").focusout(function(){
		var valor = $("#valor_peca").val();
			var  quantidade = $("#qdt_pecas").val();
			var largura = $("#largura").val();
			var altura = $('#altura').val();
			
			$('#valor_total').val((largura*altura)*(quantidade* valor));
			
		});
	
	$("#altura").focusout(function(){
		var valor = $("#valor_peca").val();
		var quantidade = $("#qdt_pecas").val();
		var largura = $("#largura").val();
		var altura = $('#altura').val();
		
		$('#valor_total').val((largura*altura)*(quantidade* valor));
		
	});
	
	
	// clonar peça
	
	$('.botao').click(function(){
		
		$('.clone').clone().insertAfter(this);
		
		
	});
		
		
    
 });