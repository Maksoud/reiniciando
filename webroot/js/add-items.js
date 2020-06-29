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
            else if (len == 4) {
                v = v.replace(/(\d{4})$/, '0,$1');
            }
            else if (len > 4) {
                v = v.replace(/(\d{4})$/, ',$1');
            }

            if (negative) {v = '-' + v;}; //Controle de valores negativos
            
            return v;
        };
        
        //Formata valor para padrão americano (9999.00)
        function Dolar(v)
        {
            var negative = false; //Controle de valores negativos
            if (v.search("-") !== -1) { negative = true; console.log('Atenção: Valor negativo!');} //Controle de valores negativos
            
            v = v.replace(/\D/g, '');
            v = new String(Number(v));
            var len = v.length;

            if (len == 1) {
                v = v.replace(/(\d)/, '0.0$1');
            }
            else if (len == 2) {
                v = v.replace(/(\d)/, '0.$1');
            }
            else if (len > 2) {
                v = v.replace(/(\d{2})$/, '.$1');
            }
            
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
            else if (len == 4) {
                v = v.replace(/(\d{4})$/, '0.$1');
            }
            else if (len > 4) {
                v = v.replace(/(\d{4})$/, '.$1');
            }
            
            if (negative) {v = '-' + v;}; //Controle de valores negativos
            
            return v;
        };

        /*
        var Busca, Casas, Num2;	
        var Num = prompt("Digite um número com virgula logo!","")	
            Busca = Num.indexOf(",", 0);

        if (Busca == -1) {
            Num = Num + "," + 0 + 0;
        } else {
            Casas = Num.substring(Number(Busca+1), Number(Busca+3));  
            Num2  = Num.substring(0, Number(Busca+1));  
            Num   = Num2 + Casas;	
        }	
        alert(Num);
        */

        var idx = 0;
        
        AddTableRow = function () 
        {
            //Define variáveis
            var id_product   = document.querySelector('#products_id'),
                product      = document.querySelector('#products_title'),
                imobilizado  = document.querySelector('#edt_imobilizado'),
                unity        = document.querySelector('#edt_unity'),
                quantity     = document.querySelector('#edt_quantity'),
                vlunity      = document.querySelector('#edt_vlunity'),
                vldiscount   = document.querySelector('#edt_vldiscount'),
                ipi          = document.querySelector('#edt_ipi'),
                peripi       = document.querySelector('#edt_peripi'),
                icms         = document.querySelector('#edt_icms'),
                pericms      = document.querySelector('#edt_pericms'),
                icmssubst    = document.querySelector('#edt_icmssubst'),
                pericmssubst = document.querySelector('#edt_pericmssubst');
                
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
            if (qtd < 0.0001){ alert("Quantidade não informada"); return false; }
            if (vlunity.value    == '') { alert("Valor unitário não informado"); return false; }
            if (vldiscount.value == '') { alert("Valor desconto não informado"); return false; }
            if (ipi.value  == '' && peripi.value  == '') { alert("IPI não informado"); return false; }
            if (icms.value == '' && pericms.value == '') { alert("ICMS não informado"); return false; }
            if (icmssubst.value  == '' && pericmssubst.value == '') { alert("ICMS de substituição não informado"); return false; }

            /******************************/
            //Calcula os valores ou percentuais
            
            if (icms.value == '') {
                //Calcula o valor do ICMS
            } else if (pericms.value == '') {
                //Calcula o percentual do ICMS
            }

            if (ipi.value == '') {
                //Calcula o valor do IPI
            } else if (peripi.value == '') {
                //Calcula o percentual do IPI
            }

            if (icmssubst.value == '') {
                //Calcula o valor do ICMS de substituição
            } else if (pericmssubst.value == '') {
                //Calcula o percentual do ICMS de substituição
            }

            /******************************/
            //Tratamento dos valores decimais

            vlunity.value      = Number(Dolar4(vlunity.value)).toFixed(4);
            vldiscount.value   = Number(Dolar(vldiscount.value)).toFixed(2);
            ipi.value          = Number(Dolar(ipi.value)).toFixed(2);
            peripi.value       = Number(Dolar(peripi.value)).toFixed(2);
            icms.value         = Number(Dolar(icms.value)).toFixed(2);
            pericms.value      = Number(Dolar(pericms.value)).toFixed(2);
            icmssubst.value    = Number(Dolar(icmssubst.value)).toFixed(2);
            pericmssubst.value = Number(Dolar(pericmssubst.value)).toFixed(2);

            /******************************/
            //Soma item ao totalilzador

            /* (Quantidade X Valor Unitário) - Desconto + IPI + ICMS Substituição */
            var vltotal = (Number(qtd) * Number(vlunity.value)) - Number(vldiscount.value) + Number(ipi.value) + Number(icmssubst.value);

            //console.log('Quantidade: '  + Number(qtd));
            //console.log('Unitário: '    + Number(vlunity.value));
            //console.log('Desconto: '    + Number(vldiscount.value));
            //console.log('IPI: '         + Number(ipi.value));
            //console.log('ICMS: '        + Number(icms.value));
            //console.log('ICMS Subst.: ' + Number(icmssubst.value));
            //console.log('Total: '       + Number(vltotal).toFixed(2));
            //console.log('***************');

            /******************************/
            //Adiciona as linhas da tabela

            var row1 = $('<tr style="font-size: 11px;">'), list_product, list_unity, list_quantity, actionButtons;
            
            list_product  = '<td colspan="4" class="text-nowrap">\n\
                                <input type="hidden" name="ProductList[' + idx + '][products_id]" id="list_id_product" value="' + id_product.value + '">\n\
                                <input type="hidden" name="ProductList[' + idx + '][products_title]" id="list_product" value="' + product.value + '">\n\
                                <input type="hidden" name="ProductList[' + idx + '][imobilizado]" id="list_imobilizado" value="' + imobilizado.checked + '">\n\
                                &nbsp;'+ id_product.value + ' - ' + product.value + 
                            '</td>';
            list_unity    = '<td class="text-center">\n\
                                <input type="hidden" name="ProductList[' + idx + '][unity]" id="list_unity" value="' + unity.value + '">\n\
                                &nbsp;' + unity.value + 
                            '</td>';
            list_quantity = '<td class="text-center">\n\
                                <input type="hidden" name="ProductList[' + idx + '][quantity]" id="list_quantity" value="' + String(qtd) + '">\n\
                                &nbsp;' + Real4(String(qtd)) + 
                            '</td>';
            actionButtons = '<td rowspan="2" class="text-center bg-gray" style="padding:12px;">\n\
                                <button onclick="EditTableRow(this)" type="button" class="btn btn-actions fa fa-pencil" style="vertical-align: middle;" title="Editar"></button>\n\
                                <button onclick="RemoveTableRow(this)" type="button" class="btn btn-actions fa fa-trash" style="vertical-align: middle;" title="Excluir"></button>\n\
                            </td>';

            var line1 = row1.append(list_product + list_unity + list_quantity + actionButtons);
            $("#products-table").append(row1);

            /**************/

            var row2 = $('<tr style="font-size: 11px;">'), list_vlunity, list_vldiscount, list_ipi, list_icms, list_icmssubst, list_vltotal;
            
            list_vlunity    = '<td class="text-right">\n\
                                <input type="hidden" name="ProductList[' + idx + '][vlunity]" id="list_vlunity" value="' + String(Number(vlunity.value).toFixed(4)) + '">\n\
                                &nbsp;' + Real4(String(Number(vlunity.value).toFixed(4))) + 
                              '</td>';
            list_vldiscount = '<td class="text-right">\n\
                                <input type="hidden" name="ProductList[' + idx + '][vldiscount]" id="list_vldiscount" value="' + String(vldiscount.value) + '">\n\
                                &nbsp;' + Real(String(Number(vldiscount.value).toFixed(2))) + 
                              '</td>';
            list_ipi        = '<td class="text-right">\n\
                                <input type="hidden" name="ProductList[' + idx + '][ipi]" id="list_ipi" value="' + String(ipi.value) + '">\n\
                                <input type="hidden" name="ProductList[' + idx + '][peripi]" id="list_peripi" value="' + String(peripi.value) + '">\n\
                                &nbsp;' + Real(String(Number(ipi.value).toFixed(2))) + ' (' + Real(String(Number(peripi.value).toFixed(2))) + ')' + 
                              '</td>';
            list_icms       = '<td class="text-right">\n\
                                <input type="hidden" name="ProductList[' + idx + '][icms]" id="list_icms" value="' + String(icms.value) + '">\n\
                                <input type="hidden" name="ProductList[' + idx + '][pericms]" id="list_pericms" value="' + String(pericms.value) + '">\n\
                                &nbsp;' + Real(String(Number(icms.value).toFixed(2))) + ' (' + Real(String(Number(pericms.value).toFixed(2))) + ')' + 
                              '</td>';
            list_icmssubst  = '<td class="text-right">\n\
                                <input type="hidden" name="ProductList[' + idx + '][icmssubst]" id="list_icmssubst" value="' + String(icmssubst.value) + '">\n\
                                <input type="hidden" name="ProductList[' + idx + '][pericmssubst]" id="list_pericmssubst" value="' + String(pericmssubst.value) + '">\n\
                                &nbsp;' + Real(String(Number(icmssubst.value).toFixed(2))) + ' (' + Real(String(Number(pericmssubst.value).toFixed(2))) + ')' + 
                              '</td>';
            list_vltotal    = '<td class="text-right">\n\
                                <input type="hidden" name="ProductList[' + idx + '][vltotal]" id="list_vltotal" value="' + String(Number(vltotal).toFixed(2)) + '">\n\
                                &nbsp;' + Real(String(Number(vltotal).toFixed(2))) + 
                              '</td>';

            var line2 = row2.append(list_vlunity + list_vldiscount + list_icms + list_ipi + list_icmssubst + list_vltotal);
            $("#products-table").append(row2);

            /******************************/

            //Atualiza os totais
            AtualizaTotais(line1[0].cells, line2[0].cells, false);

            /******************************/
            //Incrementa o índice
            idx += 1;

            /******************************/
            //Limpa campos

            id_product.value    = '';
            product.value       = '';
            imobilizado.checked = false;
            unity.value         = 'UN';
            quantity.value      = '';
            vlunity.value       = '';
            vldiscount.value    = '';
            ipi.value           = '';
            peripi.value        = '';
            icms.value          = '';
            pericms.value       = '';
            icmssubst.value     = '';
            pericmssubst.value  = '';
                
        };
        
        /**********************************************************************/
        
        EditTableRow = function (handler)
        {
            //Define variáveis
            var id_product   = document.querySelector('#products_id'),
                product      = document.querySelector('#products_title'),
                imobilizado  = document.querySelector('#edt_imobilizado'),
                unity        = document.querySelector('#edt_unity'),
                quantity     = document.querySelector('#edt_quantity'),
                vlunity      = document.querySelector('#edt_vlunity'),
                vldiscount   = document.querySelector('#edt_vldiscount'),
                ipi          = document.querySelector('#edt_ipi'),
                peripi       = document.querySelector('#edt_peripi'),
                icms         = document.querySelector('#edt_icms'),
                pericms      = document.querySelector('#edt_pericms'),
                icmssubst    = document.querySelector('#edt_icmssubst'),
                pericmssubst = document.querySelector('#edt_pericmssubst');

            /******************************/
            //Tratamento dos valores decimais

            quantity.value     = Number(Dolar4(quantity.value)).toFixed(4);
            vlunity.value      = Number(Dolar4(vlunity.value)).toFixed(4);
            vldiscount.value   = Number(Dolar(vldiscount.value)).toFixed(2);
            ipi.value          = Number(Dolar(ipi.value)).toFixed(2);
            peripi.value       = Number(Dolar(peripi.value)).toFixed(2);
            icms.value         = Number(Dolar(icms.value)).toFixed(2);
            pericms.value      = Number(Dolar(pericms.value)).toFixed(2);
            icmssubst.value    = Number(Dolar(icmssubst.value)).toFixed(2);
            pericmssubst.value = Number(Dolar(pericmssubst.value)).toFixed(2);

            /******************************/
            //Identifica a tag

            var tr    = $(handler).closest('tr');
            var line1 = tr[0].cells;
            var line2 = tr.next('tr')[0].cells;
            //var line2 = tr[0].nextSibling.cells;

            /******************************/
            //Identifica os valores das linhas

            for (i = 0; i < line1.length; i++) { 

                var inputs = line1[i].getElementsByTagName("input");

                for (ii = 0; ii < inputs.length; ii++) {

                    id = inputs[ii].id;
                    va = inputs[ii].value;

                    switch (id) {
                        case 'list_id_product':
                            id_product.value    = va;
                            break;
                        case 'list_product':
                            product.value       = String(va);
                            break;
                        case 'list_imobilizado':
                            imobilizado.checked = va;
                            break;
                        case 'list_unity':
                            unity.value         = String(va);
                            break;
                        case 'list_quantity':
                            quantity.value      = Real4(String(va));
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
                            vlunity.value      = Real4(String(va));
                            break;
                        case 'list_vldiscount':
                            vldiscount.value   = Real(String(va));
                            break;
                        case 'list_ipi':
                            ipi.value          = Real(String(va));
                            break;
                        case 'list_peripi':
                            peripi.value       = Real(String(va * 100));
                            break;
                        case 'list_icms':
                            icms.value         = Real(String(va));
                            break;
                        case 'list_pericms':
                            pericms.value      = Real(String(va * 100));
                            break;
                        case 'list_icmssubst':
                            icmssubst.value    = Real(String(va));
                            break;
                        case 'list_pericmssubst':
                            pericmssubst.value = Real(String(va * 100));
                            break;
                        case 'list_vltotal':
                            //Do nothing
                            break;
                    }//switch (id)

                }//for (ii = 0; ii < inputs.length; ii++)

            }//for (i = 0; i < line2.length; i++)

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
            var line2 = tr.next('tr')[0].cells;
            //var line2 = tr[0].nextSibling.cells;

            //Atualiza os totais
            AtualizaTotais(line1, line2, true);

            //Exclui a linha com delay animado
            tr.fadeOut(350, function () {
                //tr.remove();
                $(this).closest('tr').next().remove();
                $(this).closest('tr').remove();
            });

            return false;
        };
        
        /**********************************************************************/

        function AtualizaTotais(line1, line2, toDelete) {

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
                            toDelete ? vltotalproducts.value  = Number(vltotalproducts_value - Number(qtd * va)).toFixed(2) : vltotalproducts.value  = Number(vltotalproducts_value + Number(qtd * va)).toFixed(2);
                            totalproducts.innerHTML  = Real(String(Number(vltotalproducts.value).toFixed(2)));
                            break;
                        case 'list_vldiscount':
                            toDelete ? vltotaldiscount.value  = Number(vltotaldiscount_value - Number(va)).toFixed(2)       : vltotaldiscount.value  = Number(vltotaldiscount_value + Number(va)).toFixed(2);
                            totaldiscount.innerHTML  = Real(String(Number(vltotaldiscount.value).toFixed(2)));
                            break;
                        case 'list_icms':
                            toDelete ? vltotalicms.value      = Number(vltotalicms_value - Number(va)).toFixed(2)           : vltotalicms.value      = Number(vltotalicms_value + Number(va)).toFixed(2);
                            totalicms.innerHTML      = Real(String(Number(vltotalicms.value).toFixed(2)));
                            break;
                        case 'list_ipi':
                            toDelete ? vltotalipi.value       = Number(vltotalipi_value - Number(va)).toFixed(2)            : vltotalipi.value       = Number(vltotalipi_value + Number(va)).toFixed(2);
                            totalipi.innerHTML       = Real(String(Number(vltotalipi.value).toFixed(2)));
                            break;
                        case 'list_icmssubst':
                            toDelete ? vltotalicmssubst.value = Number(vltotalicmssubst_value - Number(va)).toFixed(2)      : vltotalicmssubst.value = Number(vltotalicmssubst_value + Number(va)).toFixed(2);
                            totalicmssubst.innerHTML = Real(String(Number(vltotalicmssubst.value).toFixed(2)));
                            break;
                        case 'list_vltotal':
                            toDelete ? vlgrandtotal.value     = Number(vlgrandtotal_value - Number(va)).toFixed(2)          : vlgrandtotal.value     = Number(vlgrandtotal_value + Number(va)).toFixed(2);
                            grandtotal.innerHTML     = Real(String(Number(vlgrandtotal.value).toFixed(2)));
                            break;
                    }//switch (id)

                }//for (ii = 0; ii < inputs.length; ii++)

            }//for (i = 0; i < line2.length; i++)
            
        }//function AtualizaTotais(line1, line2, toDelete)
        
        /**********************************************************************/

        //IPI
        function PerIPI() {

            //Identifica campos
            var quantity     = document.querySelector('#edt_quantity'),
                vlunity      = document.querySelector('#edt_vlunity'),
                ipi          = document.querySelector('#edt_ipi'),
                peripi       = document.querySelector('#edt_peripi');

            var quantity_value = 0,
                vlunity_value  = 0,
                ipi_val        = 0,
                peripi_val     = 0,
                result         = 0;

            try {

                if (quantity.value) quantity_value = Number(Dolar4(quantity.value)).toFixed(4);
                if (vlunity.value)  vlunity_value  = Number(Dolar4(vlunity.value)).toFixed(4);
                if (ipi.value)      ipi_val        = Number(Dolar(ipi.value)).toFixed(2);
                if (peripi.value)   peripi_val     = Number(Dolar(peripi.value)).toFixed(2);

                //Calcula total dos produtos
                totalproducts = quantity_value * vlunity_value;

                //Calcula o percentual do IPI
                if (ipi_val > 0 && !peripi_val) {

                    result = Real(String(Number((ipi_val * 100) / Number(totalproducts)).toFixed(2)));
                    peripi.value = result;
                    //console.log('PerIPI ' + result);

                }//if (ipi_val > 0 && !peripi_val)

            } catch (err) {

                console.log(err.message);

            }

        }//function PerIPI()

        /****************/

        function CalcIPI() {

            //Identifica campos
            var quantity     = document.querySelector('#edt_quantity'),
                vlunity      = document.querySelector('#edt_vlunity'),
                ipi          = document.querySelector('#edt_ipi'),
                peripi       = document.querySelector('#edt_peripi');

            var quantity_value = 0,
                vlunity_value  = 0,
                ipi_val        = 0,
                peripi_val     = 0,
                result         = 0;

            try {

                if (quantity.value) quantity_value = Number(Dolar4(quantity.value)).toFixed(4);
                if (vlunity.value)  vlunity_value  = Number(Dolar4(vlunity.value)).toFixed(4);
                if (ipi.value)      ipi_val        = Number(Dolar(ipi.value)).toFixed(2);
                if (peripi.value)   peripi_val     = Number(Dolar(peripi.value)).toFixed(2);

                //Calcula total dos produtos
                totalproducts = quantity_value * vlunity_value;

                //Calcula o valor do IPI
                if (peripi_val > 0 && !ipi_val) {

                    result = Real(String(Number(Number(totalproducts) * (peripi_val / 100)).toFixed(2)));
                    ipi.value = result;
                    //console.log('CalcIPI ' + result);

                }//if (peripi_val > 0 && !ipi_val)

            } catch (err) {

                console.log(err.message);

            }

        }//function CalcIPI()

        /**********************************************************************/

        //ICMS
        function PerICMS() {

            //Identifica campos
            var quantity     = document.querySelector('#edt_quantity'),
                vlunity      = document.querySelector('#edt_vlunity'),
                ipi          = document.querySelector('#edt_ipi'),
                icms         = document.querySelector('#edt_icms'),
                pericms      = document.querySelector('#edt_pericms'),
                imobilizado  = document.querySelector('#edt_imobilizado');

            var quantity_value = 0,
                vlunity_value  = 0,
                ipi_val        = 0,
                icms_val       = 0,
                pericms_val    = 0,
                result         = 0;

            try {

                //Evita erro de variável não informada
                if (quantity.value) quantity_value = Number(Dolar4(quantity.value)).toFixed(4);
                if (vlunity.value)  vlunity_value  = Number(Dolar4(vlunity.value)).toFixed(4);
                if (ipi.value)      ipi_val        = Number(Dolar(ipi.value)).toFixed(2);
                if (icms.value)     icms_val       = Number(Dolar(icms.value)).toFixed(2);
                if (pericms.value)  pericms_val    = Number(Dolar(pericms.value)).toFixed(2);

                //Calcula total dos produtos
                totalproducts  = quantity_value * vlunity_value;

                //Calcula o percentual do ICMS
                if (!pericms_val || pericms_val == 0) { //Percentual do ICMS não informado

                    if (icms_val > 0 && !imobilizado.checked) { //Não imobilizado

                        //Não considera o IPI na base de cálculo do ICMS
                        result = Real(String(Number((icms_val * 100) / Number(totalproducts)).toFixed(2)));
                        pericms.value = result;
                        //console.log('PerICMS ' + result);

                    } else if (icms_val > 0 && imobilizado.checked) { //Imobilizado

                        //Condiera o IPI na base de cálculo do ICMS
                        result = Real(String(Number((icms_val * 100) / (Number(totalproducts) + Number(ipi_val))).toFixed(2)));
                        pericms.value = result;
                        //console.log('PerICMS (c/IPI) ' + result);
                        
                    }//else if (icms_val > 0 && !pericms_val && imobilizado.checked)

                }//if (!pericms_val || pericms_val == 0)

                //console.log('Imobilizado ' + imobilizado.checked);

            } catch (err) {

                console.log(err.message);

            }

        }//function PerICMS()

        /****************/

        function CalcICMS() {

            //Identifica campos
            var quantity     = document.querySelector('#edt_quantity'),
                vlunity      = document.querySelector('#edt_vlunity'),
                ipi          = document.querySelector('#edt_ipi'),
                icms         = document.querySelector('#edt_icms'),
                pericms      = document.querySelector('#edt_pericms'),
                imobilizado  = document.querySelector('#edt_imobilizado');

            var quantity_value = 0,
                vlunity_value  = 0,
                ipi_val        = 0,
                icms_val       = 0,
                pericms_val    = 0,
                result         = 0;

            try {

                //Evita erro de variável não informada
                if (quantity.value) quantity_value = Number(Dolar4(quantity.value)).toFixed(4);
                if (vlunity.value)  vlunity_value  = Number(Dolar4(vlunity.value)).toFixed(4);
                if (ipi.value)      ipi_val        = Number(Dolar(ipi.value)).toFixed(2);
                if (icms.value)     icms_val       = Number(Dolar(icms.value)).toFixed(2);
                if (pericms.value)  pericms_val    = Number(Dolar(pericms.value)).toFixed(2);

                //Calcula total dos produtos
                totalproducts = quantity_value * vlunity_value;

                //Calcula o valor do ICMS
                if (!icms_val || icms_val == 0) { //valor do ICMS não preenchido

                    if (pericms_val > 0 && !imobilizado.checked) { //Não imobilizado

                        //Não considera o IPI na base de cálculo do ICMS
                        result = Real(String(Number(Number(totalproducts) * (pericms_val / 100)).toFixed(2)));
                        icms.value = result;
                        //console.log('CalcICMS ' + result);

                    } else if (pericms_val > 0 && imobilizado.checked) { //Imobilizado

                        //Considera o IPI na base de cálculo do ICMS
                        result = Real(String(Number((Number(totalproducts) + Number(ipi_val)) * (pericms_val / 100)).toFixed(2)));
                        icms.value = result;
                        //console.log('CalcICMS (c/IPI) ' + result);

                    }//else if (pericms_val > 0 && !icms_val && imobilizado.checked)

                }//if (!icms_val || icms_val == 0)

                //console.log('Imobilizado ' + imobilizado.checked);

            } catch (err) {

                console.log(err.message);

            }

        }//function CalcICMS()

        /**********************************************************************/

        //Calcula o ICMS de Substituição
        function PerICMSSubst() {

            //Identifica campos
            var quantity     = document.querySelector('#edt_quantity'),
                vlunity      = document.querySelector('#edt_vlunity'),
                ipi          = document.querySelector('#edt_ipi'),
                icmssubst    = document.querySelector('#edt_icmssubst'),
                pericmssubst = document.querySelector('#edt_pericmssubst'),
                imobilizado  = document.querySelector('#edt_imobilizado');

            var quantity_value   = 0,
                vlunity_value    = 0,
                ipi_val          = 0,
                icmssubst_val    = 0,
                pericmssubst_val = 0,
                result           = 0;

            try {

                //Evita erro de variável não informada
                if (quantity.value)     quantity_value   = Number(Dolar4(quantity.value)).toFixed(4);
                if (vlunity.value)      vlunity_value    = Number(Dolar4(vlunity.value)).toFixed(4);
                if (ipi.value)          ipi_val          = Number(Dolar(ipi.value)).toFixed(2);
                if (icmssubst.value)    icmssubst_val    = Number(Dolar(icmssubst.value)).toFixed(2);
                if (pericmssubst.value) pericmssubst_val = Number(Dolar(pericmssubst.value)).toFixed(2);

                //Calcula total dos produtos
                totalproducts  = quantity_value * vlunity_value;

                //Calcula o percentual do ICMS Substituição
                if (!pericmssubst_val || pericmssubst_val == 0) { //Percentual do ICMS não preenchido

                    if (icmssubst_val > 0 && !imobilizado.checked) { //Não imobilizado

                        //Não considera o IPI na base de cálculo do ICMS Substituição
                        result = Real(String(Number((icmssubst_val * 100) / Number(totalproducts)).toFixed(2)));
                        pericmssubst.value  = result;
                        //console.log('PerICMSSubst ' + result);

                    } else if (icmssubst_val > 0 && imobilizado.checked) { //Imobilizado

                        //Condiera o IPI na base de cálculo do ICMS Substituição
                        result = Real(String(Number((icmssubst_val * 100) / (Number(totalproducts) + Number(ipi_val))).toFixed(2)));
                        pericmssubst.value  = result;
                        //console.log('PerICMSSubst (c/IPI) ' + result);
                        
                    }//else if (icmssubst_val > 0 && !pericmssubst_val && imobilizado.checked)

                }//if (!pericmssubst_val || pericmssubst_val == 0)

                //console.log('Imobilizado ' + imobilizado.checked);
                
            } catch (err) {

                console.log(err.message);

            }

        }//function PerICMSSubst()

        /****************/

        function CalcICMSSubst() {

            //Identifica campos
            var quantity     = document.querySelector('#edt_quantity'),
                vlunity      = document.querySelector('#edt_vlunity'),
                ipi          = document.querySelector('#edt_ipi'),
                icmssubst    = document.querySelector('#edt_icmssubst'),
                pericmssubst = document.querySelector('#edt_pericmssubst'),
                imobilizado  = document.querySelector('#edt_imobilizado');

            var quantity_value   = 0,
                vlunity_value    = 0,
                ipi_val          = 0,
                icmssubst_val    = 0,
                pericmssubst_val = 0,
                result           = 0;

            try {

                //Evita erro de variável não informada
                if (quantity.value)     quantity_value   = Number(Dolar4(quantity.value)).toFixed(4);
                if (vlunity.value)      vlunity_value    = Number(Dolar4(vlunity.value)).toFixed(4);
                if (ipi.value)          ipi_val          = Number(Dolar(ipi.value)).toFixed(2);
                if (icmssubst.value)    icmssubst_val    = Number(Dolar(icmssubst.value)).toFixed(2);
                if (pericmssubst.value) pericmssubst_val = Number(Dolar(pericmssubst.value)).toFixed(2);

                //Calcula total dos produtos
                totalproducts  = quantity_value * vlunity_value;

                //Calcula o valor do ICMS Substituição
                if (!icmssubst_val || icmssubst_val == 0) { //Valor do ICMS de substituição não preenchido

                    if (pericmssubst_val > 0 && !imobilizado.checked) { //Não imobilizado

                        //Não considera o IPI na base de cálculo do ICMS Substituição
                        result = Real(String(Number(Number(totalproducts) * (pericmssubst_val / 100)).toFixed(2)));
                        icmssubst.value  = result;
                        //console.log('CalcICMSSubst ' + result);

                    } else if (pericmssubst_val > 0 && imobilizado.checked) { //Imobilizado

                        //Considera o IPI na base de cálculo do ICMS Substituição
                        result = Real(String(Number((Number(totalproducts) + Number(ipi_val)) * (pericmssubst_val / 100)).toFixed(2)));
                        icmssubst.value  = result;
                        //console.log('CalcICMSSubst (c/IPI) ' + result);

                    }//if (!icmssubst_val || icmssubst_val == 0)

                }//if (!icmssubst_val || icmssubst_val == 0)

                //console.log('Imobilizado ' + imobilizado.checked);

            } catch(err) {

                console.log(err.message);

            }

        }//function CalcICMSSubst()

        /**********************************************************************/

        var valIpi = $("input[name='ipi']"),
            perIpi = $("input[name='peripi']");

        valIpi.on("focusout", PerIPI);
        perIpi.on("focusout", CalcIPI);

        /****************/

        var valIcms = $("input[name='icms']"),
            perIcms = $("input[name='pericms']");

        valIcms.on("focusout", PerICMS);
        perIcms.on("focusout", CalcICMS);

        /****************/

        var valIcmsSubst = $("input[name='icmssubst']"),
            perIcmsSubst = $("input[name='pericmssubst']");

        valIcmsSubst.on("focusout", PerICMSSubst);
        perIcmsSubst.on("focusout", CalcICMSSubst);

        /**********************************************************************/
        
    });
})(jQuery);