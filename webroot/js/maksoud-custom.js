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
        
        /**********************************************************************/
        //Formata número para moeda Real/Dolar
        /******************************************************************/
        
        //Formata valor para padrão brasileiro (9.999,00)
        function Real(v)
        {
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
            return v;
        };
        
        //Formata valor para padrão americano (9999.00)
        function Dolar(v)
        {
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
            return v;
        };
        
        /******************************************************************/
        //Calcula planos e descontos
        /******************************************************************/
        
        function calculaPlano()
        {
            if ($('select[name="plano"]').val() == 1) {
                if ($('select[name="periodo_ativacao"]').val() == 1) {
                    $('#mensalidade').val(Real(String('45,90')));
                    $('#mensalidade').html('45,90');
                    $('#vlrtotal').html('R$ 137,70');
                } else if ($('select[name="periodo_ativacao"]').val() == 2) {
                    $('#mensalidade').val(Real(String('42,90')));
                    $('#mensalidade').html('42,90');
                    $('#vlrtotal').html('R$ 257,40 (Desconto de R$ 18,00)');
                } else if ($('select[name="periodo_ativacao"]').val() == 3) {
                    $('#mensalidade').val(Real(String('39,90')));
                    $('#mensalidade').html('39,90');
                    $('#vlrtotal').html('R$ 478,80 (Desconto de R$ 72,00)');
                }
            } else if ($('select[name="plano"]').val() == 2) {
                if ($('select[name="periodo_ativacao"]').val() == 1) {
                    $('#mensalidade').val(Real(String('75,90')));
                    $('#mensalidade').html('75,90');
                    $('#vlrtotal').html('R$ 227,70');
                } else if ($('select[name="periodo_ativacao"]').val() == 2) {
                    $('#mensalidade').val(Real(String('72,90')));
                    $('#mensalidade').html('72,90');
                    $('#vlrtotal').html('R$ 437,40 (Desconto de R$ 18,00)');
                } else if ($('select[name="periodo_ativacao"]').val() == 3) {
                    $('#mensalidade').val(Real(String('69,90')));
                    $('#mensalidade').html('69,90');
                    $('#vlrtotal').html('R$ 838,80 (Desconto de R$ 72,00)');
                }
            } else if ($('select[name="plano"]').val() == 3) {
                if ($('select[name="periodo_ativacao"]').val() == 1) {
                    $('#mensalidade').val(Real(String('124,90')));
                    $('#mensalidade').html('124,90');
                    $('#vlrtotal').html('R$ 374,70');
                } else if ($('select[name="periodo_ativacao"]').val() == 2) {
                    $('#mensalidade').val(Real(String('122,90')));
                    $('#mensalidade').html('122,90');
                    $('#vlrtotal').html('R$ 737,40 (Desconto de R$ 12,00)');
                } else if ($('select[name="periodo_ativacao"]').val() == 3) {
                    $('#mensalidade').val(Real(String('119,90')));
                    $('#mensalidade').html('119,90');
                    $('#vlrtotal').html('R$ 1.438,80 (Desconto de R$ 60,00)');
                }
            }
        }
        
        function calculaPlanoDesconto(edit)
        {
            var plano1 = 45.90, 
                plano2 = 75.90, 
                plano3 = 124.90, 
                periodo1 = 3, 
                periodo2 = 6, 
                periodo3 = 12,
                desconto = null;
            
            if ($('select[name="plano"]').val() == 1) {
                if ($('select[name="periodo_ativacao"]').val() == 1) {
                    if (edit) { desconto = (plano1 * periodo1) - (Number(Dolar($('#mensalidade').val())) * 3); }
                    else { desconto = (plano1 * periodo1) - (Number(Dolar($('#mensalidade').html())) * 3); }
                    desconto = desconto.toFixed(2);
                    return Real(String(desconto));
                } else if ($('select[name="periodo_ativacao"]').val() == 2) {
                    if (edit) { desconto = (plano1 * periodo2) - (Number(Dolar($('#mensalidade').val())) * 6); }
                    else { desconto = (plano1 * periodo2) - (Number(Dolar($('#mensalidade').html())) * 6); }
                    desconto = desconto.toFixed(2);
                    return Real(String(desconto));
                } else if ($('select[name="periodo_ativacao"]').val() == 3) {
                    if (edit) { desconto = (plano1 * periodo3) - (Number(Dolar($('#mensalidade').val())) * 12); }
                    else { desconto = (plano1 * periodo3) - (Number(Dolar($('#mensalidade').html())) * 12); }
                    desconto = desconto.toFixed(2);
                    return Real(String(desconto));
                }
            } else if ($('select[name="plano"]').val() == 2) {
                if ($('select[name="periodo_ativacao"]').val() == 1) {
                    if (edit) { desconto = (plano2 * periodo1) - (Number(Dolar($('#mensalidade').val())) * 3); }
                    else { desconto = (plano2 * periodo1) - (Number(Dolar($('#mensalidade').html())) * 3); }
                    desconto = desconto.toFixed(2);
                    return Real(String(desconto));
                } else if ($('select[name="periodo_ativacao"]').val() == 2) {
                    if (edit) { desconto = (plano2 * periodo2) - (Number(Dolar($('#mensalidade').val())) * 6); }
                    else { desconto = (plano2 * periodo2) - (Number(Dolar($('#mensalidade').html())) * 6); }
                    desconto = desconto.toFixed(2);
                    return Real(String(desconto));
                } else if ($('select[name="periodo_ativacao"]').val() == 3) {
                    if (edit) { desconto = (plano2 * periodo3) - (Number(Dolar($('#mensalidade').val())) * 12); }
                    else { desconto = (plano2 * periodo3) - (Number(Dolar($('#mensalidade').html())) * 12); }
                    desconto = desconto.toFixed(2);
                    return Real(String(desconto));
                }
            } else if ($('select[name="plano"]').val() == 3) {
                if ($('select[name="periodo_ativacao"]').val() == 1) {
                    if (edit) { desconto = (plano3 * periodo1) - (Number(Dolar($('#mensalidade').val())) * 3); }
                    else { desconto = (plano3 * periodo1) - (Number(Dolar($('#mensalidade').html())) * 3); }
                    desconto = desconto.toFixed(2);
                    return Real(String(desconto));
                } else if ($('select[name="periodo_ativacao"]').val() == 2) {
                    if (edit) { desconto = (plano3 * periodo2) - (Number(Dolar($('#mensalidade').val())) * 6); }
                    else { desconto = (plano3 * periodo2) - (Number(Dolar($('#mensalidade').html())) * 6); }
                    desconto = desconto.toFixed(2);
                    return Real(String(desconto));
                } else if ($('select[name="periodo_ativacao"]').val() == 3) {
                    if (edit) { desconto = (plano3 * periodo3) - (Number(Dolar($('#mensalidade').val())) * 12); }
                    else { desconto = (plano3 * periodo3) - (Number(Dolar($('#mensalidade').html())) * 12); }
                    desconto = desconto.toFixed(2);
                    return Real(String(desconto));
                }
            }
        }
        
        function calculaPlanoEspecial()
        {
            var total = null,
                edit = $('input[name="data[Parameter][mensalidade]"]').val();
            
            if (edit) {
                if ($('select[name="data[Parameter][periodo_ativacao]"]').val() == 1) {
                    total = Number(Dolar($('input[name="data[Parameter][mensalidade]"]').val())) * 3;
                    total = total.toFixed(2);
                    $('#vlrtotal').html(Real(String(total)) + ' (Desconto de R$ '+ calculaPlanoDesconto(edit) +')');
                } else if ($('select[name="data[Parameter][periodo_ativacao]"]').val() == 2) {
                    total = Number(Dolar($('input[name="data[Parameter][mensalidade]"]').val())) * 6;
                    total = total.toFixed(2);
                    $('#vlrtotal').html(Real(String(total)) + ' (Desconto de R$ '+ calculaPlanoDesconto(edit) +')');
                } else if ($('select[name="data[Parameter][periodo_ativacao]"]').val() == 3) {
                    total = Number(Dolar($('input[name="data[Parameter][mensalidade]"]').val())) * 12;
                    total = total.toFixed(2);
                    $('#vlrtotal').html(Real(String(total)) + ' (Desconto de R$ '+ calculaPlanoDesconto(edit) +')');
                }
            } else {
                if ($('select[name="data[Parameter][periodo_ativacao]"]').val() == 1) {
                    total = Number(Dolar($('#mensalidade').html())) * 3;
                    total = total.toFixed(2);
                    $('#vlrtotal').html(Real(String(total)) + ' (Desconto de R$ '+ calculaPlanoDesconto(edit) +')');
                } else if ($('select[name="data[Parameter][periodo_ativacao]"]').val() == 2) {
                    total = Number(Dolar($('#mensalidade').html())) * 6;
                    total = total.toFixed(2);
                    $('#vlrtotal').html(Real(String(total)) + ' (Desconto de R$ '+ calculaPlanoDesconto(edit) +')');
                } else if ($('select[name="data[Parameter][periodo_ativacao]"]').val() == 3) {
                    total = Number(Dolar($('#mensalidade').html())) * 12;
                    total = total.toFixed(2);
                    $('#vlrtotal').html(Real(String(total)) + ' (Desconto de R$ '+ calculaPlanoDesconto(edit) +')');
                }
            }
            //alert(calculaPlanoDesconto());
        }
        
        $('select[name="plano"]').on('change', function() {
            calculaPlano();
        });
        $('select[name="periodo_ativacao"]').on('change', function() {
            calculaPlano();
        });
        $('input[name="mensalidade"]').bind('focusout', function() {
            calculaPlanoEspecial();
        });
        calculaPlanoEspecial();
        
        /******************************************************************/
        //Checbox multiselec
        /******************************************************************/
        
        var lastChecked = null;
        var handleChecked = function(e) {
            if (lastChecked && e.shiftKey) {
                var i = $('input[type="checkbox"]').index(lastChecked);
                var j = $('input[type="checkbox"]').index(e.target);
                var checkboxes = [];
                if (j > i) {
                    checkboxes = $('input[type="checkbox"]:gt('+ (i-1) +'):lt('+ (j-i) +')');
                } else {
                    checkboxes = $('input[type="checkbox"]:gt('+ j +'):lt('+ (i-j) +')');
                }

                if (!$(e.target).is(':checked')) {
                    $(checkboxes).removeAttr('checked');
                } else {
                    $(checkboxes).attr('checked', 'checked');
                }
            }
            lastChecked = e.target;
            // Other click action code.
        };
        $('input[type=checkbox]').click(handleChecked);
        
        //select all checkboxes
        $("#select_all").change(function() { 
            //change all "input[type=checkbox]" checked status
            $('input[type=checkbox]').prop('checked', $(this).prop("checked")); 
        });

        $('input[type=checkbox]').change(function() { 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if (false == $(this).prop("checked")) { //if this item is unchecked
                $("#select_all").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('input[type=checkbox]:checked').length == $('input[type=checkbox]').length ) {
                $("#select_all").prop('checked', true);
            }
        });
        
        //** end code **//
    });
})(jQuery);