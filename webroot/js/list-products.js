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
                url = context + 'products/json/';

        ////////////////////////////////////////////////////////////////////////

        var productsTitle = $('#products_title');
        var productsId = $('#products_id');
        var productsloading = $('.loadingProducts');
        var results = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: url + '?query=%QUERY',
                wildcard: '%QUERY'
            }
        });

        ////////////////////////////////////////////////////////////////////////

        productsTitle.typeahead({minLength: 3, highlight: true}, {
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

        productsTitle.bind('typeahead:select', function (ev, selected) {
            //console.log(selected);
            if (selected) {
                //console.log('Selected: ' + selected.id);
                productsId.val(selected.id);
            }
            productsloading.html(''); 
        });
        
        ////////////////////////////////////////////////////////////////////////

        productsTitle.bind('typeahead:active', function (ev, suggestion) {

        });

        productsTitle.bind('typeahead:asyncrequest', function (ev, suggestion) {
            productsloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        productsTitle.bind('typeahead:asyncreceive', function (ev, suggestion) {
            productsloading.html('');  
        });

        productsTitle.bind('typeahead:asynccancel', function (ev, suggestion) {
            productsloading.html('');  
        });

        //** end code **//
    });
})(jQuery);