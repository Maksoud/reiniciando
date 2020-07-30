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
                url = context + 'account-plans/json/';

        ////////////////////////////////////////////////////////////////////////

        var title       = $('#account_plans_title'),
            titleDest   = $('#account_plans_title_dest'),
            accountId   = $('#account_plans_id'),
            accountDest = $('#account_plans_dest');
        var accountloading = $('.loadingAccounts');
        var accountDestloading = $('.loadingAccountsDest');
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
                accountId.val(selected.id);
            }
            accountloading.html(''); 
        });
        
        titleDest.bind('typeahead:select', function (ev, selected) {
            //console.log(selected);
            if (selected) {
                //console.log('Selected: ' + selected.id);
                accountDest.val(selected.id);
            }
            accountDestloading.html(''); 
        });
        
        ////////////////////////////////////////////////////////////////////////

        title.bind('typeahead:active', function (ev, suggestion) {

        });

        title.bind('typeahead:asyncrequest', function (ev, suggestion) {
            accountloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        title.bind('typeahead:asyncreceive', function (ev, suggestion) {
            accountloading.html('');  
        });

        title.bind('typeahead:asynccancel', function (ev, suggestion) {
            accountloading.html('');  
        });
        
        ////////////////////////////////////////////////////////////////////////

        titleDest.bind('typeahead:active', function (ev, suggestion) {

        });

        titleDest.bind('typeahead:asyncrequest', function (ev, suggestion) {
            accountDestloading.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');
        });

        titleDest.bind('typeahead:asyncreceive', function (ev, suggestion) {
            accountDestloading.html('');  
        });

        titleDest.bind('typeahead:asynccancel', function (ev, suggestion) {
            accountDestloading.html('');  
        });

        //** end code **//
    });
})(jQuery);