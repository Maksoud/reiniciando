<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="utf-8">

<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
<link rel="shortcut icon apple-touch-icon" href="{{ asset('img/favicon.png') }}" type="image/png" sizes="192x192">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

<link href="{{ asset('css/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-multiselect.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/maksoud.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-treeview.min.css') }}" rel="stylesheet">

<!--Fonte utilizada no 'Você sabia?' e login-->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet" type="text/css">

<title>
    Reiniciando Sistemas - @yield('title')
</title>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->