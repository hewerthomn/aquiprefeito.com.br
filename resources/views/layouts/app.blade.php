<!DOCTYPE html>
<html lang="pt-BR" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title }}</title>

	<meta property="og:locale" content="pt_BR">
	<meta property="og:site_name" content="AquiPrefeito!">
	<meta property="og:url" content="http://aquiprefeito.com.br">
	@if(isset($facebookMeta))
<meta property="og:title" content="{{ $facebookMeta['title'] }}">
	<meta property="og:image" content="{{ $facebookMeta['image'] }}">
	<meta property="og:image:type" content="image/jpeg">
	<meta property="og:image:width" content="520">
	@endif

	<link href="{{ asset('/build/css/app.min.css') }}" rel="stylesheet">
</head>
<body>

	@yield('content')

	<!-- Scripts -->
	@yield('scripts')
	<script src="{{ asset('/build/js/app.min.js') }}"></script>
</body>
</html>
