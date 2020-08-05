<!-- Logo -->
<!--<a href="<?= $this->Url->build('/'); ?>" class="logo" style="background-color:#ecf0f5;">-->
<span class="logo" style="background-color:#ecf0f5;">
    <span class="logo-mini">
    	<a href="{{URL}}/Parameter/change" data-title="{{ __('Mudar de Perfil') }}">
    		<img src="{{asset('img/Reiniciando.png')}}" alt="logomarca" style="margin:-10px;width:138px;clip-path:inset(0px 108px 0px 0px); -webkit-clip-path: inset(0px 108px 0px 0px);">
    	</a>
    </span>
    <span class="logo-lg">
	    <a href="{{URL}}/Parameter/change" data-title="{{ __('Mudar de Perfil') }}">
    		<img src="{{asset('img/Reiniciando.png')}}" alt="logomarca" style="width:142px;margin-top:-13px;">
    	</a>
    </span>
</span>
<span id="logo" data-url="{{URL}}"></span>

<!-- Header Navbar: style can be found in header.less -->
@include('includes.nav-top')