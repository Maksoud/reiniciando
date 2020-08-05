@extends('layouts.login')

@section('content')
	<div class="container-fluid estrutura">
		<div class="mx-auto col-sm-5 mt-5 mb-5 p-4 form_login">
	            
            @if (isset($errors) && count($errors)>0)
        
                <div class="text-nowrap text-center mt-4 mb-4 p-2 alert-danger">
	                
                    @foreach ($errors->all() as $error)
                    	
                    	{{$error}}
                    	
                    @endforeach
                    
                </div>
            
            @endif
            
            <h3 style="color: #286090;">
                <i class="fa fa-sign-in font-24"></i> <?= __('Entrar no sistema') ?>
            </h3>
            
            <div class="mt-5">
            
            	<form method="POST" action="{{ route('login') }}">
                	@csrf
                	
                    <div class="form-group w-75 mx-auto">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail de acesso" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group w-75 mx-auto">
                        <input id="password" type="password" class="input-group form-control @error('password') is-invalid @enderror" name="password" placeholder="Senha de acesso" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group w-75 mx-auto">
                        <div class="row form-inline">
                            <div class="col-xs-12 col-md-5 ml-3 d-flex justify-content-start form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Lembrar senha') }}
                                </label>
                            </div>
                            <div class="col-xs-12 col-md-6 d-flex justify-content-end">
	                            @if (Route::has('password.request'))
	                                <a class="btn btn-link" href="{{ route('password.request') }}">
	                                    {{ __('Esqueceu a senha?') }}
	                                </a>
	                            @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="row col-xs-12 offset-md-1 col-md-10">
                        <div class="col-xs-12 col-md-6 mt-2 mb-5">
                            <button type="submit" class="btn btn-primary" style="height:42px;font-size:18px;width:105px;">
                                {{ __('Entrar') }}
                            </button>
                        </div>
                        <div class="col-xs-12 col-md-6 text-center" style="font-size:12px;">
		                    {{ __('Ainda não tem uma conta?') }}<br>
		                    <strong>{{ __('Aproveite 30 dias grátis!') }}</strong>
	                    	<a href="https://reiniciando.maksoud.dev/register" class="btn btn-link">{{ __('Cadastre-se') }}</a><br>
		                </div>
                    </div>
                	
                </form>
                
            </div>
        </div>
	</div>
	@include('includes.modal')
@endsection