/**
 * Desenvolvido por:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

;
(function($){
    $(document).ready(function($){
        
        var context = $('#logo').attr('data-url'),
            url     = context + 'providers/json/';
        
        ////////////////////////////////////////////////////////////////////////
        
        var providersTitle = $('#providers_title');
        var providersId = $('#providers_id');
        var providersloading = $('.loadingProviders');
        var results = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: url + '?query=%QUERY',
                wildcard: '%QUERY'
            }
        });
        
        ////////////////////////////////////////////////////////////////////////

        providersTitle.typeahead({minLength: 1, highlight: true}, {
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

        providersTitle.bind('typeahead:select', function (ev, selected) {
            //console.log(selected);
            if (selected) {
                //console.log('Selected: ' + selected.id);
                providersId.val(selected.id);
            }
            providersloading.html(''); 
        });
        
        ////////////////////////////////////////////////////////////////////////

        providersTitle.bind('typeahead:active', function (ev, suggestion) {

        });

        providersTitle.bind('typeahead:asyncrequest', function (ev, suggestion) {
            providersloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        providersTitle.bind('typeahead:asyncreceive', function (ev, suggestion) {
            providersloading.html('');  
        });

        providersTitle.bind('typeahead:asynccancel', function (ev, suggestion) {
            providersloading.html('');  
        });
        
        //** end code **//
    });
})(jQuery);