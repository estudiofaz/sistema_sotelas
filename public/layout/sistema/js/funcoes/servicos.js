$(document).ready(function(){
    //inicio do autocomplete
	var ulr = jQuery('#url').val();
	var clientes = new Array();	

	
Number.prototype.formatMoney = function(c, d, t){
		var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
		   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		};
	
function verificaNumero(e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
}

$(".metros").maskMoney({thousands: '.', decimal: '.'});
	
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
	
	
	// funcionario horarios orçamento
	
	$('.calendario_orcamento').focusout(function(){
		
		
		$('#funcionario_orcamento').val('');
		$('#horario_orcamento').val('');
		$('#horario_orcamento').prop('disabled', true);
	});
	
	$('#funcionario_orcamento').change(function(){
		 var id = $(this).val()
		 var data = $("#dt_orcamento").val()
		 var array =  data.split("/");
		 var dataCorreta = array[2]+'-'+array[1]+'-'+array[0];
		 //alert(dataCorreta);
		$.ajax({
	        type:'JSON',
	        url: ulr+'/sistema/ajax/servico/idFuncionario/'+id+'/data/'+dataCorreta,
	        
	        success: function(response) {
	           // alert(response);
	            var felipe = eval(response);
	            
	            jQuery("#horario_orcamento option").remove();
				$('#horario_orcamento').prop('disabled', false);
				jQuery('<option/>').val(null).html('-- Horarios disponiveis --').appendTo("#horario_orcamento");

				for(i = 0; i < felipe.length; i++){
					
					if(felipe[i] != 'ocupado'){
					jQuery('<option/>').val(felipe[i]).html(felipe[i]).appendTo("#horario_orcamento");
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
	var valorTotal =0;
	var valorParcial =0;
	
	$("#qdt_pecas").keyup(function(){
		var valor =  parseFloat($("#valor_peca").val());
		var  quantidade =  parseInt($("#qdt_pecas").val());
		var largura =  parseFloat($("#largura").val());
		var altura =  parseFloat($('#altura').val());
		valorParcial =  parseFloat((((largura * altura )* valor)*(quantidade )));
		$('#valor_total').val(valorParcial);
		
		$('#valor_total_orcamento').val(parseFloat(valorParcial) + parseFloat(valorTotal));
		
	});
	
	$("#largura").keyup(function(){
		var valor =  parseFloat($("#valor_peca").val());
			var  quantidade =  parseInt($("#qdt_pecas").val());
			var largura =  parseFloat($("#largura").val());
			var altura =  parseFloat($('#altura').val());
			
			valorParcial =  parseFloat((((largura * altura )* valor)*(quantidade )));
			$('#valor_total').val(valorParcial);
			$('#valor_total_orcamento').val(parseFloat(valorParcial) + parseFloat(valorTotal));
			
		});
	
	$("#altura").keyup(function(){
		var valor = parseFloat($("#valor_peca").val());
		var quantidade = parseInt($("#qdt_pecas").val());
		var largura = parseFloat($("#largura").val());
		var altura = parseFloat($('#altura').val());
		
		valorParcial = parseFloat((((largura * altura )* valor)*(quantidade )));
		$('#valor_total').val(valorParcial);
		$('#valor_total_orcamento').val(parseFloat(valorParcial) + parseFloat(valorTotal));
		
	});
	
	
	// clonar peça
	
	var i=0;
	$('.botao').click(function(){
		
		if(($('.peca').val()!= '') && ($('.valorPeca').val()!= '') && ($('.corPeca').val()!= '') && ($('.qdt_pecas').val()!= '')
				&& ($('.altura').val()!= '') && ($('.largura').val()!= '')&& ($('.valor_total').val()!= '')){
				i++;
				$('<div>',{
					
					id:'novoProduto'+i,
					
				}).appendTo('.dados');
				var peca = $('#peca').val();
				var produto = $('.peca').clone().appendTo('#novoProduto'+i);
				produto.val(peca);
				produto.prop('disabled', true);
				produto.removeClass('peca');
				var precoPeca = $('#valor_peca').val();
				var valorPeca = $('.valorPeca').clone().appendTo('#novoProduto'+i);
				valorPeca.prop('disabled', true);
				valorPeca.removeClass('valorPeca');
				var valorCor= $('#cor').val();
				var cor = $('.corPeca').clone().appendTo('#novoProduto'+i);
				cor.val(valorCor);
				cor.prop('disabled', true);
				cor.removeClass('corPeca');
				cor.addClass('cloneCor');
				var quantidadePecas = $('#qdt_pecas').val();
				var qdt_pecas = $('.qdt_pecas').clone().appendTo('#novoProduto'+i);
				qdt_pecas.val(quantidadePecas);
				qdt_pecas.prop('disabled', true);
				qdt_pecas.removeClass('qdt_pecas');
				qdt_pecas.addClass('cloneQuantidade');
				var valorAltura = $('#altura').val();
				var altura = $('.altura').clone().appendTo('#novoProduto'+i);
				altura.val(valorAltura);
				altura.prop('disabled', true);
				altura.removeClass('altura');
				altura.addClass('cloneAltura');
				var valorLargura =$('#largura').val();
				var largura = $('.largura').clone().appendTo('#novoProduto'+i);
				largura.val(valorLargura);
				largura.prop('disabled', true);
				largura.removeClass('lagura');
				largura.addClass('cloneLargura');
				var valor_valorTotal = $('#valor_total').val();
				var valor_Total = $('.valor_total').clone().appendTo('#novoProduto'+i);
				valor_Total.val(valor_valorTotal);
				valor_Total.prop('disabled', true);
				valor_Total.removeClass('valor_total');
				valor_Total.addClass('cloneValorTotal');
				
				
				$('<input>',{
					
					class: 'btn btn-primary remover',
					value: 'Remover',
					type: 'button',
					
					click: function(){
						var removido = $(this).prev('#valor_total').val();
						
						valorTotal = (valorTotal - removido);
						
						
						$('#valor_total_orcamento').val(valorTotal);
						$(this).parent().remove();
					}
				}).appendTo('#novoProduto'+i);
		
				
				valorTotal = parseFloat($('#valor_total_orcamento').val());
				
				$('#peca').val('');
				$('#valor_peca').val('');
				$('#cor').val('');
				$('#qdt_pecas').val('');
				$('#altura').val('');
				$('#largura').val('');
				$('#valor_total').val('');
				
		
		}
		
		
		
		
	});
	
	
	
	// dados da instalação
	$('.calendario_instalacao').focusout(function(){
		
		
		$('#funcionario_instalacao').val('');
		$('#horario_instalacao').val('');
		$('#horario_instalacao').prop('disabled', true);
	});
	
	$('#funcionario_instalacao').change(function(){
		 var id = $(this).val()
		 var data = $("#dt_instalacao").val()
		 var array =  data.split("/");
		 var dataCorreta = array[2]+'-'+array[1]+'-'+array[0];
		 //alert(dataCorreta);
		$.ajax({
	        type:'JSON',
	        url: ulr+'/sistema/ajax/servico/idFuncionario/'+id+'/data/'+dataCorreta,
	        
	        success: function(response) {
	           // alert(response);
	            var felipe = eval(response);
	            
	            jQuery("#horario_instalacao option").remove();
				$('#horario_instalacao').prop('disabled', false);
				jQuery('<option/>').val(null).html('-- Horarios disponiveis --').appendTo("#horario_instalacao");

				for(i = 0; i < felipe.length; i++){
					
					if(felipe[i] != 'ocupado'){
					jQuery('<option/>').val(felipe[i]).html(felipe[i]).appendTo("#horario_instalacao");
					}
					
				}			
	        },
	        error: function(resp) {
	            alert(resp.responseText);
	            alert('erro');
	        }
	    });	
		
	});
		
		
    
 });