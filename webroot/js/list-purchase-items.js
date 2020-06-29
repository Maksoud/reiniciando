/**
 * Desenvolvido por:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

;
(function ($) {
    $(document).ready(function ($) {

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

            if (negative) {v = '-' + v;}; //Controle de valores negativos
            
            return v;
        }
        
        /**********************************************************************/

        function listaItens() {

            var context = $('#logo').attr('data-url'),
   purchase_requests_id = $('#purchase_requests_id option:selected').val(),
                    url = context + 'purchaseRequests/json_items/?query=' + purchase_requests_id;

            //console.log(url);
            
            $.ajax({
                url: url,
                type: 'get',
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data, status){

                    if (data['status'] == 'error') {
                                                
                        //console.log('/*******************/');
                        //console.log(data);
                        
                        /******************************************************/

                        //ir buscar as msgs secundarias com os erros ocorridos
                        for (var key in data['errors']) {

                            $('[name=' + key + ']').focus().parent().addClass('has-error');

                            for (var key2 in data['errors'][key]) {

                                $('[name=' + key + ']').parent().append('<span class="help-block"><small>' + data['errors'][key][key2] + '</small></span> ');

                                //console.log(data['errors'][key][key2]);

                            }//for (var key2 in data['errors'][key])

                        }//for (var key in data['errors'])

                        //console.log('/*******************/');

                    } else {

                        //Limpa dados da tabela
                        $("#products-table tr>td").remove();
                        
                        /******************************************************/

                        for (var i = 0; i < data.length; i++) {

                            //console.log(i, data[i]);
                            
                            //Define as variáveis
                            var id_product  = data[i]['products_id'],
                                code     = data[i]['code'],
                                product     = data[i]['title'],
                                unity       = data[i]['unity'],
                                quantity    = data[i]['quantity'];

                            //Adiciona as linhas da tabela
                            var row1 = $('<tr style="font-size: 11px;">'), list_product, list_unity, list_quantity, actionButtons;
                            
                            list_product  = '<td colspan="4" class="text-nowrap">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][products_id]" id="list_id_product" value="' + id_product + '">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][products_title]" id="list_product" value="' + product + '">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][imobilizado]" id="list_imobilizado" value="0">\n\
                                                &nbsp;'+ code + ' - ' + product + 
                                            '</td>';
                            list_unity    = '<td class="text-center">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][unity]" id="list_unity" value="' + unity + '">\n\
                                                &nbsp;' + unity + 
                                            '</td>';
                            list_quantity = '<td class="text-center">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][quantity]" id="list_quantity" value="' + String(quantity.toFixed(4)) + '">\n\
                                                &nbsp;' + Real4(String(quantity.toFixed(4))) + 
                                            '</td>';
                            actionButtons = '<td rowspan="2" class="text-center bg-gray" style="padding:12px;">\n\
                                                <button onclick="EditTableRow(this)" type="button" class="btn btn-actions fa fa-pencil" style="vertical-align: middle;" title="Editar"></button>\n\
                                                <button onclick="RemoveTableRow(this)" type="button" class="btn btn-actions fa fa-trash" style="vertical-align: middle;" title="Excluir"></button>\n\
                                            </td>';
                            
                            //Agrupa as linhas da tabela
                            row1.append(list_product + list_unity + list_quantity + actionButtons);
                            
                            //Adiciona novos itens
                            $("#products-table").append(row1);

                            /**************/
                
                            var row2 = $('<tr style="font-size: 11px;">'), list_vlunity, list_vldiscount, list_ipi, list_icms, list_icmssubst, list_vltotal;
                            
                            list_vlunity    = '<td class="text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][vlunity]" id="list_vlunity" value="0.0000">\n\
                                                &nbsp;0,0000' + 
                                              '</td>';
                            list_vldiscount = '<td class="text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][vldiscount]" id="list_vldiscount" value="0.00">\n\
                                                &nbsp;0,00' + 
                                              '</td>';
                            list_ipi        = '<td class="text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][ipi]" id="list_ipi" value="0.00">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][peripi]" id="list_peripi" value="0">\n\
                                                &nbsp;0,00 (0)' + 
                                              '</td>';
                            list_icms       = '<td class="text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][icms]" id="list_icms" value="0.00">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][pericms]" id="list_pericms" value="0">\n\
                                                &nbsp;0,00 (0)' + 
                                              '</td>';
                            list_icmssubst  = '<td class="text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][icmssubst]" id="list_icmssubst" value="0.00">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][pericmssubst]" id="list_pericmssubst" value="0">\n\
                                                &nbsp;0,00 (0)' + 
                                              '</td>';
                            list_vltotal    = '<td class="text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][vltotal]" id="list_vltotal" value="0.00">\n\
                                                &nbsp;0,00' + 
                                              '</td>';
                            
                            //Agrupa as linhas da tabela
                            var line2 = row2.append(list_vlunity + list_vldiscount + list_icms + list_ipi + list_icmssubst + list_vltotal);
                            
                            //Adiciona novos itens
                            $("#products-table").append(row2);
            
                        }//for (var i = 0; i < data.length; i++)
                        
                    }//else if (data['status'] == 'error')

                },
                error: function (xhr, desc, err){

                    console.log('/*******************/');
                    console.log(xhr);
                    console.log(desc);
                    console.log(err);
                    console.log('/*******************/');

                }
            });

            //e.preventDefault();

        }//function listaItens()
        
        /**********************************************************************/

        //Executa a função a cada alteração
        $('#purchase_requests_id').on('change', function() {
            listaItens();
        });

        //** end code **//
    });
})(jQuery);