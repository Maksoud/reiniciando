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
        
        /**********************************************************************/
        
        function totalPlanning()
        {
            var parcelas = $('#parcelas').val(),
                valor    = Number(Dolar($('#valor').val())),
                total    = valor * parcelas;
                total    = total.toFixed(2);
            
            $('#total').html(Real(String(total)));        
        }
        
        $('#parcelas').bind('focusout', totalPlanning);
        $('#valor').bind('focusout', totalPlanning);
        
        //** end code **//
    });
})(jQuery);