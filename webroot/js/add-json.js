/**
 * Desenvolvido por:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

;
(function($) {
    $(document).ready(function($) {

        //URL principal do sistema
        var context = $('#logo').attr('data-url');

        /******************************************************************/

        $(document).on('submit', '.ajax_add', function(e) {

            var   submit = $('.ajax_submit'),
                data_url = $(this).attr('data-url'),
                formData = this;

            const oldtext = submit[0].innerText;

            $.ajax({
                url: context + data_url,
                type: 'post',
                dataType: "JSON",
                data: new FormData(formData),
                processData: false,
                contentType: false,
                beforeSend: function (){

                    //Muda o texto do botão
                    switch (oldtext) {
                        case "Gravar":
                            submit.html("Gravando...");
                        break;
                        case "Save":
                            submit.html("Saving...");
                        break;
                        case "Gerar Relatório":
                            submit.html("Gerando...");
                        break;
                        case "Report":
                            submit.html("Baking...");
                        break;
                    }

                    //Muda de submit para button para evitar 
                    submit.attr('type', 'button');

                },
                success: function (data, status) {

                    var btn_close_alert = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>';

                    //caso já tenha dado algum erro, remover as class de erro
                    $('.has-error').removeClass('has-error');

                    if (data['status'] == 'error') {

                        var retorno = '<div class="alert alert-danger" role="alert">' + btn_close_alert + data['mensagem'] + '</div>';
                        
                        /******************************************************/

                        //limpar a div que aparece os retornos
                        $('#ajax-retorno').html(''); 

                        //informar msg principal de erro
                        $('#ajax-retorno').append(retorno); 
                        
                        /******************************************************/

                        //remover qualquer erro dado anteriormente
                        $('.help-block').remove();
                        $('.has-error').removeClass('has-error');
                        
                        /******************************************************/
                        
                        console.log('/*******************/');
                        console.log(data['mensagem']);
                        
                        /******************************************************/

                        //ir buscar as msgs secundarias com os erros ocorridos
                        for (var key in data['errors']) {

                            $('[name=' + key + ']').focus().parent().addClass('has-error');

                            for (var key2 in data['errors'][key]) {

                                $('[name=' + key + ']').parent().append('<span class="help-block"><small>' + data['errors'][key][key2] + '</small></span> ');

                                console.log(data['errors'][key][key2]);

                            }//for (var key2 in data['errors'][key])

                        }//for (var key in data['errors'])

                        console.log('/*******************/');
                        
                        /******************************************************/
                        
                        //Corre para o topo para mostrar o erro
                        $('#modal_item2').animate({
                            scrollTop:$(this.hash).offset().top + 1000
                        }, 800);

                    } else {

                        var retorno = '<div class="alert alert-success" role="alert">' + btn_close_alert + data['mensagem'] + '</div>';
                        
                        /******************************************************/
                        
                        //limpar a div que aparece os retornos
                        $('#ajax-sucesso-retorno').html(''); 

                        //informar msg principal de sucesso
                        $('#ajax-sucesso-retorno').append(retorno); 
                        
                        /******************************************************/
                        
                        if ($('#modal_item2').hasClass('in') === false) {

                            //$('#modal_item').modal('hide'); //fecha modal 1
                            location.reload();

                        } else {

                            //OCULTA O MODAL 2
                            $('#modal_item2').modal('hide');

                            //PREENCHE OS CAMPOS DO MODAL 1
                            switch (data_url) {

                                //PRODUTOS
                                case 'products/addjson':
                                    $('#products_id').val(data['id']);
                                    $('#products_title').val(data['title']);
                                break;
                                //PLANOS DE CONTAS
                                case 'account-plans/addjson':
                                    $('#account_plans_id').val(data['id']);
                                    $('#account_plans_title').val(data['classification'] + ' - ' + data['title']);
                                break;
                                //BANCOS
                                case 'banks/addjson':
                                    $('#banks_id').val(data['id']);
                                    $('#banks_title').val(data['title'] + ' (' + data['agencia'] + '/' + data['conta'] + ')');
                                break;
                                //CAIXAS
                                case 'boxes/addjson':
                                    $('#boxes_id').val(data['id']);
                                    $('#boxes_title').val(data['title']);
                                break;
                                //CARTÕES
                                case 'cards/addjson':
                                    $('#cards_id').val(data['id']);
                                    $('#cards_title').val(data['title']);
                                break;
                                //CENTROS DE CUSTOS
                                case 'costs/addjson':
                                    $('#costs_id').val(data['id']);
                                    $('#costs_title').val(data['title']);
                                break;
                                //CLIENTES
                                case 'customers/addjson':
                                    $('#customers_id').val(data['id']);
                                    $('#customers_title').val(data['title'] + ' (' + data['cpfcnpj'] + ')');
                                break;
                                //TIPOS DE DOCUMENTOS
                                case 'document-types/addjson':
                                    $('#document_types_id').val(data['id']);
                                    $('#document_types_title').val(data['title']);
                                break;
                                //TIPOS DE EVENTOS
                                case 'event-types/addjson':
                                    $('#event_types_id').val(data['id']);
                                    $('#event_types_title').val(data['title']);
                                break;
                                //FORNECEDORES
                                case 'providers/addjson':
                                    $('#providers_id').val(data['id']);
                                    $('#providers_title').val(data['title'] + ' (' + data['cpfcnpj'] + ')');
                                break;
                                //TRANSPORTADORAS
                                case 'transporters/addjson':
                                    $('#transporters_id').val(data['id']);
                                    $('#transporters_title').val(data['title'] + ' (' + data['cpfcnpj'] + ')');
                                break;

                            }//switch (data_url)

                        }//else if ($('#modal_item2').hasClass('in') === false)
                        
                        //window.location.href = window.location.href.replace( /[\?#].*|$/, "?action=ok" );
                    }

                    /**********************************************************/

                    //Retorna o parâmetro de submit
                    submit.attr('type', 'submit');

                    //Retorna o texto anterior
                    submit.html(oldtext);
                        
                },
                error: function (xhr, desc, err) {

                    var btn_close_alert = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>',
                        retorno  = '<div class="alert alert-danger" role="alert">' + btn_close_alert + xhr['responseText'] + '</div>';
                        
                    /******************************************************/

                    //limpar a div que aparece os retornos
                    $('#ajax-retorno').html(''); 

                    //informar msg principal de erro
                    $('#ajax-retorno').append(retorno); 
                        
                    /******************************************************/

                    console.log('/*******************/');
                    console.log(xhr);
                    console.log(desc);
                    console.log(err);
                    console.log('/*******************/');

                    /**********************************************************/

                    //Retorna o parâmetro de submit
                    submit.attr('type', 'submit');

                    //Retorna o texto anterior
                    submit.html(oldtext);

                }
            });

            e.preventDefault();

        });

        //** end code **//
    });
})(jQuery);
