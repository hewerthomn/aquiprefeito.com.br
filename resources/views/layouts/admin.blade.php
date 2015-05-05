<!DOCTYPE html>
<html lang="pt-BR" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AquiPrefeito! - {{ isset($title) ? $title : "Admin" }}</title>

	<link href="{{ asset('css/lumen_bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/aquiprefeito_site.css') }}" rel="stylesheet">
	<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
	      	<i class="icon-aquiprefeito"></i><b>Aqui</b>Prefeito!
      	</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="navbar-collapse">
	    	@if(Auth::check())
	    	<ul class="nav navbar-nav">
	    		<li><a href="/admin/issue">Problemas</a></li>
	    	</ul>
	      <ul class="nav navbar-nav navbar-right">
	      	<li class="active"><a href="/admin/profile">{{ Auth::user()->name }}</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="icon-menu"></i></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="/auth/logout">Sair</a></li>
	          </ul>
	        </li>
	      </ul>
	      @endif
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container -->
	</nav>

	<div class="container">

		{!! Notification::showAll() !!}

		@yield('content')
	</div>


	<!-- Scripts -->
	@yield('scripts')
	<script src="{{ asset('packages/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ asset('packages/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>
