<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} ">
	<head>
		@include('includes.head')
	</head>
	
	<body class="sidebar-mini" style="padding-top:0px;">
		
        <!-- Site wrapper -->
        <div class="wrapper" style="background-color:#ecf0f5;">
			
			<div class="bg_ajax">
	            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
	            Carregando
	        </div>
			
			<header class="main-header">
				@include('includes.header')
			</header>
			
			<!-- Left side column. contains the sidebar -->
			<aside class="main-sidebar">

			    <!-- sidebar: style can be found in sidebar.less -->
			    <section class="sidebar" style="background-color:#222D32;">
			
			        <!-- sidebar menu: : style can be found in sidebar.less -->
			        @include('includes.sidebar-menu')
			
			    </section>
			    <!-- /.sidebar -->
			</aside>

            <!-- =============================================== -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

				@if (isset($errors) && count($errors)>0)
                
	                <div class="text-nowrap text-center m-t-4 m-b-4 p-2 alert-danger">
		                
	                    @foreach ($errors->all() as $error)
	                    	
	                    	{{$error}}
	                    	
	                    @endforeach
	                    
	                </div>
                
                @endif
                
                <main class="py-4">
		            @yield('content')
		        </main>
                
                @include('includes.modal')

            </div>
            
            <!-- /.content-wrapper -->

        </div>

        <!-- ./wrapper -->
		
        <footer>
            @include('includes.footer')
        </footer>
	</body>
</html>