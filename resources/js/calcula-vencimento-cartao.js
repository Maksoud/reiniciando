/**
 * Desenvolvido por:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
;
(function($){
    $(document).ready(function($){
        
        var context       = $('#logo').attr('data-url'),
            url           = context + 'moviment-cards/calculaVencJson?';
            
       function calculaVencimentoCartao()
	   {
            var cards_id      = 'cards_id=' + $('#cards_id').val() + '&',
                dt_lancamento = 'dt_lancamento=' + $('input[name=data]').val();
            
            $.ajax({
                url: url + cards_id + dt_lancamento,
                type: 'get',
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data, status){
                    
                    //caso já tenha dado algum erro, remover as class de erro
                    $('.has-error').removeClass('has-error');

                    if( data['status'] == 'error' ){

                        //remover qualquer erro dado anteriormente
                        $('.help-block').remove();
                        $('.has-error').removeClass('has-error');

                        /******************************************************/

                        console.log('/*******************/');
                        console.log(data['mensagem']);

                        //ir buscar as msgs secundarias com os erros ocorridos
                        for( var key in data['errors'] ){

                            $('[name=' + key + ']').focus().parent().addClass('has-error');

                            for( var key2 in data['errors'][key] ){
                                $('[name=' + key + ']').parent().append('<span class="help-block"><small>' + data['errors'][key][key2] + '</small></span> ');

                                console.log(data['errors'][key][key2]);
                            }
                        }

                        console.log('/*******************/');

                    } else {
                        
                        $('input[name=vencimento]').val(data);
                        
                    }
                },
                error: function (xhr, desc, err){
                    
                    console.log('/*******************/');
                    console.log(xhr);
                    console.log(desc);
                    console.log(err);
                    console.log('/*******************/');
                    
                }
            });
            
        };
        
        $('input[name=data]').on('change', function(){
            
            if ($('#cards_title').val() !== '') {
                calculaVencimentoCartao();
            }
            
        });
        
        $('#cards_title').bind('focusout', function(){
            
            if ($('input[name=data]').val() !== '') {
                calculaVencimentoCartao();
            }
            
        });
        
        //** end code **//
    });
})(jQuery);