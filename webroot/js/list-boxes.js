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
                url = context + 'boxes/json/';

        ////////////////////////////////////////////////////////////////////////

        var title     = $('#boxes_title'),
            titleDest = $('#boxes_title_dest'),
            boxesId   = $('#boxes_id'),
            boxesDest = $('#boxes_dest');
        var boxesloading = $('.loadingBoxes');
        var boxesDestloading = $('.loadingBoxesDest');
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
        
        titleDest.typeahead({minLength: 0, highlight: true}, {
            limit: 50,
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
                boxesId.val(selected.id);
            }
            boxesloading.html(''); 
        });
        
        titleDest.bind('typeahead:select', function (ev, selected) {
            //console.log(selected);
            if (selected) {
                //console.log('Selected: ' + selected.id);
                boxesDest.val(selected.id);
            }
            boxesDestloading.html(''); 
        });
        
        ////////////////////////////////////////////////////////////////////////

        title.bind('typeahead:active', function (ev, suggestion) {

        });

        title.bind('typeahead:asyncrequest', function (ev, suggestion) {
            boxesloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        title.bind('typeahead:asyncreceive', function (ev, suggestion) {
            boxesloading.html('');  
        });

        title.bind('typeahead:asynccancel', function (ev, suggestion) {
            boxesloading.html('');  
        });
        
        ////////////////////////////////////////////////////////////////////////

        titleDest.bind('typeahead:active', function (ev, suggestion) {

        });

        titleDest.bind('typeahead:asyncrequest', function (ev, suggestion) {
            boxesDestloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        titleDest.bind('typeahead:asyncreceive', function (ev, suggestion) {
            boxesDestloading.html('');  
        });

        titleDest.bind('typeahead:asynccancel', function (ev, suggestion) {
            boxesDestloading.html('');  
        });

        //** end code **//
    });
})(jQuery);