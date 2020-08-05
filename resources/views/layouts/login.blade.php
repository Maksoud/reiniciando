<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	    <!-- CSRF Token -->
	    <meta name="csrf-token" content="{{ csrf_token() }}">
	
	    <title>{{ config('app.name', 'Login') }}</title>
	    
	    <!-- Scripts -->
	    <script src="{{ asset('js/app.js') }}"></script>
	
	    <!-- Fonts -->
	    <link rel="dns-prefetch" href="//fonts.gstatic.com">
	    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	
	    <!-- Styles -->
	    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	    <link href="{{ asset('css/login.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
	</head>
	
	<body style="font-family:'Roboto Condensed',sans-serif;font-size:14px;">
	    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
	        <div class="container">
		        
	            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
	                <span class="navbar-toggler-icon"></span>
	            </button>
	
	            <div class="collapse navbar-collapse" id="navbarSupportedContent">
		            
	                <!-- Left Side Of Navbar -->
	                <ul class="navbar-nav mr-auto">
			            <a id="logo" class="pull-right" href="https://reiniciando.maksoud.dev/">
				            <img src="{{ asset('img/Reiniciando.png') }}" class="img-responsive" style="width: 200px; margin-bottom: 10px; margin-left:-15px;" alt="Logotipo Reiniciando Sistemas">
			            </a>
	                </ul>
	
	                <!-- Right Side Of Navbar -->
	                <ul class="navbar-nav ml-auto">
		                
	                    <!-- Authentication Links -->
	                    @guest
	                        <li class="nav-item">
	                            <a class="nav-link" href="{{ route('login') }}">{{ __('Entrar') }}</a>
	                        </li>
	                        @if (Route::has('register'))
	                            <li class="nav-item">
	                                <a class="nav-link" href="{{ route('register') }}">{{ __('Cadastre-se') }}</a>
	                            </li>
	                        @endif
	                    @else
	                        <li class="nav-item dropdown">
	                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
	                                {{ Auth::user()->name }} <span class="caret"></span>
	                            </a>
	
	                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
	                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
	                                    {{ __('Sair') }}
	                                </a>
	
	                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                    @csrf
	                                </form>
	                            </div>
	                        </li>
	                    @endguest
	                    
	                </ul>
	                
	            </div>
	            
	        </div>
	    </nav>

        <main class="bg_login">
            @yield('content')
        </main>
        
        <footer>
            @include('includes.footer')
        </footer>
	</body>
</html>
