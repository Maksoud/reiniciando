<div id="footer">
	
	<script src="{{ asset('js/bloodhound.js') }}"></script>
	<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-datepicker.pt-BR.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-multiselect.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-treeview.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>	
	<script src="{{ asset('js/calcula-vencimento-cartao.min.js') }}"></script>
	<script src="{{ asset('js/Chart.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/datatables.min.js') }}"></script>
	<script src="{{ asset('js/jquery.countdownTimer.min.js') }}"></script>
	<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
	<script src="{{ asset('js/jquery.maskMoney.js') }}"></script>
	<script src="{{ asset('js/jquery.min.js') }}"></script>	
	<script src="{{ asset('js/list-account-plans.min.js') }}"></script>
	<script src="{{ asset('js/list-banks.min.js') }}"></script>
	<script src="{{ asset('js/list-boxes.min.js') }}"></script>
	<script src="{{ asset('js/list-cards.min.js') }}"></script>
	<script src="{{ asset('js/list-costs.min.js') }}"></script>
	<script src="{{ asset('js/list-customers.min.js') }}"></script>
	<script src="{{ asset('js/list-document-types.min.js') }}"></script>
	<script src="{{ asset('js/list-event-types.min.js') }}"></script>
	<script src="{{ asset('js/list-movements.min.js') }}"></script>
	<script src="{{ asset('js/list-providers.min.js') }}"></script>
	<script src="{{ asset('js/maksoud-custom.min.js') }}"></script>
	<script src="{{ asset('js/maksoud-focus.min.js') }}"></script>
	<script src="{{ asset('js/maksoud-mask.min.js') }}"></script>
	<script src="{{ asset('js/maksoud-movements.min.js') }}"></script>
	<script src="{{ asset('js/maksoud-plannings.min.js') }}"></script>
	<script src="{{ asset('js/maksoud-radiooptions.min.js') }}"></script>
	<script src="{{ asset('js/maksoud-text.min.js') }}"></script>
	<script src="{{ asset('js/multiclick.min.js') }}"></script>
	<script src="{{ asset('js/scripts.min.js') }}"></script>
	<script src="{{ asset('js/typeahead.jquery.js') }}"></script>
	<script src="{{ asset('js/validaCpfCnpj.min.js') }}"></script>
	
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
</div>