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

        var context = $('#logo').attr('data-url'),
                url = context + 'customers/json/';

        ////////////////////////////////////////////////////////////////////////

        var customersTitle = $('#customers_title');
        var customersId = $('#customers_id');
        var customersloading = $('.loadingCustomers');
        var results = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: url + '?query=%QUERY',
                wildcard: '%QUERY'
            }
        });

        ////////////////////////////////////////////////////////////////////////

        customersTitle.typeahead({minLength: 1, highlight: true}, {
            limit: 20,
            display: 'value',
            source: results,
            templates: {
            	empty: [
            	  '<div class="empty-message">',
            		'Nada encontrado, tente cadastrar um novo.',
            	  '</div>'
            	].join('\n')
            }
        });

        customersTitle.bind('typeahead:select', function (ev, selected) {
            //console.log(selected);
            if (selected) {
                //console.log('Selected: ' + selected.id);
                customersId.val(selected.id);
            }
            customersloading.html(''); 
        });
        
        ////////////////////////////////////////////////////////////////////////

        customersTitle.bind('typeahead:active', function (ev, suggestion) {

        });

        customersTitle.bind('typeahead:asyncrequest', function (ev, suggestion) {
            customersloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        customersTitle.bind('typeahead:asyncreceive', function (ev, suggestion) {
            customersloading.html('');  
        });

        customersTitle.bind('typeahead:asynccancel', function (ev, suggestion) {
            customersloading.html('');  
        });

        //** end code **//
    });
})(jQuery);