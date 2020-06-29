<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
?>

<?= $this->Html->script(['jquery-2.2.4.min',
                         //Plugin jQuery
                         'jquery.mask',
                         'jquery.maskMoney',
                         'jquery.countdownTimer.min',
                         'jquery.dataTables.min',
                         'jquery.cookie',
                         //Bootstrap
                         'bootstrap.min',
                         'bootstrap-multiselect',
                         'bootstrap-datepicker.min',
                         'bootstrap-datepicker.pt-BR.min',
                         //AdminLTE
                         '/plugins/slimScroll/jquery.slimscroll.min',
                         '/plugins/fastclick/fastclick',
                         'app.min',
                         //Extras
                         'maksoud-custom.min',
                         'maksoud-mask.min',
                         'scripts.min',
                         'typeahead.jquery',
                         'bloodhound',
                         'bootstrap-treeview.min',
	                     'jquery.joyride-2.1',
                         'maksoud-joyride.min',
                         //'multiclick.min', 01/03/2019
                         //Envio de formulários
                         'add-json.min'
                        ]) ?>

<!-- Custom styles to disable animation temporarily (inlined for show) -->
<style>
    /* Probably doesn't need all these prefixes but oh well */
    .disable-animations, .disable-animations * {
        /* CSS transitions */
        -o-transition-property: none !important;
        -moz-transition-property: none !important;
        -webkit-transition-property: none !important;
        transition-property: none !important;
        /* CSS transforms */
        -o-transform: none !important;
        -moz-transform: none !important;
        -webkit-transform: none !important;
        transform: none !important;
        /* CSS animations */
        -webkit-animation: none !important;
        -moz-animation: none !important;
        -o-animation: none !important;
        animation: none !important;
    }

    /* Collapsed lateral menu width */
    @media (min-width: 768px) {
        .sidebar-mini.sidebar-collapse .sidebar-menu>li:hover>a>span:not(.pull-right), 
        .sidebar-mini.sidebar-collapse .sidebar-menu>li:hover>.treeview-menu {
            width: 230px;
        }
        .sidebar-mini.sidebar-collapse .sidebar-menu>li:hover>a>.pull-right-container {
            left: 230px !important;
        }
    }
</style>

<script type="text/javascript">

    /*Close sidebar-open, when modal-open appears*/
    $(function ($) {
        $('body').on('shown.bs.modal', function () {
            $('body').removeClass('sidebar-open'); //AdminLTE
        });
    });

    //<!-- Custom scripts loaded AFTER AdminLTE JavaScript (inlined for show) -->
    /*Save menu state, collapsed or normal*/
    $(function ($) {
        
        // On click, capture state and save it in localStorage
        $($.AdminLTE.options.sidebarToggleSelector).click(function () {
            localStorage.setItem('sidebar', $('body').hasClass('sidebar-collapse') ? 1 : 0);
        });

        // On ready, read the set state and collapse if needed
        if (localStorage.getItem('sidebar') === '0') {
                $('body').addClass('disable-animations sidebar-collapse');
            requestAnimationFrame(function () {
                $('body').removeClass('disable-animations');
            });
        }//if (localStorage.getItem('sidebar') === '0')

    });

    /*Put class active on sidebar-menu when pagination is on the url*/
    $(function(){
        
        var url = window.location.pathname;  
        const _projectName = 'financeirov2';

        //console.log('URL: ' + url);

        $('.link_active').each(function(){  
            
            var link_url = this.href.split( '/' );
            var last_url = link_url[link_url.length - 1];
            var link_page = '';

            if (last_url.indexOf("?") != '-1') {
                last_url = last_url.split('?');
                link_page = '/' + link_url[link_url.length - 3] + '/' + link_url[link_url.length - 2] + '/' + last_url[0];
            } else if (last_url.indexOf("#") != '-1') {
                last_url = last_url.split('#');
                link_page = '/' + link_url[link_url.length - 3] + '/' + link_url[link_url.length - 2] + '/' + last_url[0];
            } else {

                if (link_url[link_url.length - 2] == _projectName) {
                    link_page = '/' + link_url[link_url.length - 2] + '/' + link_url[link_url.length - 1];
                } else {
                    link_page = '/' + link_url[link_url.length - 3] + '/' + link_url[link_url.length - 2] + '/' + link_url[link_url.length - 1];
                }
                
            }
            
            //console.log('link page: ' + link_page);

            if (url == link_page) { 
                //console.log('Match!');
                $(this).parent().addClass('active');
                $(this).parent().parent().parent().addClass('active');
            }

        });
    })

    /*Adjuste system menu on nav-top.ctp*/
    $(function(){
        $('.slimScrollDiv').each(function(){
            this.style.height = null;
        });
        $('.control-sidebar-menu').each(function(){
            this.style.height = null;
        });
    })

</script>