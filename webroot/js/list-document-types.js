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
                url = context + 'document-types/json/';

        ////////////////////////////////////////////////////////////////////////

        var title           = $('#document_types_title'),
            documentTypesId = $('#document_types_id');
        var documentTypesloading = $('.loadingDocuments');
        var results = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: url + '?query=%QUERY',
                wildcard: '%QUERY'
            }
        });
        
        ////////////////////////////////////////////////////////////////////////
        
        title.typeahead({minLength: 0, highlight: true}, {
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
        
        title.bind('typeahead:select', function (ev, selected) {
            //console.log(selected);
            if (selected) {
                //console.log('Selected: ' + selected.id);
                documentTypesId.val(selected.id);
            }
            documentTypesloading.html(''); 
        });
        
        ////////////////////////////////////////////////////////////////////////

        title.bind('typeahead:active', function (ev, suggestion) {

        });

        title.bind('typeahead:asyncrequest', function (ev, suggestion) {
            documentTypesloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        title.bind('typeahead:asyncreceive', function (ev, suggestion) {
            documentTypesloading.html('');  
        });

        title.bind('typeahead:asynccancel', function (ev, suggestion) {
            documentTypesloading.html('');  
        });

        //** end code **//
    });
})(jQuery);