@extends('layouts.app')

@section('content')

	<script type="text/javascript" src="{{ asset('js/Chart.js') }}"></script>
	
	<!-- /////////////////////////////////////////////////////////////////////// -->
	
	<div class="col-xs-12 panel">
	    <div class="col-xs-12 col-sm-4 text-nowrap">
	        <h4>{{ __('Bem vindo(a)') }} @if (session('username')) {{ session('username') }} @endif</h4>
	    </div>
	    <div class="col-xs-12 col-sm-4 text-nowrap text-right pull-right">
	        <span style="color: #777777">
	            <h4><?= date('d/m/Y')); ?> - <span id="timer"><?= date('H:i:s'); ?></span></h4>
	        </span>
	    </div>
	</div>
	
	<!-- /////////////////////////////////////////////////////////////////////// -->
	
	<div class="col-xs-12 col-sm-5">
		
		@if ($balances)
		
			@section('dashboard.bankbox_balances')
			
		@endif
		
	    <!-- /////////////////////////////////////////////////////////////////// -->
	    
	    @if (session('parameter_plan') != 4)
	    	
	    	@section('dashboard.cards_balances')
	        @section('dashboard.plannings_progress')
	        
	    @endif
	    
	    <!-- /////////////////////////////////////////////////////////////////// -->
	    
	    @section('dashboard.financial_extracts')
	
	</div>
	
	<!-- /////////////////////////////////////////////////////////////////////// -->
	
	<div class="col-xs-12 col-sm-4">
		
		@section('dashboard.chart')
		
	    <!-- /////////////////////////////////////////////////////////////////// -->
	    
	    @if ($cards_expenses)
	    
		    @section('dashboard.cards_expenses')
	    
	    @endif
	    
	    <!-- /////////////////////////////////////////////////////////////////// -->
	    
	    @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
	    
	    	@section('dashboard.account_plans')
	    
	    @endif
	    
	    <!-- /////////////////////////////////////////////////////////////////// -->
	    
	    @if ($plannings)
	    
		    @section('dashboard.plannings')
	    
	    @endif
	    
	</div>
	
	<!-- /////////////////////////////////////////////////////////////////////// -->
	
	<div class="col-xs-12 col-sm-3 pull-right">
	    
	    @section('dashboard.knowledge')
	    @section('dashboard.shortcuts')
	    
	</div>
	
	<!-- /////////////////////////////////////////////////////////////////////// -->
	
	@if ($plannings)
	
		<div class="box panel panel-default box-shadow" style="padding:0;">
	
			@section('dashboard.transfers')
			
		</div>
	
	@endif
	
	<!-- /////////////////////////////////////////////////////////////////////// -->
	
	<div class="col-xs-12 m-b-10" id="relacaoReceitas">
		
		@section('dashboard.incomes')
	    
	</div>
	
	<!-- /////////////////////////////////////////////////////////////////////// -->
	
	<div class="col-xs-12 m-b-10" id="relacaoDespesas">
		
		@section('dashboard.expenses')
		
	</div>
	
	<div class="col-xs-12 m-b-20">
		
	    &nbsp;<!-- /////////////////////////////////////////////////////////////////// -->
	    
	</div>

@endsection