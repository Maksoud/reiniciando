const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 
mis.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
 */

mix.styles(['resources/css/AdminLTE.css',
		    'resources/css/bootstrap-datepicker3.min.css',
		    'resources/css/bootstrap-multiselect.css',
		    'resources/css/bootstrap-treeview.min.css',
		    'resources/css/bootstrap.css',
		    'resources/css/dataTables.bootstrap.css',
		    'resources/css/datatables.css',
		    'resources/css/font-awesome.css',
		    'resources/css/home.css',
		    'resources/css/jquery.dataTables.css',
		    'resources/css/login.css',
		    'resources/css/maksoud.css'
	], 'public/css/style.css')
	.scripts(['resources/js/.js',
		'resources/js/bootstrap.js',
		'resources/js/bloodhound.js',
		'resources/js/bootstrap-datepicker.js',
		'resources/js/bootstrap-datepicker.pt-BR.min.js',
		'resources/js/bootstrap-multiselect.js',
		'resources/js/bootstrap-treeview.js',
		'resources/js/dataTables.bootstrap.js',
		'resources/js/datatables.min.js',
		'resources/js/jquery.countdownTimer.js',
		'resources/js/jquery.mask.js',
		'resources/js/jquery.maskMoney.js',
		'resources/js/jquery.min.js',
		'resources/js/calcula-vencimento-cartao.js',
		'resources/js/list-account-plans.js',
		'resources/js/list-costs.js',
		'resources/js/list-banks.js',
		'resources/js/list-boxes.js',
		'resources/js/list-cards.js',
		'resources/js/list-customers.js',
		'resources/js/list-providers.js',
		'resources/js/list-document-types.js',
		'resources/js/list-event-types.js',
		'resources/js/list-movements.js',
		'resources/js/maksoud-movements.js',
		'resources/js/maksoud-plannings.js',
		'resources/js/maksoud-custom.js',
		'resources/js/maksoud-focus.js',
		'resources/js/maksoud-mask.js',
		'resources/js/maksoud-validaCpfCnpj.js',
		'resources/js/maksoud-radiooptions.js',
		'resources/js/maksoud-text.js',
		'resources/js/maksoud-multiclick.js',
		'resources/js/scripts.js',
		'resources/js/typeahead.jquery.js'
	], 'public/js/scripts.js')
    .version();