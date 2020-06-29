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
        
        //Formata valor para padrão brasileiro (9.999,00)
        function Real(v)
        {
            var negative = false; //Controle de valores negativos
            if (v < 0) { negative = true;} //Controle de valores negativos
            
            v = v.replace(/\D/g, '');
            v = new String(Number(v));
            var len = v.length;

            if (len == 1) {
                v = v.replace(/(\d)/, '0,0$1');
            }                   
            else if (len == 2) {
                v = v.replace(/(\d)/, '0,$1');
            }                   
            else if (len > 2 && len <= 5) {
                v = v.replace(/(\d{2})$/, ',$1');
            }
            else if (len > 5) {
               v = v.replace(/(\d{2})$/, ',$1').replace(/\d(?=(?:\d{3})+(?:\D|$))/g, '$&.');
            }

            if (negative) {v = '-' + v;}; //Controle de valores negativos
            
            return v;
        };

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

        function listaItensInvoices(url) {
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
                            var id_product   = data[i]['products_id'],
                                code      = data[i]['code'],
                                product      = data[i]['title'],
                                unity        = data[i]['unity'],
                                quantity     = data[i]['quantity'],
                                imobilizado  = data[i]['imobilizado'],
                                icms         = data[i]['icms'],
                                pericms      = data[i]['pericms'],
                                icmssubst    = data[i]['icmssubst'],
                                pericmssubst = data[i]['pericmssubst'],
                                ipi          = data[i]['ipi'],
                                peripi       = data[i]['peripi'],
                                vlunity      = data[i]['vlunity'],
                                vldiscount   = data[i]['vldiscount'],
                                vltotal      = data[i]['vltotal'];

                            //Adiciona as linhas da tabela
                            var row1 = $('<tr style="font-size: 11px;">'), list_product, list_unity, list_quantity, actionButtons;
                            
                            list_product  = '<td colspan="4" class="text-nowrap">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][products_id]" id="list_id_product" value="' + id_product + '">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][products_title]" id="list_product" value="' + product + '">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][imobilizado]" id="list_imobilizado" value="' + imobilizado + '">\n\
                                                &nbsp;'+ code + ' - ' + product + 
                                            '</td>';
                            list_unity    = '<td class="text-center">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][unity]" id="list_unity" value="' + unity + '">\n\
                                                &nbsp;' + unity + 
                                            '</td>';
                            list_quantity = '<td class="text-center">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][quantity]" id="list_quantity" value="' + String(Number(quantity).toFixed(4)) + '">\n\
                                                &nbsp;' + Real4(String(Number(quantity).toFixed(4))) + 
                                            '</td>';
                            actionButtons = '<td rowspan="2" class="text-center bg-gray" style="padding:12px;">\n\
                                                <button onclick="EditTableRow(this)" type="button" class="btn btn-actions fa fa-pencil" style="vertical-align: middle;" title="Editar"></button>\n\
                                                <button onclick="RemoveTableRow(this)" type="button" class="btn btn-actions fa fa-trash" style="vertical-align: middle;" title="Excluir"></button>\n\
                                            </td>';
                            
                            //Agrupa as linhas da tabela
                            var line1 = row1.append(list_product + list_unity + list_quantity + actionButtons);
                            
                            //Adiciona novos itens
                            $("#products-table").append(row1);

                            /**************/
                
                            var row2 = $('<tr style="font-size: 11px;">'), list_vlunity, list_vldiscount, list_ipi, list_icms, list_icmssubst, list_vltotal;
                            
                            list_vlunity    = '<td class="width-100 text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][vlunity]" id="list_vlunity" value="' + String(Number(vlunity).toFixed(4)) + '">\n\
                                                &nbsp;' + Real4(String(Number(vlunity).toFixed(4))) + 
                                              '</td>';
                            list_vldiscount = '<td class="width-100 text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][vldiscount]" id="list_vldiscount" value="' + String(vldiscount) + '">\n\
                                                &nbsp;' + Real(String(Number(vldiscount).toFixed(2))) + 
                                              '</td>';
                            list_ipi        = '<td class="width-100 text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][ipi]" id="list_ipi" value="' + String(ipi) + '">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][peripi]" id="list_peripi" value="' + String(peripi) + '">\n\
                                                &nbsp;' + Real(String(Number(ipi).toFixed(2))) + ' (' + Real(String(Number(peripi).toFixed(2))) + ')' + 
                                              '</td>';
                            list_icms       = '<td class="width-100 text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][icms]" id="list_icms" value="' + String(icms) + '">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][pericms]" id="list_pericms" value="' + String(pericms) + '">\n\
                                                &nbsp;' + Real(String(Number(icms).toFixed(2))) + ' (' + Real(String(Number(pericms).toFixed(2))) + ')' + 
                                              '</td>';
                            list_icmssubst  = '<td class="width-150 text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][icmssubst]" id="list_icmssubst" value="' + String(icmssubst) + '">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][pericmssubst]" id="list_pericmssubst" value="' + String(pericmssubst) + '">\n\
                                                &nbsp;' + Real(String(Number(icmssubst).toFixed(2))) + ' (' + Real(String(Number(pericmssubst).toFixed(2))) + ')' + 
                                              '</td>';
                            list_vltotal    = '<td class="width-100 text-right">\n\
                                                <input type="hidden" name="ProductList[' + id_product + '][vltotal]" id="list_vltotal" value="' + String(Number(vltotal).toFixed(2)) + '">\n\
                                                &nbsp;' + Real(String(Number(vltotal).toFixed(2))) + 
                                              '</td>';
                            
                            //Agrupa as linhas da tabela
                            var line2 = row2.append(list_vlunity + list_vldiscount + list_icms + list_ipi + list_icmssubst + list_vltotal);
                            
                            //Adiciona novos itens
                            $("#products-table").append(row2);

                            /******************************/
                
                            //Atualiza os totais
                            Totais(line1[0].cells, line2[0].cells);
            
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

        function zeraTotais() {

            var totalproducts          = document.querySelector('#totalproducts'),
                vltotalproducts        = document.querySelector('#vltotalproducts'),
                totalipi               = document.querySelector('#totalipi'),
                vltotalipi             = document.querySelector('#vltotalipi'),
                totalicms              = document.querySelector('#totalicms'),
                vltotalicms            = document.querySelector('#vltotalicms'),
                totalicmssubst         = document.querySelector('#totalicmssubst'),
                vltotalicmssubst       = document.querySelector('#vltotalicmssubst'),
                totaldiscount          = document.querySelector('#totaldiscount'),
                vltotaldiscount        = document.querySelector('#vltotaldiscount'),
                grandtotal             = document.querySelector('#grandtotal'),
                vlgrandtotal           = document.querySelector('#vlgrandtotal');

                /******************************/
                //Zera o total
    
                vltotaldiscount.value    = 0.00;
                vltotalproducts.value    = 0.00;
                vltotalipi.value         = 0.00;
                vltotalicms.value        = 0.00;
                vltotalicmssubst.value   = 0.00;
                vltotaldiscount.value    = 0.00;
                vlgrandtotal.value       = 0.00;
                totalproducts.innerHTML  = '0,00';
                totalipi.innerHTML       = '0,00';
                totalicms.innerHTML      = '0,00';
                totalicmssubst.innerHTML = '0,00';
                totaldiscount.innerHTML  = '0,00';
                grandtotal.innerHTML     = '0,00';

        }
        
        /**********************************************************************/

        function Totais(line1, line2) {

            //console.log(line1);
            //console.log(line2);

            var totalproducts          = document.querySelector('#totalproducts'),
                vltotalproducts        = document.querySelector('#vltotalproducts'),
                totalipi               = document.querySelector('#totalipi'),
                vltotalipi             = document.querySelector('#vltotalipi'),
                totalicms              = document.querySelector('#totalicms'),
                vltotalicms            = document.querySelector('#vltotalicms'),
                totalicmssubst         = document.querySelector('#totalicmssubst'),
                vltotalicmssubst       = document.querySelector('#vltotalicmssubst'),
                totaldiscount          = document.querySelector('#totaldiscount'),
                vltotaldiscount        = document.querySelector('#vltotaldiscount'),
                grandtotal             = document.querySelector('#grandtotal'),
                vlgrandtotal           = document.querySelector('#vlgrandtotal');
            
            var vltotalproducts_value  = Number(vltotalproducts.value),
                vltotalipi_value       = Number(vltotalipi.value),
                vltotalicms_value      = Number(vltotalicms.value),
                vltotalicmssubst_value = Number(vltotalicmssubst.value),
                vltotaldiscount_value  = Number(vltotaldiscount.value),
                vlgrandtotal_value     = Number(vlgrandtotal.value);

            var qtd = 0;

            /******************************/
            //Identifica os valores das linhas

            for (i = 0; i < line1.length; i++) { 

                var inputs = line1[i].getElementsByTagName("input");

                for (ii = 0; ii < inputs.length; ii++) {

                    id = inputs[ii].id;
                    va = inputs[ii].value;

                    switch (id) {
                        case 'list_id_product':
                            //ignore
                            break;
                        case 'list_product':
                            //ignore;
                            break;
                        case 'list_unity':
                            //ignore;
                            break;
                        case 'list_quantity':
                            qtd = Number(va); //QTD Precisa vir primeiro, na lista de itens
                            break;
                    }//switch (id)

                }//for (ii = 0; ii < inputs.length; ii++)

            }//for (i = 0; i < line1.length; i++)

            /**************/

            for (i = 0; i < line2.length; i++) { 

                var inputs = line2[i].getElementsByTagName("input");

                for (ii = 0; ii < inputs.length; ii++) {

                    id = inputs[ii].id;
                    va = inputs[ii].value;
                    
                    switch (id) {
                        case 'list_vlunity':
                            vltotalproducts.value    = Number(vltotalproducts_value + Number(qtd * va)).toFixed(2);
                            totalproducts.innerHTML  = Real(String(Number(vltotalproducts.value).toFixed(2)));
                            break;
                        case 'list_vldiscount':
                            vltotaldiscount.value    = Number(vltotaldiscount_value + Number(va)).toFixed(2);
                            totaldiscount.innerHTML  = Real(String(Number(vltotaldiscount.value).toFixed(2)));
                            break;
                        case 'list_icms':
                            vltotalicms.value        = Number(vltotalicms_value + Number(va)).toFixed(2);
                            totalicms.innerHTML      = Real(String(Number(vltotalicms.value).toFixed(2)));
                            break;
                        case 'list_ipi':
                            vltotalipi.value         = Number(vltotalipi_value + Number(va)).toFixed(2);
                            totalipi.innerHTML       = Real(String(Number(vltotalipi.value).toFixed(2)));
                            break;
                        case 'list_icmssubst':
                            vltotalicmssubst.value   = Number(vltotalicmssubst_value + Number(va)).toFixed(2);
                            totalicmssubst.innerHTML = Real(String(Number(vltotalicmssubst.value).toFixed(2)));
                            break;
                        case 'list_vltotal':
                            vlgrandtotal.value       = Number(vlgrandtotal_value + Number(va)).toFixed(2);
                            grandtotal.innerHTML     = Real(String(Number(vlgrandtotal.value).toFixed(2)));
                            break;
                    }//switch (id)

                }//for (ii = 0; ii < inputs.length; ii++)

            }//for (i = 0; i < line2.length; i++)
            
        }//function Totais(line1, line2)
        
        /**********************************************************************/

        //Ao selecionar um pedido de compra, os itens do pedido serão carregados
        $('#purchases_id').on('change', function() {
            
            //Define URL
            var context = $('#logo').attr('data-url'),
           purchases_id = $('#purchases_id option:selected').val(),
                    url = context + 'purchases/json_items/?query=' + purchases_id;

            //Zera Totais
            zeraTotais();

            //Lista itens e contabiliza totais
            listaItensInvoices(url);

        });

        //Ao selecionar um pedido de venda, os itens do pedido serão carregados
        $('#sells_id').on('change', function() {

            //Define URL
            var context = $('#logo').attr('data-url'),
               sells_id = $('#sells_id option:selected').val(),
                    url = context + 'sells/json_items/?query=' + sells_id;

            //Zera Totais
            zeraTotais();

            //Lista itens e contabiliza totais
            listaItensInvoices(url);

        });

        //Ao selecionar um pedido avulso, os itens do pedido e os totais serão limpos
        $('input[name="type"]').on('change', function() {

            //Zera Totais
            zeraTotais();

            //Limpa dados da tabela
            $("#products-table tr>td").remove();

            //Remove seleção
            document.getElementById('purchases_id').selectedIndex = 0;
            document.getElementById('sells_id').selectedIndex = 0;

        });

        //** end code **//
    });
})(jQuery);