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
        
        //Formata valor para padrão brasileiro (9.999,00)
        function Real(v)
        {
            v = v.replace(/\D/g, "");
            v = new String(Number(v));
            var len = v.length;

            if (len == 1) {
                v = v.replace(/(\d)/, "0,0$1");
            }                   
            else if (len == 2) {
                v = v.replace(/(\d)/, "0,$1");
            }                   
            else if (len > 2 && len <= 5) {
                v = v.replace(/(\d{2})$/, ",$1");
            }
            else if (len > 5) {
               v = v.replace(/(\d{2})$/, ",$1").replace(/\d(?=(?:\d{3})+(?:\D|$))/g, "$&.");
            }
            return v;
        };
        
        //Formata valor para padrão americano (9999.00)
        function Dolar(v)
        {
            v = v.replace(/\D/g, "");
            v = new String(Number(v));
            var len = v.length;

            if (len == 1) {
                v = v.replace(/(\d)/, "0.0$1");
            }                   
            else if (len == 2) {
                v = v.replace(/(\d)/, "0.$1");
            }                   
            else if (len > 2) {
                v = v.replace(/(\d{2})$/, ".$1");
            }
            return v;
        };
        
        /**********************************************************************/

        //NÃO PERMITE INFORMAR PAGAMENTO QUANDO SELECIONADO A OPÇÃO DE INFORMAR PAGAMENTO
        $("#informarPagamento").on("click", function() {

            var wasVisible = $("#collapsePagamento").is(":visible");
            var wasHidden = $("#collapsePagamento").is(":hidden");

            if ($("#collapseCard").is(":hidden")) {

                if (wasHidden) {

                    $("#informarCard").attr("disabled", "disabled");
                    $("#informarCard").removeAttr("href");

                } else if (wasVisible) {

                    $("#informarCard").removeAttr("disabled");
                    $("#informarCard").attr("href", "#collapseCard");

                }

            }
            
        });
        
        //NÃO PERMITE A EDIÇÃO DO VENCIMENTO QUANDO SELECIONADO O CARTÃO
        $("#informarCard").on("click", function() {
            
            var wasVisible = $("#collapseCard").is(":visible");
            var wasHidden = $("#collapseCard").is(":hidden");
            var formAction = $("#cprCardsForm").attr("action");
            
            if ($("#collapsePagamento").is(":hidden")) {

                if (wasHidden) {
                    
                    //O formulário será enviado para o add de movimentos de cartões
                    formAction = formAction.replace("moviments", "moviment-cards");
                    formAction = formAction.replace("add?titulo=Nova+Conta+a+Pagar%2FReceber", "add?titulo=Novo+Movimento+de+Cart%C3%A3o");
                    $("#cprCardsForm").attr("action", formAction); 
                    //$("form").attr("action", "/moviment-cards/add?titulo=Novo+Movimento+de+Cart%C3%A3o");
                    
                    $("#modal_item_title").html("Novo Movimento de Cartão");
                    
                    //Remove valores dos campos
                    $("input[name='vencimento']").val("");
                    $("#document_types_id").val("");
                    
                    //Austa alguns campos não utilizados no movimento de cartões
                    $("#document_types_title").val("CARTÃO");
                    $("#document_types_title").attr("disabled", "disabled");
                    $("#document_types_add").attr("disabled", "disabled");
                    $("#document_types_add").removeClass("btn_modal2");
                    $("input[name='vencimento']").attr("disabled", "disabled");
                    $("#informarPagamento").attr("disabled", "disabled");
                    $("#informarPagamento").removeAttr("href");
                    $("#collapsePagamento").removeClass("in");
                    $("input[name='historico']").attr("name", "title");
                    
                } else if (wasVisible) {
                    
                    //O formulário volta a ser um lançamento CPR
                    formAction = formAction.replace("moviment-cards", "moviments");
                    formAction = formAction.replace("add?titulo=Novo+Movimento+de+Cart%C3%A3o", "add?titulo=Nova+Conta+a+Pagar%2FReceber");
                    $("#cprCardsForm").attr("action", formAction);
                    //$("form").attr("action", "/moviments/add?titulo=Nova+Conta+a+Pagar%2FReceber");
                    
                    $("#modal_item_title").html("Nova Conta a Pagar/Receber");
                    
                    //Remove valores dos campos
                    $("input[name='vencimento']").val("");
                    $("#document_types_title").val("");
                    $("#cards_title").val("");
                    $("#cards_id").val("");
                    
                    //Habilita os campos novamente
                    $("#document_types_title").removeAttr("disabled");
                    $("#document_types_add").removeAttr("disabled");
                    $("#document_types_add").addClass("btn_modal2");
                    $("input[name='vencimento']").removeAttr("disabled");
                    $("#informarPagamento").removeAttr("disabled");
                    $("#informarPagamento").attr("href", "#collapsePagamento");
                    $("input[name='title']").attr("name", "historico");
                    
                }

            }
            
        });
        
        /**********************************************************************/
        
        //PREENCHIMENTO AUTOMÁTICO NO CASO DA BAIXA NO LANÇAMENTO
        $("input[name='parcelas']").on("change", function() {
            
            console.log($("input[name='parcelas']").val());
            if ($("input[name='parcelas']").val() != 1) {
                $("#informarPagamento").attr("disabled", "disabled");
                $("#collapsePagamento").removeClass("in");
                $("#informarPagamento").removeAttr("data-toggle");
            } else {
                $("#informarPagamento").removeAttr("disabled");
                $("#informarPagamento").attr("data-toggle", "collapse");
            }
            
        });
        
        $("#informarPagamento").on("click", function() {
            
            var wasVisible = $("#collapsePagamento").is(":visible");
            var wasHidden = $("#collapsePagamento").is(":hidden");

            if (wasHidden) {
                if ($("input[name='vencimento']").val()) {
                    $("input[name='dtbaixa']").val($("input[name='vencimento']").val());
                } else {
                    $("input[name='dtbaixa']").val($("input[name='data']").val());
                }

                $("input[name='valorbaixa']").val($("#valor").val());
            } else if (wasVisible) {
                $("input[name='dtbaixa']").val("");
                $("input[name='valorbaixa']").val("");
            }
            
        });
        
        /**********************************************************************/
        
        function AtualizaValoresResumo()
        {
            //Remove o Icon Refresh ao sair (focusout) do campo de valor da baixa
            $(".dataLoading").html("");
            
            var valor, baixa, mesclado, desc, diferenca;
            
            /******************************************************************/
            //Apresentação dos valores atualizados da Fatura e Vinculados
            
            valor    = Number(Dolar($("#valor").html()));
            baixa    = Number(Dolar($("#valorbaixa").val()));
            mesclado = $("#vlrmesclado").html();
            parcial  = $("#vlrparcial").html();
            
            //Apresentação dos valores atualizados da Fatura e Vinculados
            /******************************************************************/
            //Calcular o valor do desconto/juros aplicado
            //Não exibe mensagem de desconto/juros para pagamentos parciais
            if ($("input[name='parcial']:checked").val() !== "P") {
                
                if (valor > baixa) {

                    $("#text-vlrdesc").html("Desconto Aplicado: ");

                } else if (valor < baixa) {

                    $("#text-vlrdesc").html("Juros Aplicado: ");

                } else if (valor === baixa) {

                    $("#text-vlrdesc").html("Desconto/Juros Aplicado: ");

                }

                desc = baixa - valor;
                desc = desc.toFixed(2);

                $("#vlrdesc").html(Real(String(desc)));
                
            } else {
                
                if (valor > baixa) {

                    $("#text-vlrdesc").html("Valor da nova fatura parcial: ");

                    desc = baixa - valor;
                    desc = desc.toFixed(2);

                    $("#vlrdesc").html(Real(String(desc)));

                } else if (valor < baixa) {

                    $("#text-vlrdesc").html("O valor da baixa parcial não poderá ser maior");

                } else if (valor === baixa) {

                    $("#text-vlrdesc").html("Aguardando o valor da baixa parcial");
                    
                }

                //Limpa valores
                //$("#text-vlrdesc").html("");
                //$("#vlrdesc").html("");
                
            }
            
            /******************************************************************/
            
            //Se houver títulos mesclados verifica a diferença da fatura
            if (mesclado) {
                //alert(mesclado);
                mesclado = Number(Dolar(mesclado));
                $("#mesclapgto").html(Real(String(mesclado)));
                
                //Calcular a diferença dos títulos vinculados referenta a fatura
                var diferenca = mesclado - valor;
                    diferenca = diferenca.toFixed(2);
            
                if (valor !== mesclado && !parcial) {
                    $("#text-diferenca").html("Valor em Desacordo com a Fatura: ");            
                    $("#vlrdiferenca").html(Real(String(diferenca)));
                }
            }
            
            //Limpa as variáveis
            delete valor;
            delete baixa;
            delete mesclado;
            delete desc;
            delete diferenca;
            
        }//function AtualizaValoresResumo()
        
        /**********************************************************************/
        
        $("input[name='valorbaixa']").on("keydown", function() {
            //Adiciona Icon Refresh ao modificar o campo de valor da baixa
            $(".dataLoading").html("<i class='fa fa-spinner fa-pulse fa-3x fa-fw' style='font-size:18px;'></i>");
        });
        
        /**********************************************************************/
        
        //controle de cálculo de descontos na tela de Moviments/LOW
        $("input[name='valorbaixa']").bind("focusout", AtualizaValoresResumo);
        
        /**********************************************************************/
        
        //exibe ou não a informação de descontos/juros
        $("input[name='parcial']").on("click", AtualizaValoresResumo);
        
        /**********************************************************************/
        
        //** end code **//
    });
})(jQuery);