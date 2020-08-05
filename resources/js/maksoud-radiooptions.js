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
        //controle de mostrar/ocultar banco e caixa na tela de Transfers/add
        $('input[name="radio_origem"]').on('change', function() {
            if ($(this).val() == 'banco_origem') {
                $('.banco_origem').addClass('show').removeClass('hidden');
                $('.caixa_origem').addClass('hidden').removeClass('show');
                
                $('.show:not(.report)').children('select').attr('required', 'true');
                $('.hidden:not(.report)').children('select').removeAttr('required');
            } else if ($(this).val() == 'caixa_origem') {
                $('.caixa_origem').addClass('show').removeClass('hidden');
                $('.banco_origem').addClass('hidden').removeClass('show');
                
                $('.show:not(.report)').children('select').attr('required', 'true');
                $('.hidden:not(.report)').children('select').removeAttr('required');
            } else {
                $('.caixa_origem').addClass('hidden').removeClass('show');
                $('.banco_origem').addClass('hidden').removeClass('show');
                
                $('.hidden:not(.report)').children('select').removeAttr('required');
            }
        });
        $('input[name="radio_destino"]').on('change', function() {
            if ($(this).val() == 'banco_destino') {
                $('.banco_destino').addClass('show').removeClass('hidden');
                $('.caixa_destino').addClass('hidden').removeClass('show');
                
                $('.show:not(.report)').children('select').attr('required', 'true');
                $('.hidden:not(.report)').children('select').removeAttr('required');
            } else if ($(this).val() == 'caixa_destino') {
                $('.caixa_destino').addClass('show').removeClass('hidden');
                $('.banco_destino').addClass('hidden').removeClass('show');
                
                $('.show:not(.report)').children('select').attr('required', 'true');
                $('.hidden:not(.report)').children('select').removeAttr('required');
            } else {
                $('.caixa_destino').addClass('hidden').removeClass('show');
                $('.banco_destino').addClass('hidden').removeClass('show');

                $('.hidden:not(.report)').children('select').removeAttr('required');
            }
        });
        
        //controle de mostrar/ocultar fornecedor e cliente na tela de Moviment Boxes
        $('input[name="creditodebito"]').on('change', function() {
            if ($(this).val() == 'C') {
                $('.C').addClass('show').removeClass('hidden');
                $('.D').addClass('hidden').removeClass('show');
                
                $('.show:not(.report)').children('select').attr('required', 'true');
                $('.hidden:not(.report)').children('select').removeAttr('required');
            } else if ($(this).val() == 'D') {
                $('.D').addClass('show').removeClass('hidden');
                $('.C').addClass('hidden').removeClass('show');
                
                $('.show:not(.report)').children('select').attr('required', 'true');
                $('.hidden:not(.report)').children('select').removeAttr('required');
            } else {
                $('.D').addClass('hidden').removeClass('show');
                $('.C').addClass('hidden').removeClass('show');
                
                $('.hidden:not(.report)').children('select').removeAttr('required');
            }
        });
        
        //controle de mostrar/ocultar fornecedor e cliente na tela de Usuários
        $('input[name="buscausuario"]').on('change', function() {
            if ($(this).val() == 'N') {
                $('.N').addClass('show').removeClass('hidden');
                $('.S').addClass('hidden').removeClass('show');
            } else if ($(this).val() == 'S') {
                $('.S').addClass('show').removeClass('hidden');
                $('.N').addClass('hidden').removeClass('show');
            }
        });
        
        //controle de mostrar/ocultar fornecedor e cliente na tela de Moviments
        $('input[name="bancaicar"]').on('change', function() {
            if ($(this).val() == '') {
                $('.B').addClass('hidden').removeClass('show');
                $('.X').addClass('hidden').removeClass('show');
                $('.R').addClass('hidden').removeClass('show');
            } else if ($(this).val() == 'B') {
                $('.B').addClass('show').removeClass('hidden');
                $('.X').addClass('hidden').removeClass('show');
                $('.R').addClass('hidden').removeClass('show');
            } else if ($(this).val() == 'X') {
                $('.B').addClass('hidden').removeClass('show');
                $('.X').addClass('show').removeClass('hidden');
                $('.R').addClass('hidden').removeClass('show');
            } else if ($(this).val() == 'R') {
                $('.B').addClass('hidden').removeClass('show');
                $('.X').addClass('hidden').removeClass('show');
                $('.R').addClass('show').removeClass('hidden');
            }
        });
        
        //controle de mostrar/ocultar fornecedor e cliente na tela de Moviments
        $('input[name="radio_bc"]').on('change', function() {
            if ($(this).val() == 'banco') {
                $('.banco').addClass('show').removeClass('hidden');
                $('.caixa').addClass('hidden').removeClass('show');
                
                $('.show:not(.report)').children('select').attr('required', 'true');
                $('.hidden:not(.report)').children('select').removeAttr('required');

                $('#boxes_title').val("");
                $('#boxes_id').val("");
            } else {
                $('.caixa').addClass('show').removeClass('hidden');
                $('.banco').addClass('hidden').removeClass('show');
                
                $('.show:not(.report)').children('select').attr('required', 'true');
                $('.hidden:not(.report)').children('select').removeAttr('required');

                $('#banks_title').val("");
                $('#banks_id').val("");
            }
        });
        
        //controle de mostrar/ocultar banco e caixa na tela de Balances/update_balance
        $('input[name="radio"]').on('change', function() {
            if ( $(this).val() == 'caixa') {
                $('.caixa').addClass('show').removeClass('hidden');
                $('.banco').addClass('hidden').removeClass('show');
                $('.cartao').addClass('hidden').removeClass('show');
                $('.planejamento').addClass('hidden').removeClass('show');
            } else if ($(this).val() == 'banco') {
                $('.banco').addClass('show').removeClass('hidden');
                $('.caixa').addClass('hidden').removeClass('show');
                $('.cartao').addClass('hidden').removeClass('show');
                $('.planejamento').addClass('hidden').removeClass('show');
            } else if ($(this).val() == 'cartao') {
                $('.cartao').addClass('show').removeClass('hidden');
                $('.caixa').addClass('hidden').removeClass('show');
                $('.banco').addClass('hidden').removeClass('show');
                $('.planejamento').addClass('hidden').removeClass('show');
            } else if ($(this).val() == 'planejamento') {
                $('.planejamento').addClass('show').removeClass('hidden');
                $('.caixa').addClass('hidden').removeClass('show');
                $('.banco').addClass('hidden').removeClass('show');
                $('.cartao').addClass('hidden').removeClass('show');
            }
        });

        //controle de mostrar/ocultar fornecedor e cliente na tela de Faturamento
        // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing
        $('input[name="type"]').on('change', function() {
            if ($(this).val() == 'P') {

                $('.P').addClass('show').removeClass('hidden');
                $('.S').addClass('hidden').removeClass('show');

                //Habilita os edits
                $('input[name="nf"]').removeAttr('disabled');
                $('input[name="cfop"]').removeAttr('disabled');

            } else if ($(this).val() == 'S') {

                $('.S').addClass('show').removeClass('hidden');
                $('.P').addClass('hidden').removeClass('show');

                //Habilita os edits
                $('input[name="nf"]').removeAttr('disabled');
                $('input[name="cfop"]').removeAttr('disabled');

            } else if ($(this).val() == 'DS' || $(this).val() == 'DP') {

                $('.S').addClass('hidden').removeClass('show');
                $('.P').addClass('hidden').removeClass('show');
                
                //Limpa os campos de NF e CFOP
                $('input[name="nf"]').val('');
                $('input[name="cfop"]').val('');

                //Desabilita os edits
                $('input[name="nf"]').attr('disabled', 'true');
                $('input[name="cfop"]').attr('disabled', 'true');

            }
        });
        //** end code **//
    });
})(jQuery);