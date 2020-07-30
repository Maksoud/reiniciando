/**
 * Desenvolvido por:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

(function ($) {
    $(document).ready(function ($) {

        var context = $('#logo').attr('data-url'),
                url = context + 'movements/json/';
		
        ////////////////////////////////////////////////////////////////////////
		
        $.getJSON(url, function(data){
			
			console.log(data);
			
            var moviments	       = Object(data.moviments),
				movimentMergeds    = data.movimentMergeds,
				movimentRecurrents = data.movimentRecurrents,
                qtd_moviments 	   = moviments.length,
                retorno     	   = '';
			
			console.log(moviments);
			
            if ( qtd_moviments > 0 ) {
				
                for ( var cont_x = 0; cont_x < qtd_moviments; cont_x++ ) {
					
					var status = '';
					
					//Verifica o status do registro
					if (moviments[cont_x]['status'] === 'A') { 
						status = 'Aberto';
					} else if (moviments[cont_x]['status'] === 'B') { 
						status = 'Finalizado';
					} else if (moviments[cont_x]['status'] === 'C') { 
						status = 'Cancelado';
					} else if (moviments[cont_x]['status'] === 'G') { 
						status = 'Agrupado';
					} else if (moviments[cont_x]['status'] === 'V') { 
						status = 'Vinculado';
					} else if (moviments[cont_x]['status'] === 'O') { 
						status = 'B.Parcial';
					} else if (moviments[cont_x]['status'] === 'P') { 
						status = 'Parcial';
					}
					
					/////////////////////////////////////////////////////////////////////////
					
					var clieforn = '';
					
					if (moviments[cont_x]['creditodebito'] === 'C') {
						clieforn = moviments[cont_x]['Customers']['title'];
					} else if (moviments[cont_x]['creditodebito'] === 'D') {
						clieforn = moviments[cont_x]['Providers']['title'];
					}
					
					/////////////////////////////////////////////////////////////////////////
					
					//Prepara o retorno
                    retorno += '<tr class="initialism">';
						
						retorno += '<td>' + moviments[cont_x]['ordem'] + '</td>';
						retorno += '<td>' + moviments[cont_x]['documento'] + '</td>';
						retorno += '<td>' + moviments[cont_x]['data'] + '</td>';
						retorno += '<td>' + moviments[cont_x]['vencimento'] + '</td>';
						retorno += '<td>' + clieforn  + '</td>';
						retorno += '<td>' + moviments[cont_x]['historico'] + '</td>';
						retorno += '<td>' + moviments[cont_x]['valor'] + '</td>';
						retorno += '<td>' + moviments[cont_x]['creditodebito'] + '</td>';
						retorno += '<td>' + status + '</td>';
						retorno += '<td>buttons</td>';
					
					retorno += '</tr>';
					
                }
                
            }
            else {
                retorno = '<tr class="initialism"><td colspan="10">Nada foi encontrado</td></tr>';
            }
            
            $('#json_content').prepend(retorno);
            
        });
		
        //** end code **//
    });
})(jQuery);