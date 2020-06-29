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
        
        AddTableRow = function () 
        {
            //Define variáveis
            var code  = document.querySelector('#sub_code'),
                title = document.querySelector('#sub_title'),
                obs   = document.querySelector('#sub_obs');
                
            /******************************/
            //Identifica os itens não preenchidos
            if (code.value  == '') { alert("Código secundário não informado"); return false; }
            if (title.value == '') { alert("Descrição secundária não informada"); return false; }

            /******************************/
            //Adiciona as linhas da tabela
            var row1 = $('<tr style="font-size: 11px;">'), list_code, list_title, list_obs, actionButtons;
            
            list_code  = '<td class="text-left" style="vertical-align:middle !important;">\n\
                            <input type="hidden" name="ProductList[' + code.value + '][products_code]" id="list_code" value="' + code.value + '">\n\
                            &nbsp;'+ code.value + 
                         '</td>';
            list_title = '<td class="text-left text-nowrap" style="vertical-align:middle !important;">\n\
                            <input type="hidden" name="ProductList[' + code.value + '][products_title]" id="list_title" value="' + title.value + '">\n\
                            &nbsp;' + title.value + 
                         '</td>';
            list_obs = '<td class="text-left text-nowrap" style="vertical-align:middle !important;">\n\
                            <input type="hidden" name="ProductList[' + code.value + '][products_obs]" id="list_obs" value="' + obs.value + '">\n\
                            &nbsp;' + obs.value + 
                        '</td>';
            actionButtons = '<td class="text-center bg-gray media-middle" style="padding:12px;">\n\
                                <button onclick="EditTableRow(this)" type="button" class="btn btn-actions fa fa-pencil" title="Editar"></button>\n\
                                <button onclick="RemoveTableRow(this)" type="button" class="btn btn-actions fa fa-trash" title="Excluir"></button>\n\
                             </td>';
            
            row1.append(list_code + list_title + list_obs + actionButtons);
            $("#product-titles-table").append(row1);

            /******************************/
            //Limpa campos

            code.value  = '';
            title.value = '';
            obs.value   = '';
                
        };
        
        /**********************************************************************/
        
        EditTableRow = function (handler)
        {
            //Define variáveis
            var code  = document.querySelector('#sub_code'),
                title = document.querySelector('#sub_title'),
                obs   = document.querySelector('#sub_obs');

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
                        case 'list_code':
                            code.value  = inputs[ii].value;
                            break;
                        case 'list_title':
                            title.value = String(inputs[ii].value);
                            break;
                        case 'list_obs':
                            obs.value   = String(inputs[ii].value);
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
            var tr = $(handler).closest('tr');

            //Exclui a linha com delay animado
            tr.fadeOut(350, function () {
                //tr.remove();
                $(this).closest('tr').remove();
            });

            return false;
        };
        
        /**********************************************************************/
        
    });
})(jQuery);