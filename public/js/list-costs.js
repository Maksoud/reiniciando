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
                url = context + 'costs/json/';

        ////////////////////////////////////////////////////////////////////////

        var title     = $('#costs_title'),
            titleDest = $('#costs_title_dest'),
            costsId   = $('#costs_id'),
            costsDest = $('#costs_dest');
        var costsloading = $('.loadingCosts');
        var costsDestloading = $('.loadingCostsDest');
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
                costsId.val(selected.id);
            }
            costsloading.html(''); 
        });
        
        titleDest.bind('typeahead:select', function (ev, selected) {
            //console.log(selected);
            if (selected) {
                //console.log('Selected: ' + selected.id);
                costsDest.val(selected.id);
            }
            costsDestloading.html(''); 
        });
        
        ////////////////////////////////////////////////////////////////////////

        title.bind('typeahead:active', function (ev, suggestion) {

        });

        title.bind('typeahead:asyncrequest', function (ev, suggestion) {
            costsloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        title.bind('typeahead:asyncreceive', function (ev, suggestion) {
            costsloading.html('');  
        });

        title.bind('typeahead:asynccancel', function (ev, suggestion) {
            costsloading.html('');  
        });
        
        ////////////////////////////////////////////////////////////////////////

        titleDest.bind('typeahead:active', function (ev, suggestion) {

        });

        titleDest.bind('typeahead:asyncrequest', function (ev, suggestion) {
            costsDestloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        titleDest.bind('typeahead:asyncreceive', function (ev, suggestion) {
            costsDestloading.html('');  
        });

        titleDest.bind('typeahead:asynccancel', function (ev, suggestion) {
            costsDestloading.html('');  
        });

        //** end code **//
    });
})(jQuery);