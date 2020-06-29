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
                url = context + 'product-groups/json/';

        ////////////////////////////////////////////////////////////////////////

        var productGroupsTitle = $('#groups_title');
        var productGroupsId = $('#product_groups_id');
        var productGroupsloading = $('.loadingProductGroups');
        var results = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: url + '?query=%QUERY',
                wildcard: '%QUERY'
            }
        });

        ////////////////////////////////////////////////////////////////////////

        productGroupsTitle.typeahead({minLength: 0, highlight: true}, {
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

        productGroupsTitle.bind('typeahead:select', function (ev, selected) {
            //console.log(selected);
            if (selected) {
                //console.log('Selected: ' + selected.id);
                productGroupsId.val(selected.id);
            }
            productGroupsloading.html(''); 
        });
        
        ////////////////////////////////////////////////////////////////////////

        productGroupsTitle.bind('typeahead:active', function (ev, suggestion) {

        });

        productGroupsTitle.bind('typeahead:asyncrequest', function (ev, suggestion) {
            productGroupsloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        productGroupsTitle.bind('typeahead:asyncreceive', function (ev, suggestion) {
            productGroupsloading.html('');  
        });

        productGroupsTitle.bind('typeahead:asynccancel', function (ev, suggestion) {
            productGroupsloading.html('');  
        });

        //** end code **//
    });
})(jQuery);