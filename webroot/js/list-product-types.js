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
                url = context + 'product-types/json/';

        ////////////////////////////////////////////////////////////////////////

        var productTypesTitle = $('#types_title');
        var productTypesId = $('#product_types_id');
        var productTypesloading = $('.loadingProductTypes');
        var results = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: url + '?query=%QUERY',
                wildcard: '%QUERY'
            }
        });

        ////////////////////////////////////////////////////////////////////////

        productTypesTitle.typeahead({minLength: 0, highlight: true}, {
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

        productTypesTitle.bind('typeahead:select', function (ev, selected) {
            //console.log(selected);
            if (selected) {
                //console.log('Selected: ' + selected.id);
                productTypesId.val(selected.id);
            }
            productTypesloading.html(''); 
        });
        
        ////////////////////////////////////////////////////////////////////////

        productTypesTitle.bind('typeahead:active', function (ev, suggestion) {

        });

        productTypesTitle.bind('typeahead:asyncrequest', function (ev, suggestion) {
            productTypesloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        productTypesTitle.bind('typeahead:asyncreceive', function (ev, suggestion) {
            productTypesloading.html('');  
        });

        productTypesTitle.bind('typeahead:asynccancel', function (ev, suggestion) {
            productTypesloading.html('');  
        });

        //** end code **//
    });
})(jQuery);