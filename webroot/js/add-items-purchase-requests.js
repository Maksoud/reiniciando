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
        
        //Formata valor para padrão brasileiro com quatro casas decimais (9.999,0000)
        function Real4(v)
        {
            var negative = false; //Controle de valores negativos
            if (v < 0) { negative = true;} //Controle de valores negativos
            
            v = v.replace(/\D/g, '');
            v = new String(Number(v));
            var len = v.length;

            if (len == 1) {
                v = v.replace(/(\d)/, '0,000$1');
            }
            else if (len == 2) {
                v = v.replace(/(\d)/, '0,00$1');
            }
            else if (len == 3) {
                v = v.replace(/(\d)/, '0,0$1');
            }
            else if (len >= 4) {
                v = v.replace(/(\d{4})$/, ',$1');
            }

            /*
            if (len == 1) {
                v = v.replace(/(\d)/, '0,000$1');
            }                   
            else if (len == 2) {
                v = v.replace(/(\d)/, '0,00$1');
            }                   
            else if (len > 2 && len <= 5) {
                v = v.replace(/(\d{4})$/, ',$1');
            }
            else if (len > 5) {
                v = v.replace(/(\d{4})$/, ',$1').replace(/\d(?=(?:\d{5})+(?:\D|$))/g, '$&.');
            }
            */

            if (negative) {v = '-' + v;}; //Controle de valores negativos
            
            return v;
        };
        
        //Formata valor para padrão americano com 4 casas decimais (9999.0000)
        function Dolar4(v)
        {
            var negative = false; //Controle de valores negativos
            if (v.search("-") !== -1) { negative = true; console.log('Atenção: Valor negativo!');} //Controle de valores negativos
            
            v = v.replace(/\D/g, '');
            v = new String(Number(v));
            var len = v.length;

            if (len == 1) {
                v = v.replace(/(\d)/, '0.000$1');
            }
            else if (len == 2) {
                v = v.replace(/(\d)/, '0.00$1');
            }
            else if (len == 3) {
                v = v.replace(/(\d)/, '0.0$1');
            }
            else if (len >= 4) {
                v = v.replace(/(\d{4})$/, '.$1');
            }
            
            if (negative) {v = '-' + v;}; //Controle de valores negativos
            
            return v;
        };

        var idx = 0;
        
        AddTableRow = function () 
        {
            //Define variáveis
            var id_product = document.querySelector('#products_id'),
                product    = document.querySelector('#products_title'),
                unity      = document.querySelector('#edt_unity'),
                quantity   = document.querySelector('#edt_quantity'),
                deadline   = document.querySelector('#edt_deadline');
                
            /******************************/
            //Identifica os itens não preenchidos
            
            if (quantity.value != '') { 
                qtd = Number(Dolar4(quantity.value)).toFixed(4);
            } else { 
                qtd = 0.0000;
            }

            if (id_product.value == '') { alert("Produto não identificado"); return false; }
            if (product.value    == '') { alert("Produto não informado"); return false; }
            if (unity.value      == '') { alert("Unidade não informada"); return false; }
            if (qtd < 0.0001)  { alert("Quantidade não informada"); return false; }
            if (deadline.value   == '') { 
                deadline_value = '-'; 
                new_deadline   = null;
            } else {
                deadline_value = deadline.value;
                split = deadline.value.split('/');
                new_deadline = split[2] + "-" + split[1] + "-" + split[0];
            }

            /******************************/
            //Adiciona as linhas da tabela

            var row1 = $('<tr style="font-size: 11px;">'), list_product, list_unity, list_quantity, actionButtons;
            
            list_product  = '<td colspan="4" class="text-nowrap" style="vertical-align:middle !important;">\n\
                                <input type="hidden" name="ProductList[' + idx + '][products_id]" id="list_id_product" value="' + id_product.value + '">\n\
                                <input type="hidden" name="ProductList[' + idx + '][products_title]" id="list_product" value="' + product.value + '">\n\
                                &nbsp;'+ id_product.value + ' - ' + product.value + 
                            '</td>';
            list_unity    = '<td class="text-center" style="vertical-align:middle !important;">\n\
                                <input type="hidden" name="ProductList[' + idx + '][unity]" id="list_unity" value="' + unity.value + '">\n\
                                &nbsp;' + unity.value + 
                            '</td>';
            list_quantity = '<td class="text-center" style="vertical-align:middle !important;">\n\
                                <input type="hidden" name="ProductList[' + idx + '][quantity]" id="list_quantity" value="' + String(qtd) + '">\n\
                                &nbsp;' + Real4(String(qtd)) + 
                            '</td>';
            list_deadline = '<td class="text-center" style="vertical-align:middle !important;">\n\
                                <input type="hidden" name="ProductList[' + idx + '][deadline]" id="list_deadline" value="' + new_deadline + '">\n\
                                &nbsp;' + deadline_value + 
                            '</td>';
            actionButtons = '<td class="text-center bg-gray media-middle" style="padding:12px;">\n\
                                <button onclick="EditTableRow(this)" type="button" class="btn btn-actions fa fa-pencil" title="Editar"></button>\n\
                                <button onclick="RemoveTableRow(this)" type="button" class="btn btn-actions fa fa-trash" title="Excluir"></button>\n\
                            </td>';
            
            
            row1.append(list_product + list_unity + list_quantity + list_deadline + actionButtons);
            $("#products-table").append(row1);

            /******************************/
            //Incrementa o índice
            idx += 1;

            /******************************/
            //Limpa campos

            id_product.value   = '';
            product.value      = '';
            unity.value        = 'UN';
            quantity.value     = '';
            deadline.value     = '';
                
        };
        
        /**********************************************************************/
        
        EditTableRow = function (handler)
        {
            //Define variáveis
            var id_product = document.querySelector('#products_id'),
                product    = document.querySelector('#products_title'),
                unity      = document.querySelector('#edt_unity'),
                quantity   = document.querySelector('#edt_quantity'),
                deadline   = document.querySelector('#edt_deadline');

            /******************************/
            //Tratamento dos valores decimais

            quantity.value = Number(Dolar4(quantity.value)).toFixed(4);

            /******************************/
            //Identifica a tag

            var tr    = $(handler).closest('tr');
            var line1 = tr[0].cells;

            /******************************/
            //Identifica os valores das linhas

            for (i = 0; i < line1.length; i++) { 

                var inputs = line1[i].getElementsByTagName("input");

                for (ii = 0; ii < inputs.length; ii++) {
                    //console.log(inputs[ii].id + ' = ' + inputs[ii].value);
                    switch(inputs[ii].id) {
                        case 'list_id_product':
                            id_product.value = inputs[ii].value;
                            break;
                        case 'list_product':
                            product.value    = String(inputs[ii].value);
                            break;
                        case 'list_unity':
                            unity.value      = String(inputs[ii].value);
                            break;
                        case 'list_quantity':
                            quantity.value   = Real4(String(inputs[ii].value));
                            break;
                        case 'list_deadline':
                            deadline.value   = inputs[ii].value;
                            break;
                    }//switch(inputs[ii].id)

                }//for (ii = 0; ii < inputs.length; ii++)

            }//for (i = 0; i < line1.length; i++)

            /******************************/
            
            //REMOVE A LINHA
            RemoveTableRow(handler);
        };
        
        /**********************************************************************/
        
        RemoveTableRow = function (handler) 
        {
            //Identifica a tag
            var tr    = $(handler).closest('tr');
            var line1 = tr[0].cells;

            //Exclui a linha com delay animado
            tr.fadeOut(350, function () {
                //tr.remove();
                $(this).closest('tr').next().remove();
            });

            return false;
        };
        
        /**********************************************************************/
        
    });
})(jQuery);